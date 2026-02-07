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

var createPremiumLabel = function(labelClass, labelText, color) {
    // Definimos el stroke aquí mismo para asegurar que siempre exista
    const blackStroke = "-1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000";
    
    return L.divIcon({
        className: labelClass,
        html: `<div style="font-family: 'Poppins', sans-serif; 
                           font-size: 11px; 
                           
                           letter-spacing: 1.5px; 
                           white-space: nowrap; 
                           color: white; 
                           text-shadow: ${blackStroke}; 
                           ;">
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
            <a href="/caserones/public/estacion/${id}" class="btn-pro-detalles">
                <i class="fas fa-satellite-dish"></i> Ver Estación
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

            if (markers.length > 0) {
                // 1. Obtenemos los límites del grupo de marcadores
                const groupBounds = r.getBounds();
                
                // 2. Aplicamos el fitBounds con padding para la vista
                map.fitBounds(groupBounds, { padding: [50, 50] });

                // 3. BLOQUEO: Creamos límites máximos con un pequeño margen extra (pad) 
                // para que no sea un choque brusco al arrastrar
                map.setMaxBounds(groupBounds.pad(0.2)); 
            }
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
                
                // Bloqueamos el desplazamiento fuera de esta zona
                map.setMaxBounds(groupBounds.pad(0.3));
            }
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
    console.log("🎨 Dibujando capas base y etiquetas geográficas...");

    const stRio = { minWidth: 4, maxWidth: 4, color: "#29439c" };
    const stQuebrada = { minWidth: 2, maxWidth: 2, color: "#87ceeb" };
    const stIndustrial = { fillOpacity: 0.1, weight: 2 };
    const stDeposito = { fillOpacity: 0.4, weight: 3 };

    // 1. Capas Industriales Permanentes (Rajo, Planta, Campamentos)
    if (typeof rajo_caserones !== 'undefined') drawVector(rajo_caserones, {color: '#be0000', fillColor: '#be0000', fillOpacity: 0.05, weight: 3}, "Zona Rajo");
    if (typeof planta_procesos !== 'undefined') drawVector(planta_procesos, {color: '#48FEAC', fillColor: '#48FEAC', fillOpacity: 0.05, weight: 3}, "Planta de Procesos");
    if (typeof campamentos !== 'undefined') drawVector(campamentos, { color: 'red', ...stIndustrial }, "Campamento");

    // 2. Red Hídrica (Ríos principales)
    if (typeof rio !== 'undefined') vincularTooltipInteligente(L.river(rio, stRio).addTo(map), "Río Ramadillas", 'agua');
    if (typeof rio_4 !== 'undefined') vincularTooltipInteligente(L.river(rio_4, stRio).addTo(map), "Río Pulido", 'agua');

    // 3. Quebradas (Listado Dinámico)
    /*const quebradasData = [
        { geo: typeof qdalabrea !== 'undefined' ? qdalabrea : null, lbl: "Qda. La Brea" },
        { geo: typeof q7 !== 'undefined' ? q7 : null, lbl: "Qda. Roco" },
        { geo: typeof q10 !== 'undefined' ? q10 : null, lbl: "Qda. La Escarcha" }
    ];

    

    quebradasData.forEach(q => {
        if (q.geo) {
            let qLayer = L.river(q.geo, stQuebrada).addTo(map);
            vincularTooltipInteligente(qLayer, q.lbl, 'agua'); 
        }
    });*/


    // 1. Definición de la lista completa
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
    { geo: typeof q11 !== 'undefined' ? q11 : null  },
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

// 2. Renderizado con validación y replicación
quebradasData.forEach(q => {
    // Solo dibujamos si la variable existe y tiene coordenadas
    if (q.geo && q.geo.length > 0) {
        // Dibujamos en el mapa principal
        let qLayer = L.river(q.geo, stQuebrada).addTo(map);
        
        // Si tiene nombre (lbl), vinculamos el tooltip cristalino
        if (q.lbl) {
            vincularTooltipInteligente(qLayer, q.lbl, 'agua'); 
        }

        // OPCIONAL: Si estás usando el minimapa, agrégalo también
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

    // 5. ETIQUETAS GEOGRÁFICAS FIJAS (GeoLabels)
    // Estas se dibujan al final para quedar sobre los vectores
    const geoLabels = [
        {coords: [-28.1988, -69.4750], txt: 'CHILE', col: '#ff4d4d', cls: 'label-geo-country'},
        {coords: [-28.2073, -69.4689], txt: 'ARGENTINA', col: '#ff4d4d', cls: 'label-geo-country'},
        {coords: [-28.1193, -69.6939], txt: 'Río Ramadillas', col: '#87ceeb', cls: 'label-geo-water'},
        {coords: [-28.1364, -69.7703], txt: 'Río Pulido', col: '#87ceeb', cls: 'label-geo-water'},
        {coords: [-28.0919, -69.7424], txt: 'Río Vizcachas', col: '#87ceeb', cls: 'label-geo-water'},
       
    ];

    geoLabels.forEach(l => {
        // Usamos la función premium que definimos para mantener la sombra negra y fuente Poppins
        L.marker(l.coords, {
            icon: createPremiumLabel(l.cls, l.txt, l.col), 
            interactive: false 
        }).addTo(map);
    });

    if (typeof frontera !== 'undefined') L.polyline(frontera, { color: 'red', dashArray: '10, 10', weight: 2 }).addTo(map);
}

function renderizarCapasBase_OLD() {
    console.log("🎨 Dibujando capas base unificadas...");

    const stRio = { minWidth: 4, maxWidth: 4, color: "#29439c" };
    const stQuebrada = { minWidth: 2, maxWidth: 2, color: "#87ceeb" };
    const stIndustrial = { fillOpacity: 0.1, weight: 2 };
    const stDeposito = { fillOpacity: 0.4, weight: 3 };

    // Capas Industriales Permanentes

    //drawPremiumVector(rajo_caserones, {color: '#be0000', fillColor: '#be0000', fillOpacity: 0.05, weight: 3}, "Zona Rajo");    
   
    if (typeof rajo_caserones !== 'undefined') drawVector(rajo_caserones, {color: '#be0000', fillColor: '#be0000', fillOpacity: 0.05, weight: 3}, "Zona Rajo");
    if (typeof planta_procesos !== 'undefined') drawVector(planta_procesos, {color: '#48FEAC', fillColor: '#be0000', fillOpacity: 0.05, weight: 3}, "Planta de Procesos")
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


     const geoLabels = [
        {coords: [-28.1988, -69.4750], txt: 'CHILE', col: '#ff4d4d', cls: 'labelClass_blue'},
        {coords: [-28.2073, -69.4689], txt: 'ARGENTINA', col: '#ff4d4d', cls: 'labelClass_blue'},
        {coords: [-28.1193, -69.6939], txt: 'Río Ramadillas', col: '#87ceeb', cls: 'labelClass_blue'},
        {coords: [-28.1364, -69.7703], txt: 'Río Pulido', col: '#87ceeb', cls: 'labelClass_blue'},
        {coords: [-28.0919, -69.7424], txt: 'Río Vizcachas', col: '#87ceeb', cls: 'labelClass_blue'},
        {coords: [-28.1458, -69.5957], txt: 'Qda. La Brea', col: '#87ceeb', cls: 'labelClass_blue'},
        {coords: [-28.2006, -69.5706], txt: 'Qda. Caserones', col: '#87ceeb', cls: 'labelClass_blue'}
    ];
    geoLabels.forEach(l => {
        L.marker(l.coords, {icon: createPremiumLabel(l.cls, l.txt, l.col), interactive: false}).addTo(map);
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