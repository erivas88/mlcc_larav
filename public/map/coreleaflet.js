/**
 * Variables Globales de Control
 */
var map, r, SECTOR_ID;

/**
 * Estilo: Borde negro uniforme para icono y letra (Estilo MNB-4).
 */
function createFullMarker(latlng, color, nombre) {
    const markerColor = color || "#ffd700";
    const blackStroke = "-1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, -1px 1px 0 #000";

    const icon = L.divIcon({
        className: 'marker-combined',
        html: `
            <div style="display: flex; flex-direction: column; align-items: center; transform: translate(-50%, -100%);">
                <i class="fas fa-map-marker-alt" 
                   style="color: ${markerColor}; font-size: 20px; text-shadow: ${blackStroke}; filter: drop-shadow(0px 2px 2px rgba(0,0,0,0.5));">
                </i>
                <span style="margin-top: 1px; white-space: nowrap; font-weight: 600; font-size: 9px; color: ${markerColor};
                               text-shadow: ${blackStroke}; font-family: Arial, sans-serif; letter-spacing: 0.5px; text-transform: uppercase;">
                    ${nombre}
                </span>
            </div>`,
        iconSize: [0, 0],
        iconAnchor: [0, 0]
    });
    return L.marker(latlng, { icon: icon });
}

/**
 * Soporte para etiquetas (Tooltip/Label) seguro
 */
function safeLabel(layer, text) {
    if (layer.bindTooltip) {
        layer.bindTooltip(text, { 
            direction: 'center', 
            className: 'pop_text', 
            permanent: false 
        });
    } else if (typeof layer.bindLabel === "function") {
        layer.bindLabel(text, { className: 'pop_text' });
    }
    return layer;
}

/**
 * Carga de Marcadores por Subsistema (AJAX)
 */
function loadMarkersBySubsistema(idSub) {
    console.log("Iniciando carga de marcadores para subsistema:", idSub);
    $.ajax({
        url: "/caserones/public/api/get-sector-markers",
        type: "POST",
        data: {
            sector: SECTOR_ID,
            subsistema: idSub
        },
        dataType: "JSON",
        success: function(response) {
            console.log("Respuesta recibida:", response);
            if (r) map.removeLayer(r); 

            $("#subsistema").html(response.subsistema);
            $("#count_estaciones").html(response.data.length);

            const markersArr = [];
            const coords = [];

            response.data.forEach(st => {
                const latlng = [st.latitud, st.longitud];
                coords.push(latlng);
                const marker = createFullMarker(latlng, st.color, st.estacion)
                    .bindPopup(`<center><b>${st.estacion}</b><br><button onclick="window.location.href='/estacion/${st.id}'" class="mybtn">Ver Estación</button></center>`);
                markersArr.push(marker);
            });

            r = L.featureGroup(markersArr).addTo(map);

            if (coords.length > 0) {
                const newBounds = L.latLngBounds(coords);
                map.setMaxBounds(null);
                map.fitBounds(newBounds, { padding: [100, 100] });
                console.log("Ajuste de mapa (fitBounds) completado para el subsistema.");
            }
        },
        error: function(err) {
            console.error("Error cargando subsistema:", err);
        }
    });
}

window.onload = function() {
    // 1. DETECCIÓN DE PARÁMETROS DESDE LA URL (Robusta)
    const pathSegments = window.location.pathname.split('/').filter(s => s !== "");
    const sectorIndex = pathSegments.indexOf('sector');
    
    let SUBSISTEMA_ID = null;

    if (sectorIndex !== -1) {
        SECTOR_ID = pathSegments[sectorIndex + 1] || null;
        SUBSISTEMA_ID = pathSegments[sectorIndex + 2] || null;
        console.log("URL Detectada - Sector:", SECTOR_ID, "Subsistema:", SUBSISTEMA_ID);
    }

    // 2. Inicializar Mapa Principal
    map = L.map("mapid", {
        center: [-28.14, -69.64],
        zoom: 12,
        maxZoom: 18,
        minZoom: 10,
        maxBoundsViscosity: 1.0
    });

    L.tileLayer("https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}").addTo(map);

    // --- AGREGAR MINIMAPA ---
    const miniMapLayer = L.tileLayer("https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}");
    new L.Control.MiniMap(miniMapLayer, { position: 'bottomleft', width: 100, height: 100, zoomLevelOffset: -5 }).addTo(map);

    // --- FUNCIÓN DE DIBUJO VECTORIAL ---
    const drawVector = (coords, style, label, clickUrl) => {
        if (!coords || coords.length === 0) return;
        let layer;
        try {
            layer = (style.fillColor) ? L.polygon(coords, style) :
                    (style.minWidth && L.river) ? L.river(coords, style) : L.polyline(coords, style);
        } catch (e) {
            layer = L.polyline(coords, style);
        }
        layer.addTo(map);
        if (label) safeLabel(layer, label);
        if (clickUrl) layer.on("click", () => window.location.href = clickUrl);
    };

    // --- DIBUJO DE POLÍGONOS POR SECTOR (Tu lógica original) ---
    if (SECTOR_ID == "1" || SECTOR_ID == "2") {
        drawVector(deposito_lamas, { color: '#66023C', fillColor: '#66023C', fillOpacity: 0.5 }, 'Depósito de Lamas');
        drawVector(deposito_lastre, { color: '#FFFF5C', fillColor: '#FFFF5C', fillOpacity: 0.5 }, 'Depósito de Lastre');
    }
    if (SECTOR_ID == "2") drawVector(arenas, { color: '#f77f00', fillColor: '#f77f00', fillOpacity: 0.5 }, 'Depósito de Arenas');
    if (SECTOR_ID == "3") drawVector(ramadillas, { color: '#33B503', fillColor: '#33B503', fillOpacity: 0.5 }, 'Sistema Ramadillas');

    // Capas permanentes
    drawVector(rajo_caserones, { color: '#be0000', fillOpacity: 0, weight: 2 }, "Zona Rajo");
    drawVector(planta_procesos, { color: '#48FEAC', fillOpacity: 0, weight: 2 }, "Planta de Procesos");
    drawVector(campamentos, { color: 'red', fillOpacity: 0, weight: 2 }, "Campamento");

    // Red Hídrica (Ríos y Quebradas)
    const rivSt = { minWidth: 4, color: "#29439c" };
    const queSt = { minWidth: 2, color: "#87ceeb" };
    [rio, rio_4, rio_5].forEach(v => drawVector(v, rivSt));
    [qdalabrea, q2, q3, q4, q5, q6, q11, q12, q13, q14, q16, q18, q19, q20, q21, q22, q23, q24].forEach(v => drawVector(v, queSt));
    
    // --- LÓGICA DE CARGA INICIAL DE MARCADORES ---
    if (SECTOR_ID && SUBSISTEMA_ID) {
        // CASO A: Tenemos ambos, cargamos el subsistema directamente
        loadMarkersBySubsistema(SUBSISTEMA_ID);
    } else if (SECTOR_ID) {
        // CASO B: Solo sector, cargamos todos los del sector (Global)
        $.ajax({
            url: "/caserones/public/api/get-markers",
            type: "POST",
            data: { sector: SECTOR_ID },
            dataType: "JSON",
            success: function(data) {
                const markers = data.map(st => createFullMarker([st.latitud, st.longitud], st.color, st.estacion)
                    .bindPopup(`<center><b>${st.estacion}</b><br><button onclick="window.location.href='/estacion/${st.id}'" class="mybtn">Ver</button></center>`));
                r = L.featureGroup(markers).addTo(map);
                if (data.length > 0) {
                    map.fitBounds(L.featureGroup(markers).getBounds().pad(0.2));
                }
            }
        });
    }

    // Asegurar que el mapa se renderice bien
    setTimeout(() => { map.invalidateSize(); }, 800);

    // Evento de clic en botones de la lista lateral
    $(document).on('click', '.sub-btn', function() {
        const id = $(this).data('idsubsistema');
        if (id) loadMarkersBySubsistema(id);
    });
};