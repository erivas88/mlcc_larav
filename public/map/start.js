document.addEventListener('DOMContentLoaded', function() {
    // --- 1. CONFIGURACIÓN VISUAL ---
    var blackStroke = "-1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000";

    var createPremiumLabel = function(labelClass, labelText) {
        return L.divIcon({
            className: labelClass,
            html: '<div style="font-family: Poppins, sans-serif; font-size: 11px; ' +
                  'letter-spacing: 1.5px; white-space: nowrap; ' +
                  'color: white; text-shadow: ' + blackStroke + ';">' +
                  labelText + '</div>',
            iconSize: [0, 0],
            iconAnchor: [0, 0]
        });
    };

    var labelCfg = {
        noHide: false,
        direction: 'auto',
        sticky: true,
        offset: [12, 0],
        className: 'custom-tooltip-master'
    };

    // --- 2. INICIALIZACIÓN DEL MAPA ---
    var mbUrl1 = 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}';
    var bounds = new L.LatLngBounds(new L.LatLng(-28.21, -69.83), new L.LatLng(-28.07, -69.46));

    var mymap = L.map('mapid', {
        maxZoom: 17,
        minZoom: 11,
        center: bounds.getCenter(),
        maxBounds: bounds,
        maxBoundsViscosity: 0.75,
        attributionControl: false
    }).setView([-28.147151, -69.645], 12);

    L.tileLayer(mbUrl1).addTo(mymap);

    // --- 3. MINIMAPA ---
    var overlaysMinimap = L.layerGroup();

    // --- 4. FUNCIÓN DE RENDERIZADO ---
    function drawPremiumVector(coords, style, label, type) {
        if (typeof coords === 'undefined' || !coords) return;
        type = type || 'industrial';

        var layer;
        if (style.fillColor) {
            layer = L.polygon(coords, style).addTo(mymap);
            L.polygon(coords, Object.assign({}, style, {weight: 1, fillOpacity: 0.3})).addTo(overlaysMinimap);
        } else if (L.river && style.minWidth) {
            layer = L.river(coords, style).addTo(mymap);
            L.river(coords, Object.assign({}, style, {minWidth: 1, maxWidth: 1})).addTo(overlaysMinimap);
        } else {
            layer = L.polyline(coords, style).addTo(mymap);
        }

        if (label) {
            var spanClass = (type === 'agua') ? 'text-agua' : 'text-industrial';
            layer.bindLabel('<span class="label-master ' + spanClass + '">' + label + '</span>', labelCfg);
        }
        return layer;
    }

    // --- 5. RED HÍDRICA ---
    var stRio = { minWidth: 4, maxWidth: 4, color: "#29439c" };
    var stQue = { minWidth: 2, maxWidth: 2, color: "#87ceeb" };

    drawPremiumVector(rio,   stRio, "Río Ramadillas", 'agua');
    drawPremiumVector(rio_4, stRio, "Río Pulido",     'agua');
    drawPremiumVector(rio_5, stRio, null,             'agua');

    var quebradas = [
        {geo: qdalabrea, name: "Qda. La Brea"},      {geo: q2},  {geo: q3},  {geo: q4},  {geo: q5}, {geo: q6},
        {geo: q7,  name: "Quebrada Roco"},            {geo: q8,  name: "Quebrada La Brea"},
        {geo: q9,  name: "Quebrada Roco"},            {geo: q10, name: "Quebrada La Escarcha"},
        {geo: q11}, {geo: q12}, {geo: q13}, {geo: q14},
        {geo: q16}, {geo: q18}, {geo: q19}, {geo: q20}, {geo: q21}, {geo: q22}, {geo: q23}, {geo: q24}
    ];

    quebradas.forEach(function(q) {
        if (typeof q.geo !== 'undefined') drawPremiumVector(q.geo, stQue, q.name, 'agua');
    });

    // --- 6. ÁREAS INDUSTRIALES Y DEPÓSITOS ---
    var stInd = { weight: 3, fillOpacity: 0.1 };

    drawPremiumVector(rajo_caserones,  {color: '#be0000', fillColor: '#be0000', fillOpacity: 0.05, weight: 3}, "Zona Rajo");
    drawPremiumVector(planta_procesos, {color: '#48FEAC', fillColor: '#be0000', fillOpacity: 0.05, weight: 3}, "Planta de Procesos");
    drawPremiumVector(campamentos,     Object.assign({color: 'red'}, stInd), "Campamento");

    var depositos = [
        {geo: deposito_lastre, col: '#FFFF5C', name: 'Depósito de Lastre', id: 4},
        {geo: ramadillas,      col: '#33B503', name: 'Sistema Ramadillas',  id: 3},
        {geo: arenas,          col: '#f77f00', name: 'Depósito de Arenas',  id: 2},
        {geo: deposito_lamas,  col: '#66023C', name: 'Depósito de Lamas',   id: 1}
    ];

    depositos.forEach(function(d) {
        if (typeof d.geo !== 'undefined') {
            var layer = drawPremiumVector(d.geo, {color: d.col, fillColor: d.col, fillOpacity: 0.4, weight: 3}, d.name);
            (function(sectorId) {
                layer.on("click", function() { window.location.href = window.baseSectorUrl + '/' + sectorId; });
            })(d.id);
            layer.on("mouseover", function(e) { if (e.target._path) e.target._path.style.cursor = 'pointer'; });
        }
    });

    // --- 7. ETIQUETAS GEOGRÁFICAS ---
    var geoLabels = [
        {coords: [-28.1988, -69.4750], txt: 'CHILE',          cls: 'labelClass_blue'},
        {coords: [-28.2073, -69.4689], txt: 'ARGENTINA',      cls: 'labelClass_blue'},
        {coords: [-28.1193, -69.6939], txt: 'Río Ramadillas', cls: 'labelClass_blue'},
        {coords: [-28.1364, -69.7703], txt: 'Río Pulido',     cls: 'labelClass_blue'},
        {coords: [-28.0919, -69.7424], txt: 'Río Vizcachas',  cls: 'labelClass_blue'},
        {coords: [-28.1458, -69.5957], txt: 'Qda. La Brea',   cls: 'labelClass_blue'},
        {coords: [-28.2006, -69.5706], txt: 'Qda. Caserones', cls: 'labelClass_blue'}
    ];

    geoLabels.forEach(function(l) {
        L.marker(l.coords, {icon: createPremiumLabel(l.cls, l.txt), interactive: false}).addTo(mymap);
    });

    if (typeof frontera !== 'undefined') {
        L.polyline(frontera, {color: 'red', dashArray: '10, 10', weight: 2}).addTo(mymap);
    }

    mymap.scrollWheelZoom.disable();
});
