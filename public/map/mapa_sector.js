/**
 * Variables Globales
 */
var map, r, s; 
var SECTOR_ID;
var d, p, m, b, u, h, g, w; // Instancias de iconos

/**
 * Redirige a la página de detalles de la estación
 */
function flytodata(idEstacion, idSector) {
    window.location.href = "estacion.php?id=" + idEstacion + "&sector=" + idSector;
}

/**
 * Centra el mapa en una coordenada específica (usado desde el acordeón)
 */
function centerMapOn(lat, lng) {
    if(map) {
        map.flyTo([parseFloat(lat), parseFloat(lng)], 18, {
            animate: true,
            duration: 1.5
        });
    }
}

/**
 * Lógica de Iconos y Clases
 */
function getIconBySub(sub) {
    const icons = { "1": d, "2": h, "3": g, "4": m, "5": b, "10": p };
    return icons[sub] || m;
}

function getClassBySub(sub) {
    const classes = { "1": "labelClass_red", "2": "labelClass_yellow", "3": "labelClass_blue" };
    return classes[sub] || "labelClass_orange";
}

/**
 * Función Principal: Cargar Marcadores por Subsistema
 */
function loadMarkersBySubsistema(idSub) {
    $.ajax({
        url: "/caserones/public/api/get-sector-markers",
        type: "POST",
        data: { sector: SECTOR_ID, subsistema: idSub },
        dataType: "JSON",
        success: function(response) {
            // 1. Limpieza de capas previas
            if (r) map.removeLayer(r);
            if (s) map.removeLayer(s);

            // 2. Actualizar UI
            $("#subsistema").html(response.subsistema);
            $("#texto").html(response.texto);
            $("#count_estaciones").html(response.data.length);

            var markersArr = [];
            var labelsArr = [];
            var coordsForBounds = [];
            var data = response.data;

            // 3. Crear nuevos elementos
            for (var k = 0; k < data.length; k++) {
                var st = data[k];
                var latlng = [st.latitud, st.longitud];
                coordsForBounds.push(latlng);

                var icono = getIconBySub(st.subsistema);
                var clase = getClassBySub(st.subsistema);

                var btnHtml = `<a href="#" class="mybtn" onclick="flytodata('${st.id}','${SECTOR_ID}')">Ver Estación</a>`;
                var popupHtml = `<span class="tooltipp"><b>Parámetros en Línea</b><br>${st.parametros}</span><br><center>${btnHtml}</center>`;
                
                // Marcador Visual
                var marker = L.marker(latlng, { icon: icono }).bindPopup(popupHtml);
                
                // Marcador Etiqueta (DivIcon)
                var label = L.marker(latlng, { 
                    icon: L.divIcon({
                        className: clase,
                        html: st.estacion,
                        iconSize: [51, 51],
                        iconAnchor: [17, 15]
                    }) 
                });

                markersArr.push(marker);
                labelsArr.push(label);
            }

            // 4. Agregar al mapa
            r = L.featureGroup(markersArr);
            s = L.featureGroup(labelsArr);
            map.addLayer(r);
            map.addLayer(s);

            // 5. MEJORA: Ajustar límites y bloquear zona
            if(coordsForBounds.length > 0) {
                var newBounds = L.latLngBounds(coordsForBounds);
                map.fitBounds(newBounds, { padding: [55, 55] });
                // Impedir que el usuario se aleje demasiado del nuevo grupo
                map.setMaxBounds(newBounds.pad(0.5)); 
            }
        }
    });
}

/**
 * Inicialización al cargar la ventana
 */
window.onload = function() {
    // 1. Determinar SECTOR_ID
    SECTOR_ID = (() => {
        const pathSegments = window.location.pathname.split('/');
        const sectorIndex = pathSegments.indexOf('sector');
        if (sectorIndex !== -1 && pathSegments[sectorIndex + 1]) return pathSegments[sectorIndex + 1];
        return new URLSearchParams(window.location.search).get("sector");
    })();

    // 2. Definición de Iconos
    d = new L.Icon({ iconUrl: "/caserones/public/images/pozos/marker.png", iconAnchor: [10, 41], popupAnchor: [5, -37] });
    p = new L.Icon({ iconUrl: "/caserones/public/images/pozos/marker_purplee.png", iconAnchor: [10, 41], popupAnchor: [5, -37] });
    m = new L.Icon({ iconUrl: "/caserones/public/images/pozos/marker_o.png", iconAnchor: [10, 41], popupAnchor: [5, -37] });
    b = new L.Icon({ iconUrl: "/caserones/public/images/pozos/marker_green.png", iconAnchor: [10, 41], popupAnchor: [5, -37] });
    u = new L.Icon({ iconUrl: "/caserones/public/images/pozos/marker_light.png", iconAnchor: [10, 41], popupAnchor: [5, -37] });
    h = new L.Icon({ iconUrl: "/caserones/public/images/pozos/marker_yellow.png", iconAnchor: [10, 41], popupAnchor: [5, -37] });
    g = new L.Icon({ iconUrl: "/caserones/public/images/pozos/marker_blue.png", iconAnchor: [10, 41], popupAnchor: [5, -37] });
    w = new L.Icon({ iconUrl: "/caserones/public/images/pozos/marker_maroon.png", iconAnchor: [10, 41], popupAnchor: [5, -37] });

    // 3. Carga Inicial de Datos (AJAX Síncrono para el inicio)
    var initialData = (function(sector) {
        return $.ajax({
            async: false,
            url: "/caserones/public/api/get-markers",
            type: "POST",
            data: { sector: sector },
            dataType: "JSON"
        }).responseJSON;
    })(SECTOR_ID);

    var initialCoords = initialData.map(st => [st.latitud, st.longitud]);
    var initialBounds = L.latLngBounds(initialCoords);

    // 4. Inicialización del Mapa
    map = L.map("mapid", {
        center: initialBounds.isValid() ? initialBounds.getCenter() : [-28.14, -69.64],
        maxZoom: (SECTOR_ID == 4) ? 14 : 17,
        minZoom: 10,
        zoomControl: true,
        maxBounds: initialBounds.isValid() ? initialBounds.pad(0.8) : null,
        maxBoundsViscosity: 1.0 // Efecto de rebote rígido en los bordes
    });

    // 5. Capa Base (ArcGIS Satélite)
    var satelite = L.tileLayer("https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}", {
        attribution: "&copy; ArcGIS"
    }).addTo(map);

    var streets = L.tileLayer("http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png");

    L.control.layers({ "Satélite": satelite, "Calles": streets }, null, { position: 'topright' }).addTo(map);

    // 6. Procesar Marcadores Iniciales
    var i = [], l = [];
    initialData.forEach(st => {
        var marker = L.marker([st.latitud, st.longitud], { icon: getIconBySub(st.subsistema) })
                      .bindPopup(`<center><b>${st.estacion}</b><br><button onclick="flytodata('${st.id}','${SECTOR_ID}')" class="mybtn">Ver Estación</button></center>`);
        
        var label = L.marker([st.latitud, st.longitud], { 
            icon: L.divIcon({ className: getClassBySub(st.subsistema), html: st.estacion, iconSize: [51, 51] }) 
        });
        
        i.push(marker);
        l.push(label);
    });

    r = L.featureGroup(i);
    s = L.featureGroup(l);
    map.addLayer(r);
    map.addLayer(s);

    if(initialCoords.length > 0) map.fitBounds(initialBounds, { padding: [50, 50] });

    // 7. Evento de Filtrado por Subsistema (Click en Botones del Acordeón)
    $(document).on('click', '.sub-btn', function() {
        var idSub = $(this).data('idsubsistema');
        if (idSub) loadMarkersBySubsistema(idSub);
    });
};