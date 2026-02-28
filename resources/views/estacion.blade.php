<!DOCTYPE html>
<html lang="en">
   <head>
      @include('partials.fav')
      <title>  {{ $ficha['nombre_pdc'] ?? 'Punto de Control' }}</title>
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
      <script type="text/javascript" src="{{ asset('map/sectores.js') }}"></script>
      <script type="text/javascript" src="{{ asset('map/rios.js') }}"></script>
      <script type="text/javascript" src="{{ asset('map/quebradas.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const carousel = document.getElementById('carouselMapas');

    // 🔹 Si existe carrusel → es multinivel
    if (carousel) {

        const estaciones = @json($ficha['datosMultinivel'] ?? []);
        const colorPrincipal = @json($ficha['color'] ?? '#2ecc71');

        estaciones.forEach(e => {

            const mapData = {
                lat: parseFloat(e.latitud),
                lon: parseFloat(e.longitud),
                nombre: e.nombre_estacion,
                color: e.color ||  colorPrincipal
            };

            console.log('🗺️ Multinivel → initMapEstacion:', mapData);

            initMapEstacion(mapData, 'map-' + e.id_estacion);
        });

    } 
    // 🔹 Si no existe carrusel → mapa normal
    else {

        const mapDetail = document.getElementById('map-detail');
        if (!mapDetail) return;

        const mapData = {
            lat: parseFloat(@json($ficha['latitud'] ?? 'null')),
            lon: parseFloat(@json($ficha['longitud'] ?? 'null')),
            nombre: @json($ficha['nombre_estacion_unificado'] ?? ''),
            color: @json($ficha['color'] ?? '#2ecc71')
        };

        console.log('🗺️ Mapa Normal → initMapEstacion:', mapData);

        initMapEstacion(mapData, 'map-detail');
    }

});
</script>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const carousel = document.getElementById('carouselMapas');
    if (!carousel) return;

    carousel.addEventListener('slid.bs.carousel', function (e) {
        const activeSlide = e.relatedTarget;
        if (!activeSlide) return;

        const mapDiv = activeSlide.querySelector("[id^='map-']");
        if (!mapDiv) return;

        const mapId = mapDiv.id;

        // Si el mapa ya está cargado, actualiza su tamaño para que se muestre correctamente
        if (window._maps && window._maps[mapId]) {
            requestAnimationFrame(() => {
                window._maps[mapId].invalidateSize();
            });
        }
    });

});
</script>

   

         


      <script type="text/javascript" src="{{ asset('map/multi_mapa.js') }}"></script>
      
      <script type="text/javascript" src="{{ asset('map/spin.min.js') }}"></script>
      <script type="text/javascript" src="{{ asset('map/leaflet.spin.min.js') }}"></script>
      <script>
         // Definimos una variable global que el archivo JS pueda leer
         window.estacionConfig = {
             nombre: "{{ $ficha['nombre_estacion_unificado'] }}"
         };
      </script>
      <script type="text/javascript"  src="{{ asset('stock/code/highstock.js') }}"></script>
      <script type="text/javascript"  src="{{ asset('stock/code/modules/exporting.js') }}"></script>
      <script type="text/javascript"  src="{{ asset('stock/code/modules/export-data.js') }}"></script>
      <script type="text/javascript"  src="{{ asset('stock/code/modules/no-data-to-display.js') }}"></script>
      <script type="text/javascript" src="{{ asset('plots/plot.js') }}"></script>
   </body>
</html>