window.onload = function() {
    function LocateAllFeatures(iobMap, iobFeatureGroup) {
        if (Array.isArray(iobFeatureGroup)) {
            var obBounds = L.latLngBounds();
            for (var i = 0; i < iobFeatureGroup.length; i++) {
                obBounds.extend(iobFeatureGroup[i].getBounds());
            }
            iobMap.fitBounds(obBounds);
        } else {
            iobMap.fitBounds(iobFeatureGroup.getBounds());
        }
    }
    var createLabelIcon = function(labelClass, labelText) {
        return L.divIcon({
            className: labelClass,
            html: labelText,
            iconSize: [41, 51],
            iconAnchor: [17, 15],
            popupAnchor: [1, -34],
        })
    };
    var icon_subt = new L.Icon({
        iconUrl: 'assets/img/pozos/marker.png',
        iconAnchor: [6, 41],
        popupAnchor: [5, -37],
    });
    mbUrl1 = 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}'
    bounds = new L.LatLngBounds(new L.LatLng(-28.21, -69.83), new L.LatLng(-28.07, -69.46));

    var mymap = L.map('mapid', {
        maxZoom: 17,
        minZoom: 12,
        center: bounds.getCenter(),
        maxBounds: bounds,
        maxBoundsViscosity: 0.75

    }).setView([-28.147151, -69.645], 12);

    loadTileLayer(mbUrl1);

    function loadTileLayer(url) {
        var xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var tileLayer = L.tileLayer(url, {
                    attribution: 'Map data &copy; Captura de Imagen: Abril-2021'
                }).addTo(mymap);
            }
        };
        xhr.open('GET', url, true);
        xhr.send();
        mymap.spin(false);

    }

    var control = L.control.zoomBox({
        modal: true
    });

    mymap.addControl(control);

    function ObtainMarkersSUB(sector, subsistema) {
        var markers = $.ajax({
            async: false,
            url: "controller/getMarkerSector.php",
            type: "POST",
            data: {
                sector: sector,
                subsistema: subsistema
            },
            dataType: "JSON"
        }).responseJSON;
        return markers;
    }

    var rajo = L.polygon(rajo_caserones, {
        color: '#be0000',
        fillColor: '',
        fillOpacity: '0.0',
        radius: 500,
        weight: 2,
    }).on("click", function(e) {
        /*alert("hola");*/

    }).bindLabel('<span class="pop_text"> Zona Rajo<span>').addTo(mymap);

    var planta = L.polygon(planta_procesos, {
        color: '#48FEAC',
        fillColor: '',
        fillOpacity: '0.0',
        weight: 2,
        radius: 100
    }).on("click", function(e) {
        /*alert("hola");*/

    }).bindLabel('<span class="pop_text"> Planta de Procesos<span>').addTo(mymap);

    var campamento = L.polygon(campamentos, {
        color: 'red',
        fillColor: '',
        fillOpacity: '0.0',
        radius: 400,
        weight: 2,
    }).on("click", function(e) {
        /*alert("hola");*/

    }).bindLabel('<span class="pop_text"> Campamento<span>', {
        noHide: true
    }).addTo(mymap);

    var porton = L.polygon(portones, {
        color: 'red',
        fillColor: '',
        fillOpacity: '0.0',
        radius: 400,
        weight: 2,
    }).on("click", function(e) {
        /*alert("hola");*/

    }).bindLabel('<span class="pop_text"> Acceso a Faena Industrial <span>').addTo(mymap);

    var dep_lastre = L.polygon(deposito_lastre, {
        color: '#FFFF5C',
        fillColor: '#FFFF5C',
        fillOpacity: 0.5,
        radius: 500
    }).on("click", function(e) {
        /*alert("hola");*/
        window.location.href = "sector.php?sector=4";
    }).bindLabel('<span class="pop_text">Depósito de Lastre<span>').addTo(mymap);
    var dep_ramadillas = L.polygon(ramadillas, {
        color: '#33B503',
        fillColor: '#33B503',
        fillOpacity: 0.5,
        radius: 500
    }).on("click", function(e) {
        /*alert("hola");*/
        window.location.href = "sector.php?sector=3";
    }).bindLabel('<span class="pop_text"> Sistema Río Ramadillas<span></center>').addTo(mymap);
    var dep_arenas = L.polygon(arenas, {
        color: '#f77f00',
        fillColor: '#f77f00',
        fillOpacity: 0.5,
        radius: 500
    }).on("click", function(e) {
        /*alert("hola"); Depósito de Arenas Caserones*/
        window.location.href = "sector.php?sector=2";
    }).bindLabel('<center><span class="pop_text"> Depósito de <br> Arenas Caserones<span></center>').addTo(mymap);
    var dep_lamas = L.polygon(deposito_lamas, {
        color: '#66023C',
        fillColor: '#66023C',
        fillOpacity: 0.5,
        radius: 500
    }).on("click", function(e) {
        /*alert("hola");*/
        window.location.href = "sector.php?sector=1";
    }).bindLabel('<center><span class="pop_text"> Depósito de <br> Lamas La Brea<span></center>').addTo(mymap);

    var river = L.river(rio, {
        minWidth: 4, // px
        maxWidth: 4,
        color: "#29439c", // px
    }).bindLabel('<span class="pop_text">   <span>').addTo(mymap);
    var river = L.river(rio_4, {
        minWidth: 4, // px
        maxWidth: 4, // px
        color: "#29439c", // px
    }).bindLabel('<span class="pop_text">  <span>').addTo(mymap);
    var river = L.river(rio_5, {
        minWidth: 4, // px
        maxWidth: 4, // px
        color: "#29439c", // px
    }).bindLabel('<span class="pop_text"> <span>').addTo(mymap);
    var labrea = L.river(qdalabrea, {
        minWidth: 2, // px
        maxWidth: 2, // px
        color: "#87ceeb ", // px
    }).bindLabel('<span class="pop_text"><span>').addTo(mymap);
    var quebrada2 = L.river(q2, {
        minWidth: 2, // px
        maxWidth: 2, // px
        color: "#87ceeb ", // px
    }).addTo(mymap);
    var quebrada3 = L.river(q3, {
        minWidth: 2, // px
        maxWidth: 2, // px
        color: "#87ceeb ", // px
    }).addTo(mymap);
    var quebrada4 = L.river(q4, {
        minWidth: 2, // px
        maxWidth: 2, // px
        color: "#87ceeb ", // px
    }).addTo(mymap);
    var quebrada5 = L.river(q5, {
        minWidth: 2, // px
        maxWidth: 2, // px
        color: "#87ceeb ", // px
    }).addTo(mymap);
    var quebrada6 = L.river(q6, {
        minWidth: 2, // px
        maxWidth: 2, // px
        color: "#87ceeb ", // px
    }).addTo(mymap);
    var quebrada7 = L.river(q7, {
        minWidth: 2, // px
        maxWidth: 2, // px
        color: "#87ceeb ", // px
    }).bindLabel('<span class="pop_text"> Quebrada Roco<span>').addTo(mymap);
    var quebrada8 = L.river(q8, {
        minWidth: 2, // px
        maxWidth: 2, // px
        color: "#87ceeb ", // px
    }).bindLabel('<span class="pop_text"> Quebrada La Brea<span>').addTo(mymap);
    var quebrada9 = L.river(q9, {
        minWidth: 2, // px
        maxWidth: 2, // px
        color: "#87ceeb ", // px
    }).bindLabel('<span class="pop_text"> Quebrada Roco<span>').addTo(mymap);
    var quebrada10 = L.river(q10, {
        minWidth: 2, // px
        maxWidth: 2, // px
        color: "#87ceeb ", // px
    }).bindLabel('<span class="pop_text"> Quebrada La Escarcha<span>').addTo(mymap);
    var quebrada11 = L.river(q11, {
        minWidth: 2, // px
        maxWidth: 2, // px
        color: "#87ceeb ", // px
    }).addTo(mymap);
    var quebrada12 = L.river(q12, {
        minWidth: 2, // px
        maxWidth: 2, // px
        color: "#87ceeb ", // px
    }).addTo(mymap);
    var quebrada13 = L.river(q13, {
        minWidth: 2, // px
        maxWidth: 2, // px
        color: "#87ceeb ", // px
    }).addTo(mymap);
    var quebrada14 = L.river(q14, {
        minWidth: 2, // px
        maxWidth: 2, // px
        color: "#87ceeb ", // px
    }).bindLabel('<span class="pop_text"> <span>').addTo(mymap);
    var quebrada16 = L.river(q16, {
        minWidth: 2, // px
        maxWidth: 2, // px
        color: "#87ceeb ", // px
    }).addTo(mymap);
    var quebrada18 = L.river(q18, {
        minWidth: 2, // px
        maxWidth: 2, // px
        color: "#87ceeb ", // px
    }).addTo(mymap);
    var quebrada19 = L.river(q19, {
        minWidth: 2, // px
        maxWidth: 2, // px
        color: "#87ceeb ", // px
    }).addTo(mymap);
    var quebrada20 = L.river(q20, {
        minWidth: 2, // px
        maxWidth: 2, // px
        color: "#87ceeb ", // px
    }).addTo(mymap);
    var quebrada21 = L.river(q21, {
        minWidth: 2, // px
        maxWidth: 2, // px
        color: "#87ceeb ", // px
    }).addTo(mymap);
    var quebrada22 = L.river(q22, {
        minWidth: 2, // px
        maxWidth: 2, // px
        color: "#87ceeb ", // px
    }).addTo(mymap);
    var quebrada23 = L.river(q23, {
        minWidth: 2, // px
        maxWidth: 2, // px
        color: "#87ceeb ", // px
    }).addTo(mymap);
    var quebrada24 = L.river(q24, {
        minWidth: 2, // px
        maxWidth: 2, // px
        color: "#87ceeb ", // px
    }).addTo(mymap);

    var polyline = L.polyline(frontera, {
        color: 'red',
        dashArray: '10, 10',
        dashOffset: '0',
        weight: 2
    }).addTo(mymap);

    clase = 'labelClass_red';

    var nombres = new L.Marker(new L.latLng([-28.198859, -69.475012]), {
        icon: createLabelIcon("labelClass_red1", 'CHILE')
    }).addTo(mymap);

    /*  var nombres = new L.Marker(new L.latLng([-28.197032, -69.470283]),
    {
        icon: createLabelIcon(clase, 'CHILE2')
    }).addTo(mymap);*/

    var nombres = new L.Marker(new L.latLng([-28.207363, -69.46893]), {
        icon: createLabelIcon("labelClass_red1", 'ARGENTINA')
    }).addTo(mymap);

    var RIOV = new L.Marker(new L.latLng([-28.119320, -69.693991]), {
        icon: createLabelIcon("labelClass_blue", 'Río Ramadillas')
    }).addTo(mymap);

    var RIOp = new L.Marker(new L.latLng([-28.136428, -69.770388]), {
        icon: createLabelIcon("labelClass_blue", 'Río Pulido')
    }).addTo(mymap);

    var RIOvp = new L.Marker(new L.latLng([-28.091972, -69.742463]), {
        icon: createLabelIcon("labelClass_blue", 'Río Vizcachas de Pulido')
    }).addTo(mymap);

    var Quebradax = new L.Marker(new L.latLng([-28.145894, -69.595740]), {
        icon: createLabelIcon("labelClass_blue", 'Qda. La Brea')
    }).addTo(mymap);

    var Quebradax1 = new L.Marker(new L.latLng([-28.200673, -69.57067]), {
        icon: createLabelIcon("labelClass_blue", 'Qda. Caserones')
    }).addTo(mymap);

    mymap.dragging.disable();
    mymap.dragging.enable();
    mymap.scrollWheelZoom.disable();

}