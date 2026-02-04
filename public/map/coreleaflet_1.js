/**
 * Variables Globales de Estado
 */
var map, r, SECTOR_ID, SUBSISTEMA_ID;

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

    if (typeof layer.bindTooltip === "function") {
        layer.bindTooltip(contenido, config);
    } else if (typeof layer.bindLabel === "function") {
        layer.bindLabel(contenido, { className: config.className });
    }
}

/**
 * Dibuja vectores aplicando la unificación de Tooltips
 */
function drawVector(coords, style, label, tipo = 'industrial') {
    if (typeof coords === 'undefined' || !coords || coords.length === 0) return;
    
    var layer = (style.fillColor) ? L.polygon(coords, style) : L.polyline(coords, style);
    layer.addTo(map);

    if (label) {
        vincularTooltipInteligente(layer, label, tipo);
    }
    return layer;
}

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
            <a href="/caserones/public/estacion/${id}" class="btn-pro-detalles">
                <i class="fas fa-satellite-dish"></i> Ficha Estación
            </a>
        </div>
    `;

    return L.marker(latlng, { icon: icon })
            .bindPopup(popupContent, {
                offset: [0, -32],
                closeButton: false, 
                minWidth: 130,
                className: 'modern-action-popup'
            });
}

// --- 2. LÓGICA DE CARGA ASÍNCRONA (AJAX) ---

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
            if (markers.length > 0) map.fitBounds(r.getBounds().pad(0.1));
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
            if (data.length > 0) map.fitBounds(r.getBounds().pad(0.1));
        }
    });
}

/**
 * Función para navegar sin recargar la página (F5)
 */
function cambiarSectorManual(nuevoId) {
    const nuevaUrl = `/caserones/public/sector/${nuevoId}`;
    window.history.pushState({}, '', nuevaUrl);
    SECTOR_ID = nuevoId;
    SUBSISTEMA_ID = null; 
    loadMarkersGlobal(nuevoId);
}

// --- 3. RENDERIZADO MAESTRO DE CAPAS BASE ---

function renderizarCapasBase() {
    console.log("🎨 Dibujando capas base unificadas...");

    const stRio = { minWidth: 4, maxWidth: 4, color: "#29439c" };
    const stQuebrada = { minWidth: 2, maxWidth: 2, color: "#87ceeb" };
    const stIndustrial = { fillOpacity: 0.1, weight: 2 };
    const stDeposito = { fillOpacity: 0.4, weight: 1 };

    // Capas Industriales Permanentes
    if (typeof rajo_caserones !== 'undefined') drawVector(rajo_caserones, { color: '#be0000', ...stIndustrial }, "Zona Rajo");
    if (typeof planta_procesos !== 'undefined') drawVector(planta_procesos, { color: '#48FEAC', ...stIndustrial }, "Planta de Procesos");
    if (typeof campamentos !== 'undefined') drawVector(campamentos, { color: 'red', ...stIndustrial }, "Campamento");

    // Red Hídrica
    if (typeof rio !== 'undefined') vincularTooltipInteligente(L.river(rio, stRio).addTo(map), "Río Ramadillas", 'agua');
    if (typeof rio_4 !== 'undefined') vincularTooltipInteligente(L.river(rio_4, stRio).addTo(map), "Río Pulido", 'agua');

    const quebradasData = [
        { geo: typeof qdalabrea !== 'undefined' ? qdalabrea : null, lbl: "Qda. La Brea" },
        { geo: typeof q7 !== 'undefined' ? q7 : null, lbl: "Qda. Roco" },
        { geo: typeof q10 !== 'undefined' ? q10 : null, lbl: "Qda. La Escarcha" }
    ];

    quebradasData.forEach(q => {
        if (q.geo) {
            let qLayer = L.river(q.geo, stQuebrada).addTo(map);
            vincularTooltipInteligente(qLayer, q.lbl, 'agua'); 
        }
    });

    // Polígonos por Sector con navegación inteligente al clic
   if (typeof deposito_lamas !== 'undefined') {
    let lamas = drawVector(deposito_lamas, { color: '#66023C', fillColor: '#66023C', ...stDeposito }, 'Depósito de Lamas', 'industrial');
    
    // Forzamos el evento Click
    lamas.on('click', function(e) {
        console.log("📍 Clic detectado en Lamas");
        cambiarSectorManual("1");
    });

    // Forzamos el puntero
    lamas.on('mouseover', function(e) {
        if (e.target._path) e.target._path.style.cursor = 'pointer';
    });
}

if (typeof arenas !== 'undefined') {
    let arenaLayer = drawVector(arenas, { color: '#f77f00', fillColor: '#f77f00', ...stDeposito }, 'Depósito de Arenas', 'industrial');
    
    arenaLayer.on('click', function(e) {
        console.log("📍 Clic detectado en Arenas");
        cambiarSectorManual("2");
    });

    arenaLayer.on('mouseover', function(e) {
        if (e.target._path) e.target._path.style.cursor = 'pointer';
    });
}

if (typeof deposito_lastre !== 'undefined') {
    let lastre = drawVector(deposito_lastre, { color: '#FFFF5C', fillColor: '#FFFF5C', ...stDeposito }, 'Depósito de Lastre', 'industrial');
    
    lastre.on('click', function(e) {
        console.log("📍 Clic detectado en Lastre");
        cambiarSectorManual("4");
    });

    lastre.on('mouseover', function(e) {
        if (e.target._path) e.target._path.style.cursor = 'pointer';
    });
}

    if (typeof frontera !== 'undefined') L.polyline(frontera, { color: 'red', dashArray: '10, 10', weight: 2 }).addTo(map);
}

// --- 4. INTERCEPTOR DE NAVEGACIÓN INTELIGENTE (Sidebar) ---

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
           // e.preventDefault();
            window.history.pushState({}, '', href);
            SUBSISTEMA_ID = nSub;
            if (SUBSISTEMA_ID) loadMarkersBySubsistema(SUBSISTEMA_ID);
            else loadMarkersGlobal(SECTOR_ID);
        }
    }
});


function cambiarSectorManual(nuevoId) {
    // Intentamos primero la navegación fluida (AJAX)
    const nuevaUrl = `/caserones/public/sector/${nuevoId}`;
    console.log("🚀 Intentando navegar a:", nuevaUrl);

    // Si el sector es distinto al actual, forzamos recarga para limpiar todo el ambiente
    if (nuevoId !== SECTOR_ID) {
        window.location.href = nuevaUrl;
    } else {
        // Si es el mismo, solo actualizamos marcadores
        window.history.pushState({}, '', nuevaUrl);
        loadMarkersGlobal(nuevoId);
    }
}

// --- 5. INICIALIZACIÓN (F5) ---

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