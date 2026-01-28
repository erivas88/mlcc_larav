function flytodata(id_estacion, sector)
{
    /*if (subsistema == 11)
    {
        window.location.href = "estacion.php?" + "id=" + id_estacion + "&sector=" + sector + "&umbrales=" + 1;
    }
    else
    {
        window.location.href = "estacion.php?" + "id=" + id_estacion + "&sector=" + sector;
    }*/
    console.log(id_estacion,sector);

    window.location.href = "estacion.php?" + "id=" + id_estacion + "&sector=" + sector ;
}
window.onload = function()
{
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const sector = urlParams.get('sector');
    const subsistema = urlParams.get('subsistema');
    if ((sector == 3))
    {
       // $("#modal_umbral_labrea").modal();
    }
    if ((sector == 4))
    {
      //  $("#modal_umbral_caserones").modal();
    }
    limites = new L.LatLngBounds(new L.LatLng(-28.21, -69.83), new L.LatLng(-28.07, -69.46));
    let markers = [];
    //console.log(sector,subsistema);
    var area = [],
        area_nombres = [],
        zona, zona_nombres;
    // console.log('Marcadores', markers);

    function flytodata(id_estacion, sector, subsistema)
    {
        if (subsistema == 11)
        {
            window.location.href = "estacion.php?" + "id=" + id_estacion + "&sector=" + sector + "&umbrales=" + 1;
        }
        else
        {
            window.location.href = "estacion.php?" + "id=" + id_estacion + "&sector=" + sector;
        }
    }

    function onClickSub(e)
    {
        let estacion = e.target.id_estacion;
        let subsistema = e.target.subsistema;
        let st = sector;
        flytodata(estacion, st, subsistema);
    }


    function ObtainMarkers(sector)
    {
        var markers = $.ajax(
        {
            async: false,
            url: "controller/getMarkers.php",
            type: "POST",
            data:
            {
                sector: sector
            },
            dataType: "JSON"
        }).responseJSON;
        return markers;
    }

    function LocateAllFeatures(iobMap, iobFeatureGroup)
    {
        if (Array.isArray(iobFeatureGroup))
        {
            var obBounds = L.latLngBounds();
            for (var i = 0; i < iobFeatureGroup.length; i++)
            {
                obBounds.extend(iobFeatureGroup[i].getBounds());
            }
            iobMap.fitBounds(obBounds,
            {
                padding: [50, 50]
            });
        }
        else
        {
            iobMap.fitBounds(iobFeatureGroup.getBounds(),
            {
                padding: [50, 50]
            });
        }
        var z = iobMap.getZoom();
        //  iobMap.setZoom(12);
        //console.log('levelzoom', z)
    }
    var createLabelIcon = function(labelClass, labelText)
    {
        return L.divIcon(
        {
            className: labelClass,
            html: labelText,
            iconSize: [51, 51],
            iconAnchor: [17, 15],
            popupAnchor: [1, -34],
        })
    };
    var icon_red = new L.Icon(
    {
        iconUrl: 'assets/img/pozos/marker.png',
        iconAnchor: [10, 41],
        popupAnchor: [5, -37],
    });
    var icon_purple = new L.Icon(
    {
        iconUrl: 'assets/img/pozos/marker_purplee.png',
        iconAnchor: [10, 41],
        popupAnchor: [5, -37],
    });;
    var icon_orange = new L.Icon(
    {
        iconUrl: 'assets/img/pozos/marker_o.png',
        iconAnchor: [10, 41],
        popupAnchor: [5, -37],
    });
    var icon_green = new L.Icon(
    {
        iconUrl: 'assets/img/pozos/marker_green.png',
        iconAnchor: [10, 41],
        popupAnchor: [5, -37],
    });
    var icon_light = new L.Icon(
    {
        iconUrl: 'assets/img/pozos/marker_light.png',
        iconAnchor: [10, 41],
        popupAnchor: [5, -37],
    });
    var icon_yellow = new L.Icon(
    {
        iconUrl: 'assets/img/pozos/marker_yellow.png',
        iconAnchor: [10, 41],
        popupAnchor: [5, -37],
    });
    var icon_blue = new L.Icon(
    {
        iconUrl: 'assets/img/pozos/marker_blue.png',
        iconAnchor: [10, 41],
        popupAnchor: [5, -37],
    });
    var icon_pink = new L.Icon(
    {
        iconUrl: 'assets/img/pozos/marker_pink.png',
        iconAnchor: [10, 41],
        popupAnchor: [5, -37],
    });
    var icon_maroon = new L.Icon(
    {
        iconUrl: 'assets/img/pozos/marker_maroon.png',
        iconAnchor: [10, 41],
        popupAnchor: [5, -37],
    });

    var mbAttr = 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' + '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' + 'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        mbUrl = 'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw';
    streets = L.tileLayer(mbUrl,
    {
        id: 'mapbox/streets-v11',
        attribution: '&copy; Captura de Imagen: Abril-2021'
    });

    
    var load = L.tileLayer('https://api.mapbox.com/styles/v1/mapbox/emerald-v8/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiZWxpb3JpdmFzODgiLCJhIjoiY2p4NjQ1ZHJkMDg1ZzN5cGY0dzN6ZmgwdSJ9.wVoukk9vF2mhOmEeQK4M4Q',
    {
        tileSize: 512,
        zoomOffset: -1,
        attribution: '© <a href="https://www.mapbox.com/map-feedback/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    });
    var grayscale = L.tileLayer(mbUrl,
    {
        id: 'mapbox/light-v9',
        attribution: mbAttr
    });
    mbAttr1 = '&copy; Captura de Imagen: Abril-2021'

    mbUrl1 = 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}'
    base_layer = L.tileLayer(mbUrl1,
    {
        id: 'mapbox.streets',
        attribution: mbAttr1
    });









    if (sector == 4)
    {
        maxZoom = 14
    }
    else
    {
        maxZoom = 17
    }
    

    
    
  
    
    
    
   
    
    /* if (sector == 2)
     {
         maxZoom = 17
     }
     if (sector == 3)
     {
         maxZoom = 16;
     }
     if (sector == 1)
     {
         maxZoom = 14;
     }*/
    if (subsistema != null)
    {
        core = [];
     
        //console.log('subsistema existe =>',subsistema);
        marker_sub = ObtainMarkersSUB(sector, subsistema);
        markers = marker_sub.data;
        //console.log(marker_sub);
        //console.log(marker_sub.subsistema);
        $("#subsistema").html(marker_sub.subsistema);
        $("#texto").html(marker_sub.texto);
        for (k = 0; k < markers.length; k++)
        {
            // console.log('hola');
            core.push(new L.LatLng(markers[k].latitud, markers[k].longitud))
        }
        if (sector == 3)
        {
           // core.push(new L.LatLng(-28.087519, -69.807400));
            //core.push(new L.LatLng(-28.229375, -69.542348));
        }
        if (sector == 4)
        {
            core.push(new L.LatLng(-28.132393, -69.616579));
            core.push(new L.LatLng(-28.175424, -69.548553));
        }
        if (sector == 1)
        {
            /*core.push(new L.LatLng(-28.139764, -69.652518));
            core.push(new L.LatLng(-28.116253, -69.596104));
            core.push(new L.LatLng(-28.175424, -69.548553));*/
        }
        if (sector == 2)
        {
            core.push(new L.LatLng(-28.209970, -69.57928));
            core.push(new L.LatLng(-28.155646, -69.516257));
        }

    }
    else
    {
        core = [];
       // mymap.spin(true);
        //console.log('subsistema dont exist');
        markers = ObtainMarkers(sector);
        //console.log(markers);
        // console.log(markers.length);
        for (k = 0; k < markers.length; k++)
        {
            //console.log('hola');
            core.push(new L.LatLng(markers[k].latitud, markers[k].longitud));
        }
        if (sector == 3)
        {
           // core.push(new L.LatLng(-28.087519, -69.807400));
        //    core.push(new L.LatLng(-28.229375, -69.542348));
        }
        if (sector == 4)
        {
            core.push(new L.LatLng(-28.132393, -69.616579));
            core.push(new L.LatLng(-28.175424, -69.548553));
        }
        if (sector == 1)
        {
            core.push(new L.LatLng(-28.139764, -69.652518));
            core.push(new L.LatLng(-28.116253, -69.596104));
            core.push(new L.LatLng(-28.175424, -69.548553));
        }
        if (sector == 2)
        {
            core.push(new L.LatLng(-28.209970, -69.57928));
            core.push(new L.LatLng(-28.155646, -69.516257));
        }
       // mymap.spin(false);
    }
    //console.log(core);
    nucleo = new L.LatLngBounds(core);
    //console.log(nucleo._northEast.lat);
    //console.log(nucleo._northEast.lng);
    //console.log(nucleo._southWest.lat);
    //console.log(nucleo._southWest.lng);
    /*nucleo._northEast.lat=nucleo._northEast.lat*1.05*/
    
    /* nucleo._northEast.lng=nucleo._northEast.lng*1.05;*/
    /* nucleo._southWest.lat=nucleo._southWest.lat*1.05;
     nucleo._southWest.lng=nucleo._southWest.lng*1.05;*/
    // bounds = new L.LatLngBounds(new L.LatLng(-28.22, -69.80), new L.LatLng(-28.06, -69.43)); 
    // console.log(bounds);    
    var mymap = L.map('mapid',
    {
        center: nucleo.getCenter(),
        maxZoom: maxZoom,
        minZoom: 12,
        zoomControl: true,
        maxBounds: nucleo,
        maxBoundsViscosity: 0.75,
      
    });

    
    //  mymap.setZoom(0);
    /* mymap.setView({lat:40.737, lng:-73.923}, 8)*/
    // L.rectangle(nucleo, {color: "#ff7800", weight: 1}).addTo(mymap)
    if (sector == 3)
    {
         mymap.options.maxZoom=14;
         //mymap.options.minZoom=14;
    }
    if (sector == 4)
    {
        mymap.options.minZoom=13;
    }
  
    //  L.rectangle(nucleo, {color: "#ff7800", weight: 1}).addTo(mymap);
    // console.log(mymap);
    //console.log(mymap.touchZoom);
    mymap.spin(true);
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
    var campamento = L.polygon(campamentos,
    {
        color: 'red',
        fillColor: '',
        fillOpacity: '0.0',
        radius: 400,
        weight: 3
    }).on("click", function(e)
    {
        /*alert("hola");*/
    }).bindLabel('<span class="pop_text"> Campamento<span>',
    {
        noHide: true
    }).addTo(mymap);
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
    /*var lix = L.polygon(lixiviacion,
    {
        color: '#0b7fab',
        fillColor: '',
        fillOpacity: '0.0',
        radius: 400
    }).on("click", function(e)
    {
        /*alert("hola");*/
   /* }).bindLabel('<span class="pop_text"> Dump leaching <span>').addTo(mymap);*/
    //mymap.spin(false);
    //mymap.options.maxZoom = 14.5;
    var basemap = new  L.tileLayer(mbUrl1,
    {
        id: 'mapbox.streets',
        attribution: mbAttr1
    }).addTo(mymap);

    mymap.spin(true);

    basemap.on('load', function (event) {
       // console.log('all tiles loaded');
        mymap.spin(false);
      });




    var control = L.control.zoomBox(
    {
        modal: true
    });
    mymap.addControl(control);
    //  L.control.scale().addTo(mymap);
    mymap.setView(nucleo.getCenter(), 10);
    var osmUrl1 = 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
    var osmUrl2 = 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
    var osmAttrib = 'Map data &copy; OpenStreetMap contributors';
    var osm1 = new L.TileLayer(osmUrl1,
    {
        minZoom: 9,
        maxZoom: 18,
        attribution: osmAttrib
    });
    var osm2 = new L.TileLayer(osmUrl2,
    {
        minZoom: 9,
        maxZoom: 18,
        attribution: osmAttrib
    });
    
    var miniMap = new L.Control.MiniMap(base_layer,
    {
        toggleDisplay: true,
        width: 100,
        height: 100,
        position: 'bottomleft'
    }).addTo(mymap);
    
    
    $(".leaflet-control-minimap").addClass("yborder");
   // $(".leaflet-zoom-hide").addClass("yborder");
    
    var rajo2 = L.polygon(rajo_caserones,
    {
        color: '#be0000',
        fillColor: '',
        fillOpacity: '0.0',
        radius: 500,
         weight: 3
    });
    /*	var miniMap = new L.Control.MiniMap(osm2,rajo2, {zoomLevelFixed: 10, autoToggleDisplay: true, width:100, height:100, position: 'bottomleft'}).addTo(mymap);
    	
        // var poly = L.polygon(polygonPoints).addTo(map);
    	*/
    var baselayers = {
        'OpenStreetMap': L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        {
            attribution: '&copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>'
        }),
    };
    var overlays = {
        'Polygon': L.polygon(
            [
                [0, 0],
                [48, -3],
                [50, -3],
                [50, -4],
                [52, 4],
                [0, 0]
            ],
            {
                color: '#aa0000',
                fillColor: '#ff0000'
            }),
    };
 
    var baseLayers = {
        "Streets": osm1,
        "Satélite": base_layer,
    };
    L.control.layers(baseLayers).addTo(mymap);
    var osmAttrib = 'Map data &copy; OpenStreetMap contributors';
    var osmUrl = 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
     let tipo_icono;

     var popupContent = "";
var popupOptions =
    {
      'maxWidth': '500',
      'className' : 'another-popup' // classname for another popup
    }

    $('#count_estaciones').html(markers.length);
    for (var i = 0; i < markers.length; ++i)
    {
        //console.log("Hola");
        test = markers[i].estacion;
        tipo_icono = getTipeMarker(markers[i].subsistema);
        //console.log(tipo_icono);
        clase = getTypeClass(markers[i].subsistema);
        var button ='<a href="#" class="mybtn"  onclick="flytodata(\'' + markers[i].id+ '\',\'' + sector + '\')"  >Ver Estación</a>';
        var popup1 = '<span class="tooltipp"><b> Parámetros en Línea </b><br> '+markers[i].parametros+"</span><br><center>"+button+"</center>";
        var m = L.marker([markers[i].latitud, markers[i].longitud],
        {
            icon: tipo_icono,
        });


        m.bindPopup(popup1);
        m.test = test;
        m.id_estacion = markers[i].id;
        m.subsistema = markers[i].subsistema;  
        
        function onClick(e)
        {
            let estacion = e.target.id_estacion;
            let subsistema = e.target.subsistema;
            let st = sector;
            flytodata(estacion, st, subsistema);
        } 

       /* m.id_estacion = markers[i].id;
        m.subsistema = markers[i].subsistema;
        m.on('click', onClick);

        function onClick(e)
        {
            let estacion = e.target.id_estacion;
            let subsistema = e.target.subsistema;
            let st = sector;
            flytodata(estacion, st, subsistema);
        }*/
        var nombres = new L.Marker(new L.latLng([markers[i].latitud, markers[i].longitud]),
        {
            icon: createLabelIcon(clase, markers[i].estacion)
        });
        area.push(m);
        area_nombres.push(nombres);
    }
    zona = L.featureGroup(area);
    zona_nombres = L.featureGroup(area_nombres);
    mymap.addLayer(zona);
    mymap.addLayer(zona_nombres);
    mymap.fitBounds(zona.getBounds(),
    {
        padding: [55, 55]
    });
       var polyline = L.polyline(frontera, {color: 'red',  dashArray: '10, 10', dashOffset: '0', weight: 2}).addTo(mymap);
    
    clase = 'labelClass_red';
  
    var nombres = new L.Marker(new L.latLng([-28.198859,-69.475012]),
    {
        icon: createLabelIcon("labelClass_red1", 'CHILE')
    }).addTo(mymap);
    
    /*  var nombres = new L.Marker(new L.latLng([-28.197032, -69.470283]),
    {
        icon: createLabelIcon(clase, 'CHILE2')
    }).addTo(mymap);*/
    
    var nombres = new L.Marker(new L.latLng([-28.207363, -69.46893]),
    {
        icon: createLabelIcon("labelClass_red1", 'ARGENTINA')
    }).addTo(mymap);
    
    var RIOV = new L.Marker(new L.latLng([-28.119320, -69.693991]),
    {
        icon: createLabelIcon("labelClass_blue", 'Río Ramadillas')
    }).addTo(mymap);
    var RIOp = new L.Marker(new L.latLng([-28.136428, -69.770388]),
    {
        icon: createLabelIcon("labelClass_blue", 'Río Pulido')
    }).addTo(mymap);
    var RIOvp = new L.Marker(new L.latLng([-28.091972, -69.742463]),
    {
        icon: createLabelIcon("labelClass_blue", 'Río Vizcachas de Pulido')
    }).addTo(mymap);
    var Quebradax = new L.Marker(new L.latLng([-28.144517, -69.591603]),
    {
        icon: createLabelIcon("labelClass_blue", 'Quebrada La Brea')
    }).addTo(mymap);
    mymap.spin(false);

    function getTipeMarker(subsistema)
    {
        let tipo_icono;
        if (subsistema == '1')
        {
            tipo_icono = icon_red
        }
        if (subsistema == '2')
        {
            tipo_icono = icon_yellow
        }
        if (subsistema == '3')
        {
            tipo_icono = icon_blue
        }
        if (subsistema == '4')
        {
            tipo_icono = icon_orange
        }
        if (subsistema == '5')
        {
            tipo_icono = icon_green
            //tipo_icono=icon_purple
        }
        if (subsistema == '6')
        {
            tipo_icono = icon_light
        }
        if (subsistema == '7')
        {
            tipo_icono = icon_light
        }
        if (subsistema == '8')
        {
            tipo_icono = icon_orange
        }
        if (subsistema == '9')
        {
            tipo_icono = icon_green
        }
        if (subsistema == '10')
        {
            tipo_icono = icon_purple
        }
        if (subsistema == '11')
        {
            tipo_icono = icon_maroon
        }
        return tipo_icono;
    }

    function getTypeClass(subsistema)
    {
        let clase
        if (subsistema == '1')
        {
            clase = 'labelClass_red';
        }
        if (subsistema == '2')
        {
            clase = 'labelClass_yellow';
        }
        if (subsistema == '3')
        {
            clase = 'labelClass_blue';
        }
        if (subsistema == '4')
        {
            clase = 'labelClass_orange';
        }
        if (subsistema == '5')
        {
            clase = 'labelClass_green';
            //clase='labelClass_purple';
        }
        if (subsistema == '6')
        {
            clase = 'labelClass_light';
        }
        if (subsistema == '7')
        {
            clase = 'labelClass_light';
        }
        if (subsistema == '8')
        {
            clase = 'labelClass_orange';
        }
        if (subsistema == '9')
        {
            clase = 'labelClass_green';
        }
        if (subsistema == '10')
        {
            clase = 'labelClass_purple';
        }
        if (subsistema == '11')
        {
            clase = 'labelClass_maroon';
        }
        return clase;
    }
    $(".resize").on("click", function()
    {
        var subsistema = $(this).attr("data-id");
        // console.log(sector, subsistema);
        if ((subsistema == 11) && (sector == 1))
        {
            $("#modal_umbral_labrea").modal();
        }
        if ((subsistema == 11) && (sector == 2))
        {
            $("#modal_umbral_caserones").modal();
        }
        if ((subsistema == 11) && (sector == 4))
        {
            $("#modal_umbral_lastre").modal();
        }
        /* $( ".resize" ).hasClass( "bar" )M*/
        $('.resize').not(this).removeClass('super'); //Remover Super Class
        if ($(this).hasClass("collapsed")) //
        {
            $(this).addClass("xsuper");
            // console.log('Esta Abierto el item');
        }
        else
        {
            //  console.log('x');
        }
        mymap.removeLayer(zona);
        mymap.removeLayer(zona_nombres);
        area = [];
        area_nombres = [];
        zona = [];
        zona_nombres = [];
        core = [];
        //   console.log("url=>", sector);
        //  console.log("sub=>", subsistema);
        var result = ObtainMarkersSUB(sector, subsistema);
        //console.log(result)
        var markers = result.data;
        // console.log(markers)
        var subsistema = result.subsistema;
        $("#subsistema").html(subsistema);
        $("#texto").html(result.texto);
        //console.log("subsistema=>", markers);
        $('#count_estaciones').html(markers.length);
        for (var i = 0; i < markers.length; ++i)
        {
            tipo_icono = getTipeMarker(markers[i].subsistema);
            clase = getTypeClass(markers[i].subsistema);
            /* var m = L.marker([markers[i].latitud, markers[i].longitud], {
            icon: tipo_icono
        }).bindPopup('<center><button class="csb" onclick="flytodata(\'' + markers[i].id+ '\',\'' + sector + '\')"  > Ver estación</button></center>', {
        maxWidth: 300
    });;*/

   


    clase = getTypeClass(markers[i].subsistema);
    var button ='<a href="#" class="mybtn"  onclick="flytodata(\'' + markers[i].id+ '\',\'' + sector + '\')"  >Ver Estación</a>';
    var popup1 = '<span class="tooltipp"><b> Parámetros en Línea</b> <br> '+markers[i].parametros+"</span><br><center>"+button+"</center>";
    var m = L.marker([markers[i].latitud, markers[i].longitud],
    {
        icon: tipo_icono,
    });


    m.bindPopup(popup1);
    m.test = test;
    m.id_estacion = markers[i].id;
    m.subsistema = markers[i].subsistema;  
           /* var m = L.marker([markers[i].latitud, markers[i].longitud],
            {
                icon: tipo_icono,
            });
            m.id_estacion = markers[i].id;
            m.subsistema = markers[i].subsistema;*/
          /*  m.on('click', onClickSub);*/
            var nombres = new L.Marker(new L.latLng([markers[i].latitud, markers[i].longitud]),
            {
                icon: createLabelIcon(clase, markers[i].estacion)
            });
            core.push(new L.LatLng(markers[i].latitud, markers[i].longitud));
            area.push(m);
            area_nombres.push(nombres);
        }
        nucleo = new L.LatLngBounds(core);
        //console.log('nuevo_nucleo=>',nucleo);
        //console.log('nuevo_centro=>',nucleo.getCenter());
        mymap.options.center = nucleo.getCenter();
        mymap.options.maxBounds = nucleo;
        zona = L.featureGroup(area);
        zona_nombres = L.featureGroup(area_nombres);
        mymap.addLayer(zona);
        mymap.addLayer(zona_nombres);
        LocateAllFeatures(mymap, zona);
        //console.log("option1", mymap._layersMaxZoom);
        //console.log("option2", mymap._layersMinZoom);
        //console.log("option3", mymap.options.maxZoom);
        //console.log("option4", mymap.options.minZoom);
        // mymap.options.maxZoom = 16;
        //console.log("option3", mymap.options.maxZoom);
    });

    function onClickSub(e)
    {
        let estacion = e.target.id_estacion;
        let subsistema = e.target.subsistema;
        let st = sector;
        flytodata(estacion, st, subsistema);
    }

    function ObtainMarkersSUB(sector, subsistema)
    {
        var markers = $.ajax(
        {
            async: false,
            url: "controller/getMarkerSector.php",
            type: "POST",
            data:
            {
                sector: sector,
                subsistema: subsistema
            },
            dataType: "JSON"
        }).responseJSON;
        return markers;
    }
    var river = L.river(rio,
    {
        minWidth: 4, // px
        maxWidth: 4,
        color: "#29439c", // px
    }).bindLabel('<span class="pop_text" >  Río Vizcachas de Pulido <span>').addTo(mymap);
    var river = L.river(rio_4,
    {
        minWidth: 4, // px
        maxWidth: 4, // px
        color: "#29439c", // px
    }).bindLabel('<span class="pop_text" > Río Ramadillas  <span>').addTo(mymap);
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
    }).bindLabel('<span class="pop_text" > Quebrada La Brea<span>').addTo(mymap);
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
    }).bindLabel('<span class="pop_text" > Quebrada Roco<span>').addTo(mymap);
    var quebrada8 = L.river(q8,
    {
        minWidth: 2, // px
        maxWidth: 2, // px
        color: "#87ceeb ", // px
    }).bindLabel('<span class="pop_text" > Quebrada La Brea<span>').addTo(mymap);
    var quebrada9 = L.river(q9,
    {
        minWidth: 2, // px
        maxWidth: 2, // px
        color: "#87ceeb ", // px
    }).bindLabel('<span class="pop_text" > Quebrada Roco<span>').addTo(mymap);
    var quebrada10 = L.river(q10,
    {
        minWidth: 2, // px
        maxWidth: 2, // px
        color: "#87ceeb ", // px 
    }).bindLabel('<span class="pop_text" > Quebrada La Escarcha<span>').addTo(mymap);
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
    }).bindLabel('<span class="pop_text"  > Quebrada Caserones<span>').addTo(mymap);
    /* var path = L.polyline(q14, {
             dashArray: "15,15",
             dashSpeed: -30
         });

     mymap.addLayer(path);


     L.circleMarker([10, 70], {
             dashArray: "15,15",
             dashSpeed: -30,
             radius: 147.5
         }).addTo(mymap);*/
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
    mymap.dragging.disable();
    mymap.dragging.enable();
    mymap.scrollWheelZoom.disable();
    if (sector == 1)
    {
        Draw1();
        Draw4();
    }
    if (sector == 2)
    {
        Draw2();
    }
    if (sector == 3)
    {
        Draw3();
        arenaswfill();
        lastrefill();
        lamaswfill();
        
    }
    if (sector == 4)
    {   Draw1();
        Draw4();
    }
    
    function lamaswfill()
    {
        
         var dep_lamas = L.polygon(deposito_lamas,
        {
            color: '#66023C',
            radius: 500,
            weight: 3,
            fillOpacity: 0.5,
        }).on("click", function(e)
        {
            window.location.href = "sector.php?sector=1";
          
        }).bindLabel('<center><span class="pop_text" > Depósito de <br> Lamas La Brea<span></center>').addTo(mymap);
        
    }
    
    function arenaswfill()
    {
         var dep_arenas = L.polygon(arenas,
        {
            color: '#f77f00',
            radius: 300,
            weight: 3,
            fillOpacity: 0.5,
        }).on("click", function(e)
        {
          window.location.href = "sector.php?sector=2";
   
        }).bindLabel('<center><span class="pop_text" > Depósito de <br> Arenas Caserones<span></center>').addTo(mymap);
        
    }
    function lastrefill()
    {
        var dep_lastre = L.polygon(deposito_lastre,
        {
            color: '#FFFF5C',
            radius: 300,
            weight: 3,
            fillOpacity: 0.5,
        }).on("click", function(e)
        {
            
             $("#modal_umbral_caserones").modal();
         
        }).bindLabel('<span class="pop_text" >Depósito de Lastre<span>').addTo(mymap);
        
    }

    function Draw1()
    {
        var dep_lamas = L.polygon(deposito_lamas,
        {
            color: '#66023C',
            fillColor: '#66023C',
            fillOpacity: 0.5,
            radius: 500,
         
        }).on("click", function(e)
        {
           
            window.location.href = "sector.php?sector=1";
        }).bindLabel('<center><span class="pop_text" > Depósito de <br> Lamas La Brea<span></center>').addTo(mymap);
    }

    function Draw2()
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
            window.location.href = "sector.php?sector=2";
        }).bindLabel('<center><span class="pop_text" > Depósito de <br> Arenas Caserones<span></center>').addTo(mymap);
    }

    function Draw3()
    {
        var dep_ramadillas = L.polygon(ramadillas,
        {
            color: '#33B503',
            fillColor: '#33B503',
            fillOpacity: 0.5,
            radius: 500
        }).on("click", function(e)
        {
      
           /* window.location.href = "sector.php?sector=3";*/
            $("#modal_umbral_labrea").modal();
        }).bindLabel('<center><span class="pop_text" > Sistema Río<br> Ramadillas<span></center>').addTo(mymap);
        
        
           var Quebradax1 = new L.Marker(new L.latLng([-28.200673,-69.57067]),
    {
        icon: createLabelIcon("labelClass_blue", 'Quebrada Caserones')
    }).addTo(mymap);
    
    }

    function Draw4()
    {
        
        
        
     
        var dep_lastre = L.polygon(deposito_lastre,
        {
            color: '#FFFF5C',
            fillColor: '#FFFF5C',
            fillOpacity: 0.5,
            radius: 500
        }).on("click", function(e)
        {
            
             $("#modal_umbral_caserones").modal();
              
            
            /*alert("hola");*/
            /*window.location.href = "sector.php?sector=4";*/
        }).bindLabel('<span class="pop_text" >Depósito de Lastre<span>').addTo(mymap);
        // mymap.options.minZoom = 13;
    }
    // $('.leaflet-control-attribution').hide();;
}