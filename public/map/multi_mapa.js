/* ============================================================
   TOOLTIP INTELIGENTE
============================================================ */

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
        } else if (typeof layer.bindLabel === "function") {
            layer.bindLabel(contenido, { className: config.className });
        }
    } catch(e) {
        console.warn("Error al vincular tooltip para: " + texto, e);
    }
}


/* ============================================================
   DRAW VECTOR GLOBAL
============================================================ */

function drawVector(map, coords, style, label, tipo = 'industrial') {

    if (!coords || coords.length === 0 || !map) return;

    let layer;

    if (style.minWidth && typeof L.river === 'function') {
        layer = L.river(coords, style);
    } else {
        layer = (style.fillColor !== undefined && style.fillColor !== '')
            ? L.polygon(coords, style)
            : L.polyline(coords, style);
    }

    layer.addTo(map);

    if (label) {
        vincularTooltipInteligente(layer, label, tipo);
    }

    return layer;
}


/* ============================================================
   MAP ENGINE MODULAR
============================================================ */

function crearMapaBase(container, config) {

    return L.map(container, {
        center: [config.lat, config.lon],
        zoom: 14,
        attributionControl: false,
        zoomControl: false,
        dragging: false,
        scrollWheelZoom: false,
        doubleClickZoom: false,
        boxZoom: false,
        keyboard: false,
        touchZoom: false
    });

}


function agregarTileLayer(map) {

    L.tileLayer(
        "https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}",
        {
            maxZoom: 18,
            reuseTiles: true,
            updateWhenIdle: true
        }
    ).addTo(map);

}


function agregarCapasIndustriales(map) {

    if (typeof rajo_caserones !== "undefined")
        drawVector(map, rajo_caserones,
            { color:'#be0000', fillColor:'#be0000', fillOpacity:0.05, weight:3 },
            "Zona Rajo"
        );

    if (typeof planta_procesos !== "undefined")
        drawVector(map, planta_procesos,
            { color:'#48FEAC', fillColor:'#48FEAC', fillOpacity:0.05, weight:3 },
            "Planta de Procesos"
        );

    if (typeof campamentos !== "undefined")
        drawVector(map, campamentos,
            { color:'red', weight:2 },
            "Campamento"
        );

    if (typeof portones !== "undefined")
        drawVector(map, portones,
            { color:'red', weight:2 },
            "Acceso"
        );
}


function agregarDepositos(map) {

    const stLamas  = { color:'#66023C', fillColor:'#66023C', fillOpacity:0.4, weight:2 };
    const stLastre = { color:'#FFFF5C', fillColor:'#FFFF5C', fillOpacity:0.4, weight:2 };
    const stArenas = { color:'#f77f00', fillColor:'#f77f00', fillOpacity:0.4, weight:2 };

    if (typeof deposito_lamas !== "undefined")
        drawVector(map, deposito_lamas, stLamas, "Depósito de Lamas");

    if (typeof deposito_lastre !== "undefined")
        drawVector(map, deposito_lastre, stLastre, "Depósito de Lastre");

    if (typeof arenas !== "undefined")
        drawVector(map, arenas, stArenas, "Depósito de Arenas");
}


function agregarMarcadorEstacion(map, config) {

    const markerIcon = L.divIcon({
        className: 'marker-combined',
        html: `
            <div style="display:flex;flex-direction:column;align-items:center;transform:translate(-50%,-100%);">
                <i class="fas fa-map-marker-alt"
                   style="color:${config.color};font-size:24px;
                   text-shadow:-1px -1px 0 #000,1px -1px 0 #000,-1px 1px 0 #000,1px 1px 0 #000;">
                </i>
                <span style="margin-top:2px;white-space:nowrap;font-weight:700;font-size:10px;
                color:${config.color};
                text-shadow:-1px -1px 0 #000,1px -1px 0 #000,-1px 1px 0 #000,1px 1px 0 #000;
                font-family:Arial;letter-spacing:0.5px;text-transform:uppercase;">
                    ${config.nombre}
                </span>
            </div>`,
        iconSize: [0,0],
        iconAnchor: [0,0]
    });

    L.marker([config.lat, config.lon], {
        icon: markerIcon,
        interactive: false
    }).addTo(map);
}


function agregarRedHidrica(map) {

    if (!map) return;

    // ==========================
    // ESTILOS
    // ==========================

    const stRio = { minWidth: 4, maxWidth: 4, color: "#29439c" };
    const stQuebrada = { minWidth: 2, maxWidth: 2, color: "#87ceeb" };

    // ==========================
    // RÍOS PRINCIPALES
    // ==========================

    const rios = [
        { geo: typeof rio !== 'undefined' ? rio : null },
        { geo: typeof rio_4 !== 'undefined' ? rio_4 : null, lbl: "Río Pulido" },
        { geo: typeof rio_5 !== 'undefined' ? rio_5 : null }
    ];

    rios.forEach(r => {
        if (r.geo && r.geo.length > 0) {

            let layer;

            if (typeof L.river === 'function') {
                layer = L.river(r.geo, stRio).addTo(map);
            } else {
                layer = L.polyline(r.geo, stRio).addTo(map);
            }

            if (r.lbl) {
                vincularTooltipInteligente(layer, r.lbl, 'agua');
            }
        }
    });

    // ==========================
    // QUEBRADAS
    // ==========================

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
        { geo: typeof q14 !== 'undefined' ? q14 : null, lbl: "Quebrada Caserones" },
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

            let qLayer;

            if (typeof L.river === 'function') {
                qLayer = L.river(q.geo, stQuebrada).addTo(map);
            } else {
                qLayer = L.polyline(q.geo, stQuebrada).addTo(map);
            }

            if (q.lbl) {
                vincularTooltipInteligente(qLayer, q.lbl, 'agua');
            }
        }

    });

}


/* ============================================================
   INIT PRINCIPAL
============================================================ */

function initMapEstacion(config, mapId = 'map-detail') {

    const container = document.getElementById(mapId);
    const spinner = document.getElementById('map-spinner');

    if (!container) {
        console.warn(`Contenedor no encontrado: ${mapId}`);
        return null;
    }

    if (!config || config.lat == null || config.lon == null) {
        console.warn("Coordenadas inválidas");
        return null;
    }

    // Evitar reinicialización
    if (container._leaflet_id) {
        return window._maps ? window._maps[mapId] : null;
    }

    if (spinner) spinner.style.display = 'block';

    const map = crearMapaBase(container, config);

    if (!window._maps) window._maps = {};
    window._maps[mapId] = map;

    agregarTileLayer(map);
    agregarCapasIndustriales(map);
    agregarDepositos(map);
    agregarRedHidrica(map);
    agregarMarcadorEstacion(map, config);

    if (spinner) spinner.style.display = 'none';

    setTimeout(() => map.invalidateSize(), 500);

    return map;
}