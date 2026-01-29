/**
 * Redirige a la página de detalles de la estación
 */
function flytodata(e, a) {
    console.log(e, a);
    window.location.href = "estacion.php?id=" + e + "&sector=" + a;
}

window.onload = function() {
    // 1. Configuración Inicial y Parámetros URL
    const e = window.location.search;
    const a = new URLSearchParams(e);
    const o = a.get("sector");
    const t = a.get("subsistema");
    
    // Límites geográficos del mapa
    limites = new L.LatLngBounds(new L.LatLng(-28.21, -69.83), new L.LatLng(-28.07, -69.46));
    
    let n = [];
    var r, s, i = [], l = [];

    // 2. Definición de Iconos de Marcadores
    var c = function(e, a) {
        return L.divIcon({
            className: e,
            html: a,
            iconSize: [51, 51],
            iconAnchor: [17, 15],
            popupAnchor: [1, -34]
        })
    };

 

        // Definición de iconos con rutas relativas a la carpeta public
var d = new L.Icon({ iconUrl: "images/pozos/marker.png", iconAnchor: [10, 41], popupAnchor: [5, -37] }),
    p = new L.Icon({ iconUrl: "images/pozos/marker_purplee.png", iconAnchor: [10, 41], popupAnchor: [5, -37] }),
    m = new L.Icon({ iconUrl: "images/pozos/marker_o.png", iconAnchor: [10, 41], popupAnchor: [5, -37] }),
    b = new L.Icon({ iconUrl: "images/pozos/marker_green.png", iconAnchor: [10, 41], popupAnchor: [5, -37] }),
    u = new L.Icon({ iconUrl: "images/pozos/marker_light.png", iconAnchor: [10, 41], popupAnchor: [5, -37] }),
    h = new L.Icon({ iconUrl: "images/pozos/marker_yellow.png", iconAnchor: [10, 41], popupAnchor: [5, -37] }),
    g = new L.Icon({ iconUrl: "images/pozos/marker_blue.png", iconAnchor: [10, 41], popupAnchor: [5, -37] }),
    w = new L.Icon({ iconUrl: "images/pozos/marker_maroon.png", iconAnchor: [10, 41], popupAnchor: [5, -37] });

    // 3. Configuración de Capas Base (Mapbox / ArcGIS)
    var f = "https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw";
    
    streets = L.tileLayer(f, {
        id: "mapbox/streets-v11",
        attribution: "&copy; Captura de Imagen: Abril-2021"
    });

    mbAttr1 = "&copy; Captura de Imagen: Abril-2021";
    mbUrl1 = "https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}";
    base_layer = L.tileLayer(mbUrl1, {
        id: "mapbox.streets",
        attribution: mbAttr1
    });

    maxZoom = (4 == o) ? 14 : 17;

    // 4. Carga de Datos (AJAX o Función q)
    if (null != t) {
        // Carga por subsistema específico
        core = [];
        marker_sub = q(o, t);
        n = marker_sub.data;
        $("#subsistema").html(marker_sub.subsistema);
        $("#texto").html(marker_sub.texto);
        for (k = 0; k < n.length; k++) {
            core.push(new L.LatLng(n[k].latitud, n[k].longitud));
        }
    } else {
        // Carga general por sector
        core = [];
        n = function(e) {
            c
        }(o);
        for (k = 0; k < n.length; k++) {
            core.push(new L.LatLng(n[k].latitud, n[k].longitud));
        }
    }

    // 5. Inicialización del Mapa
    nucleo = new L.LatLngBounds(core);
    var y = L.map("mapid", {
        center: nucleo.getCenter(),
        maxZoom: maxZoom,
        minZoom: 12,
        zoomControl: true,
        maxBounds: nucleo,
        maxBoundsViscosity: 0.75
    });

    // Ajustes de zoom según sector
    if (3 == o) y.options.maxZoom = 14;
    if (4 == o) y.options.minZoom = 13;

    // 6. Dibujo de Áreas (Polígonos)
    L.polygon(planta_procesos, { color: "#48FEAC", fillOpacity: "0.0", weight: 3 })
        .bindLabel('<span class="pop_text"> Planta de Procesos<span>').addTo(y);

    L.polygon(campamentos, { color: "red", fillOpacity: "0.0", weight: 3 })
        .bindLabel('<span class="pop_text"> Campamento<span>').addTo(y);

    L.polygon(rajo_caserones, { color: "#be0000", fillOpacity: "0.0", weight: 3 })
        .bindLabel('<span class="pop_text"> Zona Rajo<span>').addTo(y);

    // 7. Capas de Control y Minimapa
    var v = new L.TileLayer("http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", { minZoom: 9, maxZoom: 18 });
    var T = { "Streets": v, "Satélite": base_layer };
    L.control.layers(T).addTo(y);
    
    new L.Control.MiniMap(base_layer, { toggleDisplay: true, width: 100, height: 100, position: "bottomleft" }).addTo(y);

    // 8. Creación de Marcadores de Estaciones
    $("#count_estaciones").html(n.length);
    for (var A = 0; A < n.length; ++A) {
        test = n[A].estacion;
        W = M(n[A].subsistema); // Obtener icono
        clase = S(n[A].subsistema); // Obtener clase CSS

        var z = '<a href="#" class="mybtn" onclick="flytodata(\'' + n[A].id + "','" + o + "')\">Ver Estación</a>";
        var O = '<span class="tooltipp"><b> Parámetros en Línea </b><br> ' + n[A].parametros + "</span><br><center>" + z + "</center>";
        
        var B = L.marker([n[A].latitud, n[A].longitud], { icon: W });
        B.bindPopup(O);
        
        var I = new L.Marker(new L.latLng([n[A].latitud, n[A].longitud]), { icon: c(clase, n[A].estacion) });
        i.push(B);
        l.push(I);
    }

    r = L.featureGroup(i);
    s = L.featureGroup(l);
    y.addLayer(r);
    y.addLayer(s);
    y.fitBounds(r.getBounds(), { padding: [55, 55] });

    // 9. Elementos Geográficos Adicionales (Ríos y Fronteras)
    L.polyline(frontera, { color: "red", dashArray: "10, 10", weight: 2 }).addTo(y);
    
    // Etiquetas de Países y Ríos
    new L.Marker(new L.latLng([-28.1988, -69.4750]), { icon: c("labelClass_red1", "CHILE") }).addTo(y);
    new L.Marker(new L.latLng([-28.2073, -69.4689]), { icon: c("labelClass_red1", "ARGENTINA") }).addTo(y);

    // Dibujo de Ríos usando un plugin L.river (si existe)
    L.river(rio, { color: "#29439c" }).bindLabel('Río Vizcachas de Pulido').addTo(y);
    L.river(qdalabrea, { color: "#87ceeb" }).bindLabel('Quebrada La Brea').addTo(y);

    // 10. Funciones de Soporte
    function M(e) {
        // Retorna el icono según el ID del subsistema
        let a;
        if (e == "1") a = d;
        else if (e == "2") a = h;
        else if (e == "3") a = g;
        // ... (resto de condiciones)
        return a;
    }

    function S(e) {
        // Retorna la clase CSS según el subsistema
        let a;
        if (e == "1") a = "labelClass_red";
        else if (e == "2") a = "labelClass_yellow";
        // ...
        return a;
    }

    function q(e, a) {
        // Consulta AJAX para marcadores por sector/subsistema
        return $.ajax({
            async: false,
            url: "controller/getMarkerSector.php",
            type: "POST",
            data: { sector: e, subsistema: a },
            dataType: "JSON"
        }).responseJSON;
    }
};