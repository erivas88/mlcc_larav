window.onload = function() {
    // --- 1. CONFIGURACIÓN VISUAL PREMIUM UNIFICADA ---
    const blackStroke = "-1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000";

    var createPremiumLabel = function(labelClass, labelText, color) {
        return L.divIcon({
            className: labelClass,
            html: `<div style="font-family: 'Poppins', sans-serif; font-size: 11px; 
                               letter-spacing: 1.5px; white-space: nowrap; 
                               color: 'white'; text-shadow: ${blackStroke};">
                        ${labelText}
                   </div>`,
            iconSize: [0, 0],
            iconAnchor: [0, 0]
        });
    };

    var labelCfg = { 
        noHide: false, 
        direction: 'auto', 
        sticky: true,           // El tooltip sigue al cursor suavemente
        offset: [12, 0],        // Separación elegante
        className: 'custom-tooltip-master' 
    };

    // --- 2. INICIALIZACIÓN DEL MAPA PRINCIPAL ---
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

    // --- 3. SISTEMA DE REPLICACIÓN PARA EL MINIMAPA ---
    var overlaysMinimap = L.layerGroup();

    // --- 4. FUNCIÓN DE RENDERIZADO UNIFICADA ---
    const drawPremiumVector = (coords, style, label, type = 'industrial') => {
        if (typeof coords === 'undefined' || !coords) return;
        
        let layer;
        if (style.fillColor) {
            layer = L.polygon(coords, style).addTo(mymap);
            L.polygon(coords, {...style, weight: 1, fillOpacity: 0.3}).addTo(overlaysMinimap);
        } else if (L.river && style.minWidth) {
            layer = L.river(coords, style).addTo(mymap);
            L.river(coords, {...style, minWidth: 1, maxWidth: 1}).addTo(overlaysMinimap);
        } else {
            layer = L.polyline(coords, style).addTo(mymap);
        }

        if (label) {
            const spanClass = (type === 'agua') ? 'text-agua' : 'text-industrial';
            layer.bindLabel(`<span class="label-master ${spanClass}">${label}</span>`, labelCfg);
        }
        return layer;
    };

    // --- 5. RED HÍDRICA COMPLETA ---
    const stRio = { minWidth: 4, maxWidth: 4, color: "#29439c" };
    const stQue = { minWidth: 2, maxWidth: 2, color: "#87ceeb" };

    drawPremiumVector(rio, stRio, "Río Ramadillas", 'agua');
    drawPremiumVector(rio_4, stRio, "Río Pulido", 'agua');
    drawPremiumVector(rio_5, stRio, null, 'agua');

    const quebradas = [
        {geo: qdalabrea, name: "Qda. La Brea"}, {geo: q2}, {geo: q3}, {geo: q4}, {geo: q5}, {geo: q6},
        {geo: q7, name: "Quebrada Roco"}, {geo: q8, name: "Quebrada La Brea"}, {geo: q9, name: "Quebrada Roco"},
        {geo: q10, name: "Quebrada La Escarcha"}, {geo: q11}, {geo: q12}, {geo: q13}, {geo: q14},
        {geo: q16}, {geo: q18}, {geo: q19}, {geo: q20}, {geo: q21}, {geo: q22}, {geo: q23}, {geo: q24}
    ];

    quebradas.forEach(q => {
        if (typeof q.geo !== 'undefined') drawPremiumVector(q.geo, stQue, q.name, 'agua');
    });

    // --- 6. ÁREAS INDUSTRIALES Y DEPÓSITOS (Ajuste Rajo con relleno interactivo) ---
    const stInd = { weight: 3, fillOpacity: 0.1 };
    
    // Ajuste específico para Zona Rajo: habilitamos fillColor para que sea interactivo en su interior
    drawPremiumVector(rajo_caserones, {color: '#be0000', fillColor: '#be0000', fillOpacity: 0.05, weight: 3}, "Zona Rajo");
    
    drawPremiumVector(planta_procesos, {color: '#48FEAC', fillColor: '#be0000', fillOpacity: 0.05, weight: 3}, "Planta de Procesos");
    drawPremiumVector(campamentos, {color: 'red', ...stInd}, "Campamento");


    const depositos = [
        {geo: deposito_lastre, col: '#FFFF5C', name: 'Depósito de Lastre', id: 4},
        {geo: ramadillas, col: '#33B503', name: 'Sistema Ramadillas', id: 3},
        {geo: arenas, col: '#f77f00', name: 'Depósito de Arenas', id: 2},
        {geo: deposito_lamas, col: '#66023C', name: 'Depósito de Lamas', id: 1}
    ];

    depositos.forEach(d => {
        if (typeof d.geo !== 'undefined') {
            const layer = drawPremiumVector(d.geo, {color: d.col, fillColor: d.col, fillOpacity: 0.4, weight: 3}, d.name);
           // Transformación para Laravel Blade
            layer.on("click", () => window.location.href = `${window.baseSectorUrl}/${d.id}`);
            layer.on("mouseover", (e) => { if(e.target._path) e.target._path.style.cursor = 'pointer'; });
        }
    });

    // --- 7. CONFIGURACIÓN DEL MINIMAPA ---
    var miniMapLayer = L.tileLayer(mbUrl1);
    var miniMapGroup = L.layerGroup([miniMapLayer, overlaysMinimap]);

    /*var miniMap = new L.Control.MiniMap(miniMapGroup, {
        position: 'bottomleft',
        width: 110, height: 110,
        toggleDisplay: true,
        aimingRectOptions: {color: "#ffffff", weight: 1.5, opacity: 0.8, fillOpacity: 0.1},
        shadowRectOptions: {color: "#000", weight: 1, opacity: 0, fillOpacity: 0}
    }).addTo(mymap);*/

    // --- 8. ETIQUETAS GEOGRÁFICAS FIJAS ---
    const geoLabels = [
        {coords: [-28.1988, -69.4750], txt: 'CHILE', col: '#ff4d4d', cls: 'labelClass_blue'},
        {coords: [-28.2073, -69.4689], txt: 'ARGENTINA', col: '#ff4d4d', cls: 'labelClass_blue'},
        {coords: [-28.1193, -69.6939], txt: 'Río Ramadillas', col: '#87ceeb', cls: 'labelClass_blue'},
        {coords: [-28.1364, -69.7703], txt: 'Río Pulido', col: '#87ceeb', cls: 'labelClass_blue'},
        {coords: [-28.0919, -69.7424], txt: 'Río Vizcachas', col: '#87ceeb', cls: 'labelClass_blue'},
        {coords: [-28.1458, -69.5957], txt: 'Qda. La Brea', col: '#87ceeb', cls: 'labelClass_blue'},
        {coords: [-28.2006, -69.5706], txt: 'Qda. Caserones', col: '#87ceeb', cls: 'labelClass_blue'}
    ];
    geoLabels.forEach(l => {
        L.marker(l.coords, {icon: createPremiumLabel(l.cls, l.txt, l.col), interactive: false}).addTo(mymap);
    });

    if (typeof frontera !== 'undefined') L.polyline(frontera, {color: 'red', dashArray: '10, 10', weight: 2}).addTo(mymap);

    mymap.scrollWheelZoom.disable();
};