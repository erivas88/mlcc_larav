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
      </style>
   </head>
   <body>
      <div class="main-container">
         <!-- Header -->
         <div class="header d-flex justify-content-between align-items-center px-3" style="background-color: white; padding: 10px 0;">
            <img src="{{ asset('images/logo.png') }}" 
               style="max-width: 150px; height: auto; float: left; margin-right: 15px; padding: 10px 0;" 
               alt="Logo Los Pelambres" class="logo">
            <nav class="d-flex">
               <a href="#" class="text-dark text-decoration-none mx-2">Inicio</a>                
               <a href="#" class="text-dark text-decoration-none mx-2">Glosario</a>
               <a href="#" class="text-dark text-decoration-none mx-2">Contáctenos</a>               
            </nav>
         </div>
         <nav class="d-flex align-items-center px-4 py-3" style="background: linear-gradient(to right, #02697e, #3e98a6);">
            <a href="#" class="text-white text-decoration-none mx-1 fw-bold">Sistema de Mediciones en Línea </a>
         </nav>
         <div class="container-fluid mt-4">
            <div class="row" >
               <div class="col-md-3">
                  <div class="accordion" id="accordionExample">
                     <div class="accordion-item">
                        <h2 class="accordion-header" id="heading1">
                           <a href="" 
                              class="accordion-button collapsed" 
                              style="text-decoration: none;">
                           <i class="fas fa-layer-group" style="color: #865b74 !important;"></i> 
                           &nbsp;&nbsp; Deposito de Lamas La Brea
                           </a>
                        </h2>
                     </div>
                     <div class="accordion-item">
                        <h2 class="accordion-header" id="heading1" id-sector="1">
                           <button class="accordion-button collapsed" 
                              type="button" 
                              id-sector="1" 
                              data-bs-toggle="collapse" 
                              data-bs-target="#collapse1" 
                              aria-expanded="false" 
                              aria-controls="collapse1">
                           <i class="fas fa-layer-group" style="color: #ed8e24!important;" ></i> 
                           &nbsp;&nbsp;Deposito de Arenas
                           </button>
                        </h2>
                     </div>
                     <div class="accordion-item">
                        <h2 class="accordion-header" id="heading1" id-sector="1">
                           <button class="accordion-button collapsed" 
                              type="button" 
                              id-sector="1" 
                              data-bs-toggle="collapse" 
                              data-bs-target="#collapse1" 
                              aria-expanded="false" 
                              aria-controls="collapse1">
                           <i class="fas fa-layer-group" style="color: #ffc107!important;" ></i> 
                           &nbsp;&nbsp;Deposito Lastre
                           </button>
                        </h2>
                     </div>
                     <div class="accordion-item">
                        <h2 class="accordion-header" id="heading1" id-sector="1">
                           <button class="accordion-button collapsed" 
                              type="button" 
                              id-sector="1" 
                              data-bs-toggle="collapse" 
                              data-bs-target="#collapse1" 
                              aria-expanded="false" 
                              aria-controls="collapse1">
                           <i class="fas fa-layer-group" style="color: #59d01b!important;" ></i> 
                           &nbsp;&nbsp;Sistema Río Ramadillas
                           </button>
                        </h2>
                     </div>
                  </div>
               </div>
               <div class="col-md-9">
                  <div class="panel">
                     <div id="mapid" style="height: 550px; position: relative;" class="rounded shadow-sm border border-gray-200">
                        <div class="layer-control" style="position: absolute; top: 10px; right: 10px; z-index: 1000; background: white; padding: 10px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
                           <label class="me-2"><input type="radio" name="map-style" value="mapa"> Mapa</label> 
                           <label><input type="radio" name="map-style" value="satelite" checked> Satélite</label>
                        </div>
                     </div>                                     
                     <div class="contenedor-revista">
                        <div class="separador-sutil"></div>
                        <p class="texto-editorial">
                           Como parte del <span class="destaque">Programa de Cumplimiento (PdC)</span> presentado por Caserones de Minera Lumina Copper Chile, que fue aprobado por la Superintendencia del Medioambiente (SMA), la Compañía asumió el compromiso de generar un sistema de medición en línea abierto a la comunidad, que contempla <span class="numero-enfasis">56 puntos de monitoreo</span> hidrogeológicos e hidrológicos, con el objetivo de tener un seguimiento de las variables ambientales relacionadas aguas abajo de la faena, para estudiar su comportamiento y evitar potenciales efectos de la operación o algunos fenómenos naturales como el cambio climático en el sector. 
                        </p>
                        <p class="texto-nota">
                           Se presenta las mediciones a distancia efectuadas con sondas multiparamétricas instaladas en los puntos de medición; por tanto, se trata de datos crudos sin un proceso de revisión.
                        </p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- Footer -->
         <div class="footer text-center mt-4 color_mlp">
            <div class="row align-items-center pdd">
               <div class="col-lg-3 d-flex justify-content-center">
                  <img src="{{ asset('images/antofagasta-mineralsWT.png') }}" style="max-width: 70%; height: auto; padding-top: 10px;" alt="Logo Los Pelambres" class="logo">
               </div>
               <div class="col-lg-3 d-flex flex-column align-items-start">
                  <span class="text-line txt small-text pdd">
                  <span style="font-weight: bold; "><i class="fas fa-mobile-alt"></i> &nbsp; Teléfono:</span> +56 2 3456 7890
                  </span>
                  <span class="text-line txt small-text pdd">
                  <span style="font-weight: bold;"><i class="fas fa-envelope"></i>&nbsp; Email:</span> comunicacionesexternas@pelambres.cl
                  </span>
                  <span class="text-line txt small-text pdd">
                  <span style="font-weight: bold;"><i class="fas fa-globe"></i>&nbsp; Web:</span> www.aminerals.com
                  </span>
               </div>
               <div class="col-lg-3">
                  <div class="section">
                     <p class="small-text jjtxt">Este desarrollo ha sido implementado por <span style="font-weight: bold">GP Consultores</span>, a través de su equipo especializado en soluciones de monitoreo web.
                        gp@gpconsultores.cl
                     <p>
                  </div>
               </div>
               <div class="col-lg-3">
                  <img src="{{ asset('images/gp-blanco.png') }}" style="max-width: 65%; height: auto; padding-top: 10px;" alt="Logo Los Pelambres" class="logo">
               </div>
            </div>
         </div>
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
      <script type="text/javascript" src="{{ asset('map/core_map_index.js') }}"></script>
      <script type="text/javascript" src="{{ asset('map/spin.min.js') }}"></script>
      <script type="text/javascript" src="{{ asset('map/leaflet.spin.min.js') }}"></script>
      </script>
   </body>
</html>