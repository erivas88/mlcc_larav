/**
 * Inicializa el mapa de detalle de la estación (map-detail)
 * Versión estática con red hídrica completa y polígonos de faena.
 */
function initMapEstacion(config) {
    if (!config.lat || !config.lon) {
        console.error("Coordenadas no válidas para el mapa de detalle.");
        return;
    }

    // 1. Instancia del Mapa con interacciones DESACTIVADAS
    const mapDetail = L.map('map-detail', {
        center: [config.lat, config.lon],
        zoom: 16,
        attributionControl: false, 
        zoomControl: false,
        dragging: false,
        scrollWheelZoom: false,
        doubleClickZoom: false,
        boxZoom: false,
        keyboard: false,
        touchZoom: false
    });

    // 2. Capa Satelital
    L.tileLayer("https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}", {
        attribution: ''
    }).addTo(mapDetail);

    // --- 3. FUNCIONES DE DIBUJO VECTORIAL (Soporte Polígono y Línea) ---
    const drawVectorDetail = (coords, style, label) => {
        if (typeof coords === 'undefined' || !coords || coords.length === 0) return;
        
        let layer;
        // Detectar si es un río (usando plugin L.river si está disponible) o polígono estándar
        if (style.minWidth && typeof L.river === 'function') {
            layer = L.river(coords, style);
        } else if (style.fillColor !== undefined) {
            layer = L.polygon(coords, style);
        } else {
            layer = L.polyline(coords, style);
        }

        layer.addTo(mapDetail);
        
        if (label && layer.bindTooltip) {
            layer.bindTooltip(label, { direction: 'center', className: 'pop_text', permanent: false });
        }
    };

    // --- 4. DIBUJO DE SIMBOLOGÍA ---

    // Capas Permanentes (Rajo, Planta, Campamento, Portones)
    drawVectorDetail(rajo_caserones, { color: '#be0000', fillColor: '', fillOpacity: 0, weight: 2 }, "Zona Rajo");
    drawVectorDetail(planta_procesos, { color: '#48FEAC', fillColor: '', fillOpacity: 0, weight: 2 }, "Planta de Procesos");
    drawVectorDetail(campamentos, { color: 'red', fillColor: '', fillOpacity: 0, weight: 2 }, "Campamento");
    drawVectorDetail(portones, { color: 'red', fillColor: '', fillOpacity: 0, weight: 2 }, "Acceso a Faena Industrial");

    // Red Hídrica (Ríos - Azul Oscuro)
    const rivSt = { minWidth: 4, maxWidth: 4, color: "#29439c" };
    [rio, rio_4, rio_5].forEach(v => drawVectorDetail(v, rivSt));

    // Quebradas (Azul Claro - Todas las indicadas en tu script)
    const queSt = { minWidth: 2, maxWidth: 2, color: "#87ceeb" };
    const quebradas = [
        qdalabrea, q2, q3, q4, q5, q6, q7, q8, q9, q10, 
        q11, q12, q13, q14, q16, q18, q19, q20, q21, q22, q23, q24
    ];
    quebradas.forEach(q => drawVectorDetail(q, queSt));

    // Frontera y Otros
    drawVectorDetail(frontera, { color: 'red', dashArray: '10, 10', weight: 2 });

    // Polígonos de Sectores (Depósitos)
    if (config.sectorId == "1" || config.sectorId == "2") {
        drawVectorDetail(deposito_lamas, { color: '#66023C', fillColor: '#66023C', fillOpacity: 0.4, weight: 1 }, 'Depósito de Lamas');
        drawVectorDetail(deposito_lastre, { color: '#FFFF5C', fillColor: '#FFFF5C', fillOpacity: 0.4, weight: 1 }, 'Depósito de Lastre');
        drawVectorDetail(arenas, { color: '#f77f00', fillColor: '#f77f00', fillOpacity: 0.4, weight: 1 }, 'Depósito de Arenas');
    }
    if (config.sectorId == "2") {
         drawVectorDetail(deposito_lamas, { color: '#66023C', fillColor: '#66023C', fillOpacity: 0.4, weight: 1 }, 'Depósito de Lamas');
        drawVectorDetail(deposito_lastre, { color: '#FFFF5C', fillColor: '#FFFF5C', fillOpacity: 0.4, weight: 1 }, 'Depósito de Lastre');
        drawVectorDetail(arenas, { color: '#f77f00', fillColor: '#f77f00', fillOpacity: 0.4, weight: 1 }, 'Depósito de Arenas');
    }
    if (config.sectorId == "3") {
        drawVectorDetail(deposito_lamas, { color: '#66023C', fillColor: '#66023C', fillOpacity: 0.4, weight: 1 }, 'Depósito de Lamas');
        drawVectorDetail(deposito_lastre, { color: '#FFFF5C', fillColor: '#FFFF5C', fillOpacity: 0.4, weight: 1 }, 'Depósito de Lastre');
        drawVectorDetail(arenas, { color: '#f77f00', fillColor: '#f77f00', fillOpacity: 0.4, weight: 1 }, 'Depósito de Arenas');
    }

    // --- 5. MARCADOR DE LA ESTACIÓN ---
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

    // 6. Refrescar tamaño para corregir errores de carga
    setTimeout(() => { mapDetail.invalidateSize(); }, 500);

    return mapDetail;
}