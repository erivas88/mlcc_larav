var map, r, SECTOR_ID;

/**
 * Función Maestra: Crea el Marcador (Icono FontAwesome + Texto debajo)
 */
function createFullMarker(latlng, color, nombre) {
    const markerColor = color || "#ffd700"; 
    const blackStroke = "-1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000";

    const icon = L.divIcon({
        className: 'marker-combined',
        html: `
            <div style="display: flex; flex-direction: column; align-items: center; transform: translate(-50%, -100%);">
                <i class="fas fa-map-marker-alt" 
                   style="color: ${markerColor}; 
                          font-size: 20px; 
                          text-shadow: ${blackStroke}; 
                          filter: drop-shadow(0px 2px 2px rgba(0,0,0,0.5));">
                </i>
                <span style="margin-top: 1px; 
                             white-space: nowrap; 
                             font-weight: 500; 
                             font-size: 11px; 
                             color: ${markerColor};
                             text-shadow: ${blackStroke};
                             font-family: Arial, sans-serif;
                             letter-spacing: 0.5px;
                             text-transform: uppercase;">
                    ${nombre}
                </span>
            </div>`,
        iconSize: [0, 0],
        iconAnchor: [0, 0]
    });

    return L.marker(latlng, { icon: icon });
}

/**
 * Carga por Subsistema (AJAX)
 */
function loadMarkersBySubsistema(idSub) {
    $.ajax({
        url: "/caserones/public/api/get-sector-markers",
        type: "POST",
        data: { sector: SECTOR_ID, subsistema: idSub },
        dataType: "JSON",
        success: function(response) {
            if (r) map.removeLayer(r);

            $("#subsistema").html(response.subsistema);
            $("#count_estaciones").html(response.data.length);

            var markersArr = [];
            var coords = [];

            response.data.forEach(st => {
                var latlng = [st.latitud, st.longitud];
                coords.push(latlng);

                var popupHtml = `<center><b>${st.estacion}</b><br><button onclick="window.location.href='estacion.php?id=${st.id}&sector=${SECTOR_ID}'" class="mybtn">Ver Estación</button></center>`;
                var marker = createFullMarker(latlng, st.color, st.estacion).bindPopup(popupHtml);
                markersArr.push(marker);
            });

            r = L.featureGroup(markersArr).addTo(map);

            if(coords.length > 0) {
                // CALCULAMOS LOS LÍMITES DINÁMICOS
                var newBounds = L.latLngBounds(coords);
                
                // 1. Ajustamos la vista con un padding generoso
                map.fitBounds(newBounds, { padding: [100, 100] });

                // 2. Aplicamos el maxBounds con un .pad(0.1) que da un 10% de margen extra
                // Esto evita que el maxBounds "corte" los marcadores de las orillas
                map.setMaxBounds(newBounds.pad(0.1)); 
            }
        }
    });
}

window.onload = function() {
    SECTOR_ID = (() => {
        const pathSegments = window.location.pathname.split('/');
        const sectorIndex = pathSegments.indexOf('sector');
        if (sectorIndex !== -1 && pathSegments[sectorIndex + 1]) return pathSegments[sectorIndex + 1];
        return new URLSearchParams(window.location.search).get("sector");
    })();

    var initialData = (function(sector) {
        var res = [];
        $.ajax({
            async: false,
            url: "/caserones/public/api/get-markers",
            type: "POST", 
            data: { sector: sector }, 
            dataType: "JSON",
            success: function(data) { res = data; }
        });
        return res;
    })(SECTOR_ID);

    if (!Array.isArray(initialData)) return;

    var initialCoords = initialData.map(st => [st.latitud, st.longitud]);
    var initialBounds = L.latLngBounds(initialCoords);

    // Inicializar mapa con un área de movimiento un poco más amplia que los marcadores (.pad)
    map = L.map("mapid", {
        center: initialBounds.isValid() ? initialBounds.getCenter() : [-28.14, -69.64],
        maxZoom: 18, 
        minZoom: 10,
        // Usamos pad(0.2) para que el usuario pueda desplazarse un poco alrededor de los puntos
        maxBounds: initialBounds.isValid() ? initialBounds.pad(0.2) : null,
        maxBoundsViscosity: 1.0
    });

    L.tileLayer("https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}").addTo(map);

    var i = [];
    initialData.forEach(st => {
        var marker = createFullMarker([st.latitud, st.longitud], st.color, st.estacion)
                      .bindPopup(`<center><b>${st.estacion}</b><br><button onclick="window.location.href='estacion.php?id=${st.id}&sector=${SECTOR_ID}'" class="mybtn">Ver Estación</button></center>`);
        i.push(marker);
    });

    r = L.featureGroup(i).addTo(map);
    
    if(initialCoords.length > 0) {
        map.fitBounds(initialBounds, { padding: [80, 80] });
    }

    $(document).on('click', '.sub-btn', function() {
        var id = $(this).data('idsubsistema');
        if (id) loadMarkersBySubsistema(id);
    });
};

function centerMapOn(lat, lng) {
    map.flyTo([parseFloat(lat), parseFloat(lng)], 18, { animate: true, duration: 1 });
}