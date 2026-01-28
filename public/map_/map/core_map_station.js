(function() {

    L.Control.MagnifyingGlass = L.Control.extend({

	_magnifyingGlass: false,

	options: {
	    position: 'topleft',
	    title: 'Toggle Magnifying Glass',
	    forceSeparateButton: false
	},

	initialize: function (magnifyingGlass, options) {
	    this._magnifyingGlass = magnifyingGlass;
	    // Override default options
	    for (var i in options) if (options.hasOwnProperty(i) && this.options.hasOwnProperty(i)) this.options[i] = options[i];
	},

	onAdd: function (map) {
	    var className = 'leaflet-control-magnifying-glass', container;

	    if (map.zoomControl && !this.options.forceSeparateButton) {
		container = map.zoomControl._container;
	    } else {
		container = L.DomUtil.create('div', 'leaflet-bar');
	    }

	    this._createButton(this.options.title, className, container, this._clicked, map, this._magnifyingGlass);
	    return container;
	},

	_createButton: function (title, className, container, method, map, magnifyingGlass) {
	    var link = L.DomUtil.create('a', className, container);
	    link.href = '#';
	    link.title = title;

	    L.DomEvent
		.addListener(link, 'click', L.DomEvent.stopPropagation)
		.addListener(link, 'click', L.DomEvent.preventDefault)
		.addListener(link, 'click', function() {method(map, magnifyingGlass);}, map);

	    return link;
	},

	_clicked: function (map, magnifyingGlass) {
	    if (!magnifyingGlass) {
		return;
	    }

	    if (map.hasLayer(magnifyingGlass)) {
		map.removeLayer(magnifyingGlass);
	    } else {
		magnifyingGlass.addTo(map);
	    }
	}
    });

    L.control.magnifyingglass = function (magnifyingGlass, options) {
	return new L.Control.MagnifyingGlass(magnifyingGlass, options);
    };

})();
function mapland(lat, long, name, subsistema)
{
    //console.log("subsistema=>", subsistema);
    var icon_red = new L.Icon(
    {
        iconUrl: 'assets/img/pozos/marker.png',
        iconAnchor: [6, 41],
        popupAnchor: [5, -37],
    });
    var icon_purple = new L.Icon(
    {
        iconUrl: 'assets/img/pozos/marker_purplee.png',
        iconAnchor: [6, 41],
        popupAnchor: [5, -37],
    });
    var icon_orange = new L.Icon(
    {
        iconUrl: 'assets/img/pozos/marker_o.png',
        iconAnchor: [6, 41],
        popupAnchor: [5, -37],
    });
    var icon_green = new L.Icon(
    {
        iconUrl: 'assets/img/pozos/marker_green.png',
        iconAnchor: [6, 41],
        popupAnchor: [5, -37],
    });
    var icon_light = new L.Icon(
    {
        iconUrl: 'assets/img/pozos/marker_light.png',
        iconAnchor: [6, 41],
        popupAnchor: [5, -37],
    });
    var icon_yellow = new L.Icon(
    {
        iconUrl: 'assets/img/pozos/marker_yellow.png',
        iconAnchor: [6, 41],
        popupAnchor: [5, -37],
    });
    var icon_blue = new L.Icon(
    {
        iconUrl: 'assets/img/pozos/marker_blue.png',
        iconAnchor: [6, 41],
        popupAnchor: [5, -37],
    });
    var icon_pink = new L.Icon(
    {
        iconUrl: 'assets/img/pozos/marker_pink.png',
        iconAnchor: [6, 41],
        popupAnchor: [5, -37],
    });
    var icon_sky = new L.Icon(
    {
        iconUrl: 'assets/img/pozos/marker_sky.png',
        iconAnchor: [6, 41],
        popupAnchor: [5, -37],
    });
    var icon_maroon = new L.Icon(
    {
        iconUrl: 'assets/img/pozos/marker_maroon.png',
        iconAnchor: [6, 41],
        popupAnchor: [5, -37],
    });
    if (subsistema == '1')
    {
        tipo_icono = icon_red
        clase = 'labelClass_red';
    }
    if (subsistema == '2')
    {
        tipo_icono = icon_yellow
        clase = 'labelClass_yellow';
    }
    if (subsistema == '3')
    {
        /*tipo_icono=icon_red
        clase='labelClass_red';*/
        //tipo_icono=icon_light
        tipo_icono = icon_blue;
        clase = 'labelClass_blue';
        //clase='labelClass_light';
    }
    if (subsistema == '4')
    {
        tipo_icono = icon_orange
        clase = 'labelClass_orange';
    }
    if (subsistema == '5')
    {
        tipo_icono = icon_green
        clase = 'labelClass_green';
    }
    if (subsistema == '6')
    {
        tipo_icono = icon_light
        clase = 'labelClass_light';
    }
    if (subsistema == '7')
    {
        tipo_icono = icon_light
        clase = 'labelClass_light';
    }
    if (subsistema == '8')
    {
        tipo_icono = icon_orange
         clase = 'labelClass_orange';

    
    }
    if (subsistema == '9')
    {
        clase = 'labelClass_green';
        tipo_icono = icon_green
    
    }
    if (subsistema == '10')
    {
        tipo_icono = icon_purple
        clase = 'labelClass_purple';
    }
    if (subsistema == '11')
    {
        tipo_icono = icon_maroon
        clase = 'labelClass_maroon';
    }
    var createLabelIcon = function(labelClass, labelText)
    {
        return L.divIcon(
        {
            className: labelClass,
            html: labelText,
            iconSize: [41, 51],
            iconAnchor: [17, 15],
            popupAnchor: [1, -34],
        })
    };
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const sector = urlParams.get('sector');
    //console.log(sector);
    var icon_subt = new L.Icon(
    {
        iconUrl: 'assets/img/pozos/marker.png',
        iconAnchor: [14, 41],
        popupAnchor: [3, -34],
    });
    //mbAttr1 = 'Tiles &copy; Esri &mdash; Source: USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community';
    mbAttr1 = '&copy; Captura de Imagen: Abril-2021 ';
    mbUrl1 = 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}'
    base_layer = L.tileLayer(mbUrl1,
    {
        id: 'mapbox.streets',
        attribution: '&copy; Captura de Imagen: Abril-2021'
    });
    var mymap = L.map('mapid',
    {
        zoomControl: false,
    }).setView([lat, long], 11);
    
   

    L.tileLayer(mbUrl1,
    {
        id: 'mapbox.streets',
        attribution: '&copy; Captura de Imagen: Abril-2021'
    }).addTo(mymap);
    //console.log(tipo_icono)
    //console.log(clase);
    var m = L.marker([lat, long],
    {
        icon: tipo_icono
    }).bindLabel(name).addTo(mymap);
    /*var nombres = new L.Marker(new L.latLng([lat, long]),
    {
        icon: createLabelIcon(clase, name)
    }).addTo(mymap);*/
    mymap.setZoom(13);
    var river = L.river(rio,
    {
        minWidth: 4, // px
        maxWidth: 4,
        color: "#29439c", // px
    }).bindLabel('<span class="pop_text">  Río Vizcachas de Pulido <span>').addTo(mymap);
    var river = L.river(rio_4,
    {
        minWidth: 4, // px
        maxWidth: 4, // px
        color: "#29439c", // px
    }).bindLabel('<span class="pop_text"> Río Ramadillas  <span>').addTo(mymap);
    var river = L.river(rio_5,
    {
        minWidth: 4, // px
        maxWidth: 4, // px
        color: "#29439c", // px
    }).bindLabel('<span class="pop_text"> Río  Pulido<span>').addTo(mymap);
    var labrea = L.river(qdalabrea,
    {
        minWidth: 2, // px
        maxWidth: 2, // px
        color: "#87ceeb ", // px
    }).bindLabel('<span class="pop_text"> Quebrada La Brea<span>').addTo(mymap);
    var quebrada2 = L.river(q2,
    {
        minWidth: 2, // px
        maxWidth: 2, // px
        color: "#87ceeb ", // px
    }).addTo(mymap);
    var quebrada3 = L.river(q3,
    {
        minWidth: 2, // px
        maxWidth: 2, // px
        color: "#87ceeb ", // px
    }).addTo(mymap);
    var quebrada4 = L.river(q4,
    {
        minWidth: 2, // px
        maxWidth: 2, // px
        color: "#87ceeb ", // px
    }).addTo(mymap);
    var quebrada5 = L.river(q5,
    {
        minWidth: 2, // px
        maxWidth: 2, // px
        color: "#87ceeb ", // px
    }).addTo(mymap);
    var quebrada6 = L.river(q6,
    {
        minWidth: 2, // px
        maxWidth: 2, // px
        color: "#87ceeb ", // px
    }).addTo(mymap);
    var quebrada7 = L.river(q7,
    {
        minWidth: 2, // px
        maxWidth: 2, // px
        color: "#87ceeb ", // px
    }).bindLabel('<span class="pop_text"> Quebrada Roco<span>').addTo(mymap);
    var quebrada8 = L.river(q8,
    {
        minWidth: 2, // px
        maxWidth: 2, // px
        color: "#87ceeb ", // px
    }).bindLabel('<span class="pop_text"> Quebrada La Brea<span>').addTo(mymap);
    var quebrada9 = L.river(q9,
    {
        minWidth: 2, // px
        maxWidth: 2, // px
        color: "#87ceeb ", // px
    }).bindLabel('<span class="pop_text"> Quebrada Roco<span>').addTo(mymap);
    var quebrada10 = L.river(q10,
    {
        minWidth: 2, // px
        maxWidth: 2, // px
        color: "#87ceeb ", // px
    }).bindLabel('<span class="pop_text"> Quebrada La Escarcha<span>').addTo(mymap);
    var quebrada11 = L.river(q11,
    {
        minWidth: 2, // px
        maxWidth: 2, // px
        color: "#87ceeb ", // px
    }).addTo(mymap);
    var quebrada12 = L.river(q12,
    {
        minWidth: 2, // px
        maxWidth: 2, // px
        color: "#87ceeb ", // px
    }).addTo(mymap);
    var quebrada13 = L.river(q13,
    {
        minWidth: 2, // px
        maxWidth: 2, // px
        color: "#87ceeb ", // px
    }).addTo(mymap);
    var quebrada14 = L.river(q14,
    {
        minWidth: 2, // px
        maxWidth: 2, // px
        color: "#87ceeb ", // px
    }).bindLabel('<span class="pop_text"> Quebrada Caserones<span>').addTo(mymap);
    var quebrada16 = L.river(q16,
    {
        minWidth: 2, // px
        maxWidth: 2, // px
        color: "#87ceeb ", // px
    }).addTo(mymap);
    var quebrada18 = L.river(q18,
    {
        minWidth: 2, // px
        maxWidth: 2, // px
        color: "#87ceeb ", // px
    }).addTo(mymap);
    var quebrada19 = L.river(q19,
    {
        minWidth: 2, // px
        maxWidth: 2, // px
        color: "#87ceeb ", // px
    }).addTo(mymap);
    var quebrada20 = L.river(q20,
    {
        minWidth: 2, // px
        maxWidth: 2, // px
        color: "#87ceeb ", // px
    }).addTo(mymap);
    var quebrada21 = L.river(q21,
    {
        minWidth: 2, // px
        maxWidth: 2, // px
        color: "#87ceeb ", // px
    }).addTo(mymap);
    var quebrada22 = L.river(q22,
    {
        minWidth: 2, // px
        maxWidth: 2, // px
        color: "#87ceeb ", // px
    }).addTo(mymap);
    var quebrada23 = L.river(q23,
    {
        minWidth: 2, // px
        maxWidth: 2, // px
        color: "#87ceeb ", // px
    }).addTo(mymap);
    var quebrada24 = L.river(q24,
    {
        minWidth: 2, // px
        maxWidth: 2, // px
        color: "#87ceeb ", // px
    }).addTo(mymap);
    
    
     var planta = L.polygon(planta_procesos,
    {
        color: '#48FEAC',
        fillColor: '',
        fillOpacity: '0.0',
        radius: 400,
         weight: 3 
    }).on("click", function(e)
    {
        /*alert("hola");*/
       
    }).bindLabel('<span class="pop_text"> Planta de<br> Procesos<span>').addTo(mymap);
    
    
    
    var rajo = L.polygon(rajo_caserones,
    {
        color: '#be0000',
        fillColor: '',
        fillOpacity: '0.0',
        radius: 500,
         weight: 3
    }).on("click", function(e)
    {
        /*alert("hola");*/
    }).bindLabel('<span class="pop_text"> Zona Rajo<span>').addTo(mymap);
    
    
    
    var campamento = L.polygon(campamentos,
    {
        color: 'red',
        fillColor: '',
        fillOpacity: '0.0',
        radius: 400
    }).on("click", function(e)
    {
        /*alert("hola");*/
       
    }).bindLabel('<span class="pop_text"> Campamento<span>', { noHide: true }).addTo(mymap);
    
    
     var porton = L.polygon(portones,
    {
        color: 'red',
        fillColor: '',
        fillOpacity: '0.0',
        radius: 400
    }).on("click", function(e)
    {
        /*alert("hola");*/
       
    }).bindLabel('<span class="pop_text"> Acceso a Faena Industrial <span>').addTo(mymap);
    
    
     
    //$('.leaflet-control-attribution').hide();
    mymap.dragging.disable();
    //mymap.dragging.enable();
    mymap.scrollWheelZoom.disable();
     mymap.invalidateSize();
    if (sector == 1)
    {
        var dep_lamas = L.polygon(deposito_lamas,
        {
            color: '#66023C',
            fillColor: '#66023C',
            fillOpacity: 0.5,
            radius: 500
        }).on("click", function(e)
        {
            /*alert("hola");*/
            //window.location.href = "sector.php?sector=1";
        }).bindLabel('<center><span class="pop_text"> Depósito de <br> Lamas La Brea<span></center>').addTo(mymap);
        var dep_lastre = L.polygon(deposito_lastre,
        {
            color: '#FFFF5C',
            fillColor: '#FFFF5C',
            fillOpacity: 0.5,
            radius: 500
        }).on("click", function(e)
        {
            /*alert("hola");*/
           // window.location.href = "sector.php?sector=4";
        }).bindLabel('<span class="pop_text">Depósito de Lastre<span>').addTo(mymap);
    }
    
    if (sector == 2)
    {
        var dep_arenas = L.polygon(arenas,
        {
            color: '#f77f00',
            fillColor: '#f77f00',
            fillOpacity: 0.5,
            radius: 500
        }).on("click", function(e)
        {
            /*alert("hola");*/
           // window.location.href = "sector.php?sector=2";
        }).bindLabel('<center><span class="pop_text"> Depósito de <br> Arenas Caserones<span></center>').addTo(mymap);
    }
    if (sector == 3)
    {
        var dep_ramadillas = L.polygon(ramadillas,
        {
            color: '#33B503',
            fillColor: '#33B503',
            fillOpacity: 0.5,
            radius: 500,
            
        }).on("click", function(e)
        {
            /*alert("hola");*/
           // window.location.href = "sector.php?sector=3";
        }).bindLabel('<center><span class="pop_text"> Sistema Río<br> Ramadillas<span></center>').addTo(mymap);
    }
    if (sector == 4)
    {
        var dep_lastre = L.polygon(deposito_lastre,
        {
            color: '#FFFF5C',
            fillColor: '#FFFF5C',
            fillOpacity: 0.5,
            radius: 500
        }).on("click", function(e)
        {
            /*alert("hola");*/
            //window.location.href = "sector.php?sector=4";
        }).bindLabel('<span class="pop_text">Depósito de Lastre<span>').addTo(mymap);
        
        /****************************/
        
        
        var dep_lamas = L.polygon(deposito_lamas,
        {
            color: '#66023C',
            fillColor: '#66023C',
            fillOpacity: 0.5,
            radius: 500
        }).on("click", function(e)
        {
            /*alert("hola");*/
            //window.location.href = "sector.php?sector=1";
        }).bindLabel('<center><span class="pop_text"> Depósito de <br> Lamas La Brea<span></center>').addTo(mymap);
        
        
        
        
        
        
    }
}

function getTipeMarker(subsistema) {
    const iconos = {
        '1': icon_red,
        '2': icon_purple,
        '3': icon_yellow,
        '4': icon_orange,
        '5': icon_green,
        '6': icon_sky,
        '7': icon_sky,
        '8': icon_yellow,
        '9': icon_light,
        '10': icon_pink,
        '11': icon_green,
    };

    return iconos[subsistema] || default_icon; // Asume que default_icon es la variable para un icono predeterminado, si es necesario.
}

function getTypeClass(subsistema)
{
    let clase
    if (subsistema == '1')
    {
        clase = 'labelClass_red';
    }
    if (subsistema == '2')
    {}
    if (subsistema == '3')
    {}
    if (subsistema == '4')
    {}
    if (subsistema == '5')
    {}
    if (subsistema == '6')
    {}
    if (subsistema == '7')
    {}
    if (subsistema == '8')
    {}
    if (subsistema == '9')
    {}
    if (subsistema == '10')
    {}
    if (subsistema == '11')
    {}
    return clase;
}