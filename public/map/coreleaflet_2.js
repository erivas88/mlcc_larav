/**
 * Variables Globales de Estado
 */
var map, r, SECTOR_ID, SUBSISTEMA_ID;
var searchControl; // Variable para el control del buscador

// --- 1. HERRAMIENTAS DE UNIFICACIÓN VISUAL ---

function vincularTooltipInteligente(layer, texto, tipo = 'industrial') {
    if (!texto || !layer) return;

    const claseColor = (tipo === 'agua') ? 'text-agua' : 'text-industrial';
    const contenido = `<span class="label-master ${claseColor}">${texto}</span>`;

    const config = {
        sticky: true,
        direction: 'auto',
        offset: [10, 0],
        className: 'custom-tooltip-master' 
    };

    try {
        if (typeof layer.bindTooltip === "function") {
            layer.bindTooltip(contenido, config);
        }
    } catch(e) {
        console.warn("Reintentando vincular tooltip para: " + texto);
    }
}

function drawVector(coords, style, label, tipo = 'industrial') {
    if (typeof coords === 'undefined' || !coords || coords.length === 0) return;
    var layer = (style.fillColor) ? L.polygon(coords, style) : L.polyline(coords, style);
    layer.addTo(map);
    if (label) vincularTooltipInteligente(layer, label, tipo);
    return layer;
}

var createPremiumLabel = function(labelClass, labelText, color) {
    const blackStroke = "-1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000";
    return L.divIcon({
        className: labelClass,
        html: `<div style="font-family: 'Poppins', sans-serif; font-size: 11px; letter-spacing: 1.5px; 
                           white-space: nowrap; color: white; text-shadow: ${blackStroke};">
                    ${labelText}
               </div>`,
        iconSize: [0, 0], iconAnchor: [0, 0]
    });
};

function createFullMarker(latlng, color, nombre, id) {
    const blackStroke = "-1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000";
    const icon = L.divIcon({
        className: 'marker-combined',
        html: `
            <div style="display: flex; flex-direction: column; align-items: center; transform: translate(-50%, -100%);">
                <i class="fas fa-map-marker-alt" style="color: ${color}; font-size: 20px; text-shadow: ${blackStroke}; filter: drop-shadow(0px 2px 2px rgba(0,0,0,0.5));"></i>
                <span style="margin-top: 1px; white-space: nowrap; font-weight: 700; font-size: 9px; color: ${color}; text-shadow: ${blackStroke}; text-transform: uppercase;">
                    ${nombre}
                </span>
            </div>`,
        iconSize: [0, 0]
    });
    
    const popupContent = `<div class="popup-action-container"><a href="/caserones/public/estacion/${id}" class="btn-pro-detalles"><i class="fas fa-satellite-dish"></i> Ver Estación</a></div>`;

    return L.marker(latlng, { 
        icon: icon,
        title: nombre // CLAVE: Propiedad para el buscador
    }).bindPopup(popupContent, { offset: [0, -32], closeButton: false, minWidth: 130, className: 'modern-action-popup' });
}

// --- 2. FUNCIONALIDAD DEL BUSCADOR ---

function actualizarBuscador() {
    // Si ya existe un buscador, lo eliminamos para evitar duplicados en el mapa
    if (searchControl) {
        map.removeControl(searchControl);
    }

    // Solo creamos el buscador si hay marcadores en la capa 'r'
    if (r && r.getLayers().length > 0) {
        searchControl = new L.Control.Search({
            layer: r,
            propertyName: 'title', // Debe coincidir con el 'title' del marcador
            marker: false,
            initial: false,
            zoom: 16,
            position: 'bottomleft',
            textPlaceholder: 'Buscar estación...',
            moveToLocation: function(latlng, title, map) {
                map.setView(latlng, 16);
                // Abrir el popup automáticamente al encontrarlo
                r.getLayers().forEach(layer => {
                    if(layer.options.title === title) layer.openPopup();
                });
            }
        });
        map.addControl(searchControl);
    }
}

// --- 3. LÓGICA AJAX ---

function loadMarkersBySubsistema(idSub) {
    $.ajax({
        url: "/caserones/public/api/get-sector-markers",
        type: "POST",
        data: { sector: SECTOR_ID, subsistema: idSub },
        dataType: "JSON",
        success: function(response) {
            if (r) map.removeLayer(r); 
            const markers = response.data.map(st => createFullMarker([st.latitud, st.longitud], st.color, st.estacion, st.id));
            r = L.featureGroup(markers).addTo(map);

            if (markers.length > 0) {
                const groupBounds = r.getBounds();
                map.fitBounds(groupBounds, { padding: [50, 50] });
                map.setMaxBounds(groupBounds.pad(0.2)); 
            }
            actualizarBuscador(); // Actualizamos el buscador con los nuevos datos
        }
    });
}

function loadMarkersGlobal(idSec) {
    $.ajax({
        url: "/caserones/public/api/get-markers",
        type: "POST",
        data: { sector: idSec },
        dataType: "JSON",
        success: function(data) {
            if (r) map.removeLayer(r);
            const markers = data.map(st => createFullMarker([st.latitud, st.longitud], st.color, st.estacion, st.id));
            r = L.featureGroup(markers).addTo(map);

            if (data.length > 0) {
                const groupBounds = r.getBounds();
                map.fitBounds(groupBounds, { padding: [80, 80] });
                map.setMaxBounds(groupBounds.pad(0.3));
            }
            actualizarBuscador(); // Actualizamos el buscador con los nuevos datos
        }
    });
}

// --- 4. RENDERIZADO CAPAS BASE (HIDRICA Y POLIGONOS) ---

function renderizarCapasBase() {
    console.log("🎨 Dibujando capas base...");

    const stRio = { minWidth: 4, maxWidth: 4, color: "#29439c" };
    const stQuebrada = { minWidth: 2, maxWidth: 2, color: "#87ceeb" };
    const stIndustrial = { fillOpacity: 0.1, weight: 2 };
    const stDeposito = { fillOpacity: 0.4, weight: 3 };

    // Capas Industriales
    if (typeof rajo_caserones !== 'undefined') drawVector(rajo_caserones, {color: '#be0000', fillColor: '#be0000', fillOpacity: 0.05, weight: 3}, "Zona Rajo");
    if (typeof planta_procesos !== 'undefined') drawVector(planta_procesos, {color: '#48FEAC', fillColor: '#48FEAC', fillOpacity: 0.05, weight: 3}, "Planta de Procesos");
    if (typeof campamentos !== 'undefined') drawVector(campamentos, { color: 'red', ...stIndustrial }, "Campamento");

    // Red Hídrica
    if (typeof rio !== 'undefined') vincularTooltipInteligente(L.river(rio, stRio).addTo(map), "Río Ramadillas", 'agua');
    if (typeof rio_4 !== 'undefined') vincularTooltipInteligente(L.river(rio_4, stRio).addTo(map), "Río Pulido", 'agua');

    // Quebradas
    const quebradasData = [
        { geo: typeof qdalabrea !== 'undefined' ? qdalabrea : null, lbl: "Qda. La Brea" },
        { geo: typeof q7 !== 'undefined' ? q7 : null, lbl: "Quebrada Roco" },
        { geo: typeof q10 !== 'undefined' ? q10 : null, lbl: "Quebrada La Escarcha" },
        { geo: typeof q14 !== 'undefined' ? q14 : null, lbl: "Quebrada Caserones" }
        // ... (el resto de tus q2-q24 si están definidas como variables globales)
    ];

    quebradasData.forEach(q => {
        if (q.geo && q.geo.length > 0) {
            let qLayer = L.river(q.geo, stQuebrada).addTo(map);
            if (q.lbl) vincularTooltipInteligente(qLayer, q.lbl, 'agua'); 
        }
    });

    // Depósitos con Navegación
    const depositosCfg = [
        { geo: typeof deposito_lamas !== 'undefined' ? deposito_lamas : null, id: "1", color: '#66023C', name: 'Depósito de Lamas' },
        { geo: typeof arenas !== 'undefined' ? arenas : null, id: "2", color: '#f77f00', name: 'Depósito de Arenas' },
        { geo: typeof deposito_lastre !== 'undefined' ? deposito_lastre : null, id: "4", color: '#FFFF5C', name: 'Depósito de Lastre' }
    ];

    depositosCfg.forEach(d => {
        if (d.geo) {
            let layer = drawVector(d.geo, { color: d.color, fillColor: d.color, ...stDeposito }, d.name, 'industrial');
            layer.on('click', () => cambiarSectorManual(d.id));
            layer.on('mouseover', (e) => { if (e.target._path) e.target._path.style.cursor = 'pointer'; });
        }
    });

    // GeoLabels
    const geoLabels = [
        {coords: [-28.1988, -69.4750], txt: 'CHILE', col: '#ff4d4d', cls: 'label-geo-country'},
        {coords: [-28.2073, -69.4689], txt: 'ARGENTINA', col: '#ff4d4d', cls: 'label-geo-country'},
        {coords: [-28.1193, -69.6939], txt: 'Río Ramadillas', col: '#87ceeb', cls: 'label-geo-water'},
        {coords: [-28.1458, -69.5957], txt: 'Qda. La Brea', col: '#87ceeb', cls: 'labelClass_blue'}
    ];

    geoLabels.forEach(l => {
        L.marker(l.coords, { icon: createPremiumLabel(l.cls, l.txt, l.col), interactive: false }).addTo(map);
    });

    if (typeof frontera !== 'undefined') L.polyline(frontera, { color: 'red', dashArray: '10, 10', weight: 2 }).addTo(map);
}

// --- 5. NAVEGACIÓN ---

function cambiarSectorManual(nuevoId) {
    const nuevaUrl = `/caserones/public/sector/${nuevoId}`;
    if (nuevoId !== SECTOR_ID) {
        window.location.href = nuevaUrl;
    } else {
        window.history.pushState({}, '', nuevaUrl);
        loadMarkersGlobal(nuevoId);
    }
}

// --- 6. INICIALIZACIÓN ---

window.onload = function() {
    const segments = window.location.pathname.split('/').filter(s => s !== "");
    const sIdx = segments.indexOf('sector');
    if (sIdx !== -1) {
        SECTOR_ID = segments[sIdx + 1] || null;
        SUBSISTEMA_ID = segments[sIdx + 2] || null;
    }

    map = L.map("mapid", { center: [-28.147151, -69.645], zoom: 12, attributionControl: false });
    L.tileLayer("https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}").addTo(map);

    renderizarCapasBase();

    if (SECTOR_ID) {
        if (SUBSISTEMA_ID) loadMarkersBySubsistema(SUBSISTEMA_ID);
        else loadMarkersGlobal(SECTOR_ID);
    }
};