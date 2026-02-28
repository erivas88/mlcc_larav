<!DOCTYPE html>
<html lang="en">
   <head>
      @include('partials.fav')
      <title>Sistema de Monitoreo</title>
      <!-- Bootstrap CSS -->
      <link href="https://cdn.jsdelivr.net/npm/maplibre-gl@4.7.1/dist/maplibre-gl.min.css" rel="stylesheet">
      <link rel="stylesheet" href="https://unpkg.com/maplibre-gl-minimap/dist/maplibre-gl-minimap.css">
      <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
      <script src="https://kit.fontawesome.com/e5291bc371.js" crossorigin="anonymous"></script>
      <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
       <link rel="stylesheet" href="{{ asset('css/styles_reload.css') }}">
      <link rel="stylesheet" href="{{ asset('map/leaflet.css') }}">
      <link rel="stylesheet" href="{{ asset('map/leaflet-label.css') }}">
      <link rel="stylesheet" href="{{ asset('map/L.Control.ZoomBox.css')}}">
      <link rel="stylesheet" href="{{ asset('map/Control.MiniMap.css')}}">
      <style>
         .accordion-button.collapsed::after {
         transform: rotate(-90deg); /* Rota el icono 90 grados hacia la derecha */
         transition: transform 0.3s ease; /* Movimiento suave */
         }
         /* 2. Flecha hacia ABAJO cuando el acordeón se ABRE */
         .accordion-button:not(.collapsed)::after {
         transform: rotate(0deg); /* Vuelve a su posición original (hacia abajo) */
         }
         /* Opcional: Si quieres que la flecha sea blanca para que combine con tu botón azul */
         .accordion-button::after {
         filter: brightness(0) invert(1);
         }
         .contenedor-revista {
         max-width: 100%; /* Ancho de lectura óptimo */
         margin: 40px auto;
         padding: 40px;
         background-color: rgba(255, 255, 255, 0.85); /* Fondo muy suave */
         border-radius: 12px;
         }
         .separador-sutil {
         width: 40px;
         height: 2px;
         background-color: transparent;
         margin: 0 auto 20px auto; /* Centrado */
         opacity: 0.4;
         }
         .texto-editorial {
         color: #525b65; /* Gris equilibrado, no negro */
         font-size: 1rem; /* Tamaño natural (16px aprox) */
         line-height: 1.8; /* Espaciado de revista */
         text-align: justify;
         font-weight: 300;
         margin-bottom: 10px;
         }
         .texto-nota {
         color: #6b7280; /* Un tono más claro para la nota técnica */
         font-size: 0.95rem; /* Ligeramente más pequeño */
         line-height: 1.7;
         text-align: justify;
         font-weight: 300;
         font-style: italic; /* Da ese toque de "nota de pie" elegante */
         }
         /* Detalles de énfasis */
         .destaque {
         color: #2a8b98;
         font-weight: 500;
         }
         .numero-enfasis {
         color: #374151;
         font-weight: 600;
         }

         /* --- ESTILO GLASS PARA TOOLTIPS --- */

      </style>
   </head>
   <body>
      <div class="main-container">
         <!-- Header -->
         @include('partials.navbar')
         <div class="container-fluid mt-4">
            <div class="row" >
                @include('partials.menu_n')
                @include('partials.lista')
            </div>
         </div>
         <!-- Footer -->
          @include('partials.footer')
      </div>
      <!-- Bootstrap JS -->
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
      <link rel="stylesheet" href="{{ asset('map/leaflet.css') }}">
      <script type="text/javascript" src="{{ asset('map/leaflet.js') }}"></script>
      <script type="text/javascript" src="{{ asset('map/leaflet-label.js') }}"></script>
      <script type="text/javascript" src="{{ asset('map/leaflet-river.js') }}"></script>
      <script type="text/javascript" src="{{ asset('map/L.Control.ZoomBox.js') }}"></script> 
      <script type="text/javascript" src="{{ asset('map/sectores.js') }}"></script>
      <script type="text/javascript" src="{{ asset('map/rios.js') }}"></script>
      <script type="text/javascript" src="{{ asset('map/quebradas.js') }}"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-minimap/3.6.1/Control.MiniMap.min.js"></script>
      <script>
    // Definimos la ruta base globalmente
    window.baseSectorUrl = "{{ url('/sector') }}"; 
</script>
      <script type="text/javascript" src="{{ asset('map/start.js') }}"></script>
      <script type="text/javascript" src="{{ asset('map/spin.min.js') }}"></script>
      <script type="text/javascript" src="{{ asset('map/leaflet.spin.min.js') }}"></script>
      </script>
   </body>
</html>