/**
 * 1. FUNCIONES DE APOYO (Definidas primero para que estén disponibles)
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

function drawVector(map, coords, style, label, tipo = 'industrial') {
    // Validamos que existan coordenadas y que el mapa esté definido
    if (!coords || coords.length === 0 || !map) return;
    
    let layer;

    if (style.minWidth && typeof L.river === 'function') {
        layer = L.river(coords, style);
    } else {
        // Si tiene fillColor es Polígono, si no, es Línea
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

/**
 * 2. FUNCIÓN PRINCIPAL
 */
function initMapEstacion(config) {
    if (!config.lat || !config.lon) {
        console.error("Coordenadas no válidas.");
        return;
    }

    // Instancia del Mapa
    const mapDetail = L.map('map-detail', {
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

    // Capa Satelital
    L.tileLayer("https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}").addTo(mapDetail);

    // --- DIBUJO DE CAPAS ---
    
    // Capas Industriales (Usa el nuevo drawVector pasando mapDetail)
    drawVector(mapDetail, rajo_caserones, {color: '#be0000', fillColor: '#be0000', fillOpacity: 0.05, weight: 3}, "Zona Rajo");
    drawVector(mapDetail, planta_procesos, {color: '#48FEAC', fillColor: '#48FEAC', fillOpacity: 0.05, weight: 3}, "Planta de Procesos");
    drawVector(mapDetail, campamentos, { color: 'red', weight: 2 }, "Campamento");
    drawVector(mapDetail, portones, { color: 'red', weight: 2 }, "Acceso a Faena");
    
    // Depósitos (Polígonos con color de relleno)
    const stLamas = { color: '#66023C', fillColor: '#66023C', fillOpacity: 0.4, weight: 2 };
    const stLastre = { color: '#FFFF5C', fillColor: '#FFFF5C', fillOpacity: 0.4, weight: 2 };
    const stArenas = { color: '#f77f00', fillColor: '#f77f00', fillOpacity: 0.4, weight: 2 };

    drawVector(mapDetail, deposito_lamas, stLamas, 'Depósito de Lamas');
    drawVector(mapDetail, deposito_lastre, stLastre, 'Depósito de Lastre');
    drawVector(mapDetail, arenas, stArenas, 'Depósito de Arenas');

const stRio = { minWidth: 4, maxWidth: 4, color: "#29439c" };



    // Red Hídrica (Ríos y Quebradas)
    const rivSt = { minWidth: 4, maxWidth: 4, color: "#29439c" };
    const queSt = { minWidth: 2, maxWidth: 2, color: "#87ceeb" };

    if (window.rio) [rio, rio_4, rio_5].forEach(v => drawVector(mapDetail, v, rivSt, null, 'agua'));
    vincularTooltipInteligente(L.river(rio_4, stRio).addTo(mapDetail), "Río Pulido", 'agua');
    const stQuebrada = { minWidth: 2, maxWidth: 2, color: "#87ceeb" };
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
            let qLayer = L.river(q.geo, stQuebrada).addTo(mapDetail);
            if (q.lbl) vincularTooltipInteligente(qLayer, q.lbl, 'agua'); 
            if (typeof overlaysMinimap !== 'undefined') {
                L.river(q.geo, { ...stQuebrada, minWidth: 1, maxWidth: 1 }).addTo(mapDetail);
            }
        }
    });

    // Agrupar quebradas para limpiar el código
    //const listaQuebradas = [qdalabrea, q2, q3, q4, q5, q6, q7, q8, q9, q10, q11, q12, q13, q14, q16, q18, q19, q20, q21, q22, q23, q24];
    //listaQuebradas.forEach(q => drawVector(mapDetail, q, queSt, null, 'agua'));

    // Marcador de la Estación
       const markerIcon = L.divIcon({

        className: 'marker-combined',

        html: `
            <div style="display: flex; flex-direction: column; align-items: center; transform: translate(-50%, -100%);">
                <i class="fas fa-map-marker-alt"
                   style="color: ${config.color}; font-size: 24px; text-shadow: -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000; filter: drop-shadow(0px 2px 2px rgba(0,0,0,0.5));">
                </i>
                <span style="margin-top: 2px; white-space: nowrap; font-weight: 700; font-size: 10px; color: ${config.color};
                               text-shadow: -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000; font-family: Arial; letter-spacing: 0.5px; text-transform: uppercase;">
                    ${config.nombre}
                </span>
            </div>`,

        iconSize: [0, 0],

        iconAnchor: [0, 0]

    });

    L.marker([config.lat, config.lon], { icon: markerIcon, interactive: false }).addTo(mapDetail);

    // Refrescar tamaño
    setTimeout(() => { mapDetail.invalidateSize(); }, 500);

    return mapDetail;
}




