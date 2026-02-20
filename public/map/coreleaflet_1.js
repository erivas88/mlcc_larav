/**
 * Variables Globales de Estado
 */
var map, r, SECTOR_ID, SUBSISTEMA_ID;
var searchControl; // Control para el buscador
var currentBaseLayer; // Variable global para almacenar la capa base actual

// --- 1. HERRAMIENTAS DE UNIFICACIÓN VISUAL ---

/**
 * Vincula Tooltips con estética cartográfica (Title Case e Itálicas para agua)
 */
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

    // FIX: Intentamos bindear, si falla por ciclo de vida de Leaflet, lo capturamos
    try {
        if (typeof layer.bindTooltip === "function") {
            layer.bindTooltip(contenido, config);
        } else if (typeof layer.bindLabel === "function") {
            layer.bindLabel(contenido, { className: config.className });
        }
    } catch(e) {
        console.warn("Reintentando vincular tooltip para: " + texto);
    }
}

/**
 * Dibuja vectores aplicando la unificación de Tooltips
 */
function drawVector(coords, style, label, tipo = 'industrial') {
    if (typeof coords === 'undefined' || !coords || coords.length === 0) return;
    
    var layer = (style.fillColor) ? L.polygon(coords, style) : L.polyline(coords, style);
    
    // IMPORTANTE: Primero añadir al mapa para que el objeto se inicialice
    layer.addTo(map);

    if (label) {
        vincularTooltipInteligente(layer, label, tipo);
    }
    return layer;
}

var createPremiumLabel = function(labelClass, labelText, color) {
    const blackStroke = "-1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000";
    
    return L.divIcon({
        className: labelClass,
        html: `<div style="font-family: 'Poppins', sans-serif; 
                           font-size: 11px; 
                           letter-spacing: 1.5px; 
                           white-space: nowrap; 
                           color: white; 
                           text-shadow: ${blackStroke};">
                    ${labelText}
               </div>`,
        iconSize: [0, 0],
        iconAnchor: [0, 0]
    });
};

/**
 * Crea marcadores con Popup Estético de Acción (Ficha Estación)
 */
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
    
    const popupContent = `
        <div class="popup-action-container">
            <a href="/estacion/${id}" class="btn-pro-detalles">
                <i class="fas fa-satellite-dish"></i> Ver Estación
            </a>
        </div>
    `;

    return L.marker(latlng, { 
        icon: icon,
        title: nombre // Atributo clave para el buscador
    }).bindPopup(popupContent, {
        offset: [0, -32],
        closeButton: false, 
        minWidth: 130,
        className: 'modern-action-popup'
    });
}

// --- 2. LÓGICA DEL BUSCADOR ---

function actualizarBuscador() {
    if (searchControl) map.removeControl(searchControl);
    if (r && r.getLayers().length > 0) {
        searchControl = new L.Control.Search({
            layer: r,
            propertyName: 'title',
            marker: false,
            moveToLocation: function(latlng, title, map) {
                map.setView(latlng, 16);
                r.getLayers().forEach(layer => {
                    if(layer.options.title === title) layer.openPopup();
                });
            },
            position: 'topleft',
            initial: false,
            zoom: 16,
            textPlaceholder: 'Buscar estación...'
        });
        map.addControl(searchControl);
    }
}

// --- 3. LÓGICA DE CARGA ASÍNCRONA (AJAX) ---

function loadMarkersBySubsistema(idSub) {
    $.ajax({
        url: "/api/get-sector-markers",
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
            actualizarBuscador();
        }
    });
}

function loadMarkersGlobal(idSec) {
    $.ajax({
        url: "/api/get-markers",
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
            actualizarBuscador();
        }
    });
}

// --- 4. RENDERIZADO MAESTRO DE CAPAS BASE ---

function renderizarCapasBase() {
    console.log("🎨 Dibujando capas base y etiquetas geográficas...");

    const stRio = { minWidth: 4, maxWidth: 4, color: "#29439c" };
    const stQuebrada = { minWidth: 2, maxWidth: 2, color: "#87ceeb" };
    const stIndustrial = { fillOpacity: 0.1, weight: 2 };
    const stDeposito = { fillOpacity: 0.4, weight: 3 };

    // 1. Capas Industriales Permanentes
    if (typeof rajo_caserones !== 'undefined') drawVector(rajo_caserones, {color: '#be0000', fillColor: '#be0000', fillOpacity: 0.05, weight: 3}, "Zona Rajo");
    if (typeof planta_procesos !== 'undefined') drawVector(planta_procesos, {color: '#48FEAC', fillColor: '#48FEAC', fillOpacity: 0.05, weight: 3}, "Planta de Procesos");
    if (typeof campamentos !== 'undefined') drawVector(campamentos, { color: 'red', ...stIndustrial }, "Campamento");

    // 2. Red Hídrica
    if (typeof rio !== 'undefined') vincularTooltipInteligente(L.river(rio, stRio).addTo(map), "Río Ramadillas", 'agua');
    if (typeof rio_4 !== 'undefined') vincularTooltipInteligente(L.river(rio_4, stRio).addTo(map), "Río Pulido", 'agua');

    // 3. Quebradas (Tu listado completo q1 - q24)
    const quebradasData = [
        { geo: typeof qdalabrea !== 'undefined' ? qdalabrea : null, lbl: "Qda. La Brea" },
        { geo: typeof q2 !== 'undefined' ? q2 : null },
        { geo: typeof q3 !== 'undefined' ? q3 : null },
        { geo: typeof q4 !== 'undefined' ? q4 : null },
        { geo: typeof q5 !== 'undefined' ? q5 : null },
        { geo: typeof q6 !== 'undefined' ? q6 : null },
        { geo: typeof q7 !== 'undefined' ? q7 : null, lbl: "Quebrada Roco" },
        { geo: typeof q8 !== 'undefined' ? q8 : null, lbl: "Quebrada La Brea" },
        { geo: typeof q9 !== 'undefined' ? q9 : null, lbl: "Quebrada Roco" },
        { geo: typeof q10 !== 'undefined' ? q10 : null, lbl: "Quebrada La Escarcha" },
        { geo: typeof q11 !== 'undefined' ? q11 : null },
        { geo: typeof q12 !== 'undefined' ? q12 : null },
        { geo: typeof q13 !== 'undefined' ? q13 : null },
        { geo: typeof q14 !== 'undefined' ? q14 : null ,lbl: "Quebrada Caserones" },
        { geo: typeof q16 !== 'undefined' ? q16 : null },
        { geo: typeof q18 !== 'undefined' ? q18 : null },
        { geo: typeof q19 !== 'undefined' ? q19 : null },
        { geo: typeof q20 !== 'undefined' ? q20 : null },
        { geo: typeof q21 !== 'undefined' ? q21 : null },
        { geo: typeof q22 !== 'undefined' ? q22 : null },
        { geo: typeof q23 !== 'undefined' ? q23 : null },
        { geo: typeof q24 !== 'undefined' ? q24 : null }
    ];

    quebradasData.forEach(q => {
        if (q.geo && q.geo.length > 0) {
            let qLayer = L.river(q.geo, stQuebrada).addTo(map);
            if (q.lbl) vincularTooltipInteligente(qLayer, q.lbl, 'agua'); 
            if (typeof overlaysMinimap !== 'undefined') {
                L.river(q.geo, { ...stQuebrada, minWidth: 1, maxWidth: 1 }).addTo(overlaysMinimap);
            }
        }
    });

    // 4. Polígonos con Navegación (Depósitos)
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

    // 5. GeoLabels
    const geoLabels = [
        {coords: [-28.1988, -69.4750], txt: 'CHILE', col: '#ff4d4d', cls: 'label-geo-country'},
        {coords: [-28.2073, -69.4689], txt: 'ARGENTINA', col: '#ff4d4d', cls: 'label-geo-country'},
        {coords: [-28.1193, -69.6939], txt: 'Río Ramadillas', col: '#87ceeb', cls: 'label-geo-water'},
        {coords: [-28.1364, -69.7703], txt: 'Río Pulido', col: '#87ceeb', cls: 'label-geo-water'},
        {coords: [-28.0919, -69.7424], txt: 'Río Vizcachas', col: '#87ceeb', cls: 'label-geo-water'},
        {coords: [-28.1458, -69.5957], txt: 'Qda. La Brea', col: '#87ceeb', cls: 'labelClass_blue'},
        {coords: [-28.2006, -69.5706], txt: 'Qda. Caserones', col: '#87ceeb', cls: 'labelClass_blue'}
    ];

    geoLabels.forEach(l => {
        L.marker(l.coords, {
            icon: createPremiumLabel(l.cls, l.txt, l.col), 
            interactive: false 
        }).addTo(map);
    });

    if (typeof frontera !== 'undefined') L.polyline(frontera, { color: 'red', dashArray: '10, 10', weight: 2 }).addTo(map);
}

// --- 5. INTERCEPTOR DE NAVEGACIÓN (Sidebar) ---

document.addEventListener('click', function(e) {
    const link = e.target.closest('a');
    if (!link) return;

    const href = link.getAttribute('href');
    if (href && href.includes('/sector/')) {
        const segments = href.split('/').filter(s => s !== "");
        const sIdx = segments.indexOf('sector');
        const nSector = segments[sIdx + 1];
        const nSub = segments[sIdx + 2] || null;

        if (nSector === SECTOR_ID) {
            window.history.pushState({}, '', href);
            SUBSISTEMA_ID = nSub;
            if (SUBSISTEMA_ID) loadMarkersBySubsistema(SUBSISTEMA_ID);
            else loadMarkersGlobal(SECTOR_ID);
        }
    }
});

function cambiarSectorManual(nuevoId) {
    const nuevaUrl = `/sector/${nuevoId}`;
    if (nuevoId !== SECTOR_ID) {
        window.location.href = nuevaUrl;
    } else {
        window.history.pushState({}, '', nuevaUrl);
        loadMarkersGlobal(nuevoId);
    }
}

// --- 6. INICIALIZACIÓN --- 
var baseLayer = L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
});

var satelliteLayer = L.tileLayer("https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}", {
    attribution: '&copy; <a href="https://www.esri.com">ESRI</a>'
});

// Variable global para la capa base actual

// Función para cambiar la capa base
function cambiarCapaMapa() {
    var mapaSeleccionado = document.querySelector('input[name="map-style"]:checked').value;

    // Cambiar solo la capa base actual, sin eliminar las otras capas (marcadores, polígonos, etc.)
    if (mapaSeleccionado === "mapa" && currentBaseLayer !== baseLayer) {
        map.removeLayer(currentBaseLayer);  // Eliminar la capa base actual
        map.addLayer(baseLayer);  // Añadir la capa estándar
        currentBaseLayer = baseLayer;  // Actualizar la capa base actual
    } else if (mapaSeleccionado === "satelite" && currentBaseLayer !== satelliteLayer) {
        map.removeLayer(currentBaseLayer);  // Eliminar la capa base actual
        map.addLayer(satelliteLayer);  // Añadir la capa satelital
        currentBaseLayer = satelliteLayer;  // Actualizar la capa base actual
    }
}

// Event listener para los cambios en los botones de radio
document.querySelectorAll('input[name="map-style"]').forEach(function(radio) {
    radio.addEventListener('change', cambiarCapaMapa);
});

// Inicialización del mapa y carga de capas
window.onload = function() {
    const segments = window.location.pathname.split('/').filter(s => s !== "");
    const sIdx = segments.indexOf('sector');
    if (sIdx !== -1) {
        SECTOR_ID = segments[sIdx + 1] || null;
        SUBSISTEMA_ID = segments[sIdx + 2] || null;
    }

    // Inicializa el mapa y define su vista
    map = L.map("mapid", { center: [-28.147151, -69.645], zoom: 12, zoomControl: false, attributionControl: false });
    
    // Establecer la capa satelital como la capa base predeterminada
    currentBaseLayer = satelliteLayer;  // Establecer la capa predeterminada
    currentBaseLayer.addTo(map);  // Agregar la capa al mapa

    // Agregar control de zoom
    L.control.zoom({
        position: 'bottomright' // Opciones: 'topleft', 'topright', 'bottomleft', 'bottomright'
    }).addTo(map);

    renderizarCapasBase();  // Función para dibujar las capas de objetos (polígonos, marcadores, etc.)

    // Cargar los marcadores y capas correspondientes
    if (SECTOR_ID) {
        if (SUBSISTEMA_ID) loadMarkersBySubsistema(SUBSISTEMA_ID);
        else loadMarkersGlobal(SECTOR_ID);
    }
};