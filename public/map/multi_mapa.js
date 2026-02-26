/**
 * ==========================================================
 * INIT MAP ESTACION - VERSION MULTI MAP (PRO)
 * ==========================================================
 */
function initMapEstacion(config, mapId = 'map-detail') {

    // Verificar si el contenedor de mapa existe
    const container = document.getElementById(mapId);

    if (!container) {
        console.warn(`Contenedor de mapa no encontrado: ${mapId}`);
        return null;
    }

    // Evitar reinicialización si el mapa ya existe
    if (container._leaflet_id) {
        return; // El mapa ya está inicializado
    }

    if (!config || !config.lat || !config.lon) {
        console.warn("Coordenadas no válidas.");
        return null;
    }

    // Crear el mapa
    const mapDetail = L.map(container, {
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

    // Capa base de la imagen satelital
    L.tileLayer(
        "https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}"
    ).addTo(mapDetail);

    // Función para agregar las capas
    const drawVector = (map, coords, style, label, tipo = 'industrial') => {
        if (!coords || coords.length === 0 || !map) return;
        
        let layer;
        
        // Determina si es un polígono o línea
        layer = (style.fillColor !== undefined && style.fillColor !== '') 
                ? L.polygon(coords, style) 
                : L.polyline(coords, style);
        
        layer.addTo(map);
        
        // Añadir el tooltip si tiene
        if (label) {
            vincularTooltipInteligente(layer, label, tipo);
        }

        return layer;
    };

    // =====================================================
    // CAPAS INDUSTRIALES
    // =====================================================
    drawVector(mapDetail, rajo_caserones, 
        { color: '#be0000', fillColor: '#be0000', fillOpacity: 0.05, weight: 3 },
        "Zona Rajo"
    );

    drawVector(mapDetail, planta_procesos, 
        { color: '#48FEAC', fillColor: '#48FEAC', fillOpacity: 0.05, weight: 3 },
        "Planta de Procesos"
    );

    drawVector(mapDetail, campamentos, { color: 'red', weight: 2 }, "Campamento");
    drawVector(mapDetail, portones, { color: 'red', weight: 2 }, "Acceso a Faena");

    // =====================================================
    // DEPOSITOS
    // =====================================================
    drawVector(mapDetail, deposito_lamas, 
        { color: '#66023C', fillColor: '#66023C', fillOpacity: 0.4, weight: 2 },
        "Depósito de Lamas"
    );

    drawVector(mapDetail, deposito_lastre, 
        { color: '#FFFF5C', fillColor: '#FFFF5C', fillOpacity: 0.4, weight: 2 },
        "Depósito de Lastre"
    );

    drawVector(mapDetail, arenas, 
        { color: '#f77f00', fillColor: '#f77f00', fillOpacity: 0.4, weight: 2 },
        "Depósito de Arenas"
    );

    // =====================================================
    // RED HIDRICA
    // =====================================================
    const stRio = { minWidth: 4, maxWidth: 4, color: "#29439c" };
    const stQuebrada = { minWidth: 2, maxWidth: 2, color: "#87ceeb" };

    if (typeof rio_4 !== 'undefined') {
        const rioLayer = L.river(rio_4, stRio).addTo(mapDetail);
        vincularTooltipInteligente(rioLayer, "Río Pulido", 'agua');
    }

    // Crear las quebradas
    const quebradasData = [
        { geo: typeof qdalabrea !== 'undefined' ? qdalabrea : null, lbl: "Qda. La Brea" },
        { geo: typeof q7 !== 'undefined' ? q7 : null, lbl: "Quebrada Roco" },
        { geo: typeof q8 !== 'undefined' ? q8 : null, lbl: "Quebrada La Brea" },
        { geo: typeof q10 !== 'undefined' ? q10 : null, lbl: "Quebrada La Escarcha" },
        { geo: typeof q14 !== 'undefined' ? q14 : null, lbl: "Quebrada Caserones" }
    ];

    quebradasData.forEach(q => {
        if (q.geo && q.geo.length > 0) {
            const qLayer = L.river(q.geo, stQuebrada).addTo(mapDetail);
            if (q.lbl) vincularTooltipInteligente(qLayer, q.lbl, 'agua');
        }
    });

    // =====================================================
    // MARCADOR ESTACION
    // =====================================================
    const markerIcon = L.divIcon({
        className: 'marker-combined',
        html: `
            <div style="display:flex;flex-direction:column;align-items:center;transform:translate(-50%,-100%);">
                <i class="fas fa-map-marker-alt"
                   style="color:${config.color || 'magenta'}; font-size:24px;">
                </i>
                <span style="margin-top:2px; font-weight:700; font-size:10px; color:${config.color || 'magenta'};">
                    ${config.nombre || ''}
                </span>
            </div>`,
        iconSize: [0, 0],
        iconAnchor: [0, 0]
    });

    L.marker([config.lat, config.lon], {
        icon: markerIcon,
        interactive: false
    }).addTo(mapDetail);

    // Refrescar tamaño del mapa si es necesario
    setTimeout(() => {
        mapDetail.invalidateSize();
    }, 400);

    return mapDetail;
}