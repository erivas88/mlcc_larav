<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Sistema de Monitoreo</title>
      <!-- Bootstrap CSS -->
      <link href="https://cdn.jsdelivr.net/npm/maplibre-gl@4.7.1/dist/maplibre-gl.min.css" rel="stylesheet">
      <link rel="stylesheet" href="https://unpkg.com/maplibre-gl-minimap/dist/maplibre-gl-minimap.css">
      <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
      <script src="https://kit.fontawesome.com/e5291bc371.js" crossorigin="anonymous"></script>
      <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
      <link rel="stylesheet" href="{{ asset('map/leaflet.css') }}">
      <link rel="stylesheet" href="{{ asset('map/leaflet-label.css') }}">
      <link rel="stylesheet" href="{{ asset('map/L.Control.ZoomBox.css')}}">
      <link rel="stylesheet" href="{{ asset('css/styles_reload.css') }}">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet-minimap/3.6.1/Control.MiniMap.min.css" />
      <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
   </head>

 
   <body>
      <div class="main-container">
      @include('partials.navbar')
      <style>
      </style>
      <div class="container-fluid mt-4">
      <div class="row" >
         @include('partials.side_estacion')
         <div class="col-md-9">
            <div class="panel">
               <div class="tope-majestuoso"> 
    <div id="sistema-header"> 
        <div class="sistema-main">
            <i class="fas fa-map-marker-alt sistema-icon" 
               style="color: {{ $ficha['color'] ?? '#1abc9c' }}"></i>
            <h1 class="sistema-title">
                {{ $ficha['nombre_pdc'] ?? 'Punto de Control' }}
            </h1>
        </div>

        <span class="sistema-divider"><i class="fas fa-chevron-right "></i></span>

        <div class="sistema-brand">
            <span class="brand-name" style="color: #FFFFFF; font-weight: normal">
                {{ $ficha['objetivo'] ?? 'Monitoreo Ambiental' }}
            </span>
            
        </div>
    </div>
</div>
               <hr>
               <div class="row g-4">
                  @include('partials.info')
                  @include('partials.chart')
                 
               </div>
            </div>
         </div>
         <!-- Footer -->
         @include('partials.footer')
      </div>
      <!-- Bootstrap JS -->
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
      
      <link rel="stylesheet" href="{{ asset('map/leaflet.css') }}">
      <script type="text/javascript" src="{{ asset('map/leaflet.js') }}"></script>
      <script type="text/javascript" src="{{ asset('map/leaflet-label.js') }}"></script>
      <script type="text/javascript" src="{{ asset('map/leaflet-river.js') }}"></script>
      <script type="text/javascript" src="{{ asset('map/L.Control.ZoomBox.js') }}"></script> 
      <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-minimap/3.6.1/Control.MiniMap.min.js"></script>
      <script type="text/javascript" src="{{ asset('map/sectores.js') }}"></script>
      <script type="text/javascript" src="{{ asset('map/rios.js') }}"></script>
      <script type="text/javascript" src="{{ asset('map/quebradas.js') }}"></script>
      <script type="text/javascript" src="{{ asset('map/mapa_estacion.js') }}"></script>
      <script>
         document.addEventListener('DOMContentLoaded', function() {
            // Los datos provienen del controlador que usa UtmHelper::ToLL
            initMapEstacion({
                  lat: {{ $ficha['latitud'] }},
                  lon: {{ $ficha['longitud'] }},
                  nombre: "{{ $ficha['nombre_estacion_unificado'] }}",
                  color: "{{ $ficha['color'] ?? '#2ecc71' }}"
            });
         });
      </script>
      <script type="text/javascript" src="{{ asset('map/spin.min.js') }}"></script>
      <script type="text/javascript" src="{{ asset('map/leaflet.spin.min.js') }}"></script>
      <script>
         // Definimos una variable global que el archivo JS pueda leer
         window.estacionConfig = {
             nombre: "{{ $ficha['nombre_estacion_unificado'] }}"
         };
      </script>
      <script src="https://code.highcharts.com/stock/highstock.js"></script>
      <script src="https://code.highcharts.com/modules/exporting.js"></script>
      <script src="https://code.highcharts.com/modules/export-data.js"></script>
      <script src="https://code.highcharts.com/modules/no-data-to-display.js"></script>
      <script type="text/javascript" src="{{ asset('plots/plot.js') }}"></script>
   </body>
</html>