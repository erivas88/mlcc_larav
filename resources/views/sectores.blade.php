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
      <link rel="stylesheet" href="{{ asset('css/styles_sector.css') }}">     
   </head>
   <body>
      <div class="main-container">  
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
         <style>
           
         </style>
         <div class="container-fluid mt-4">
            <div class="row" >
               <div class="col-md-3">

<div class="accordion" id="accordionExample">
    @foreach($sistemas as $idSistema => $registrosSistema)
        @php 
            $primerRegistro = $registrosSistema->first();
            $isOpen = ($primerRegistro->estado === 'open');
        @endphp

        <div class="accordion-item border-0 bg-transparent mb-2 style='background-color: #865b74;'">
            <h2 class="accordion-header" id="heading{{ $idSistema }}">
                <a style="text-decoration: none;" href="{{ route('sector.ver', $idSistema) }}">
                  <button class="accordion-button {{ $isOpen ? '' : 'collapsed' }}" 
                        type="button" 
                        data-bs-toggle="collapse" 
                        data-bs-target="#collapse{{ $idSistema }}" 
                        aria-expanded="{{ $isOpen ? 'true' : 'false' }}">
                    <i class="fas fa-layer-group" style="color: {{ $primerRegistro->color_sistema }} !important;"></i> 
                    &nbsp;&nbsp; {{ $primerRegistro->nombre_sistema }}
                </button>
                </a>
            </h2>

            <div id="collapse{{ $idSistema }}" 
                 class="accordion-collapse collapse {{ $isOpen ? 'show' : '' }}" 
                 data-bs-parent="#accordionExample">
                
             <div class="accordion-body p-0">
    <div class="accordion accordion-flush" id="subAccordion{{ $idSistema }}">
        @foreach($registrosSistema->groupBy('id_subsistema') as $idSub => $estaciones)
            @php
                // Extraemos el primer registro para obtener los datos del subsistema
                $primerSub = $estaciones->first();
                $colorSub = $primerSub->color_subsistema ?? '#865b74'; // Color por defecto si es nulo
            @endphp
            
            <div class="accordion-item bg-transparent">
                <h2 class="accordion-header">
                    <button class="sub-btn collapsed" 
                            type="button" 
                            data-bs-toggle="collapse" 
                            data-bs-target="#sub{{ $idSub }}"
                            data-idsubsistema="{{ $idSub }}">
                        
                        <i class="fas fa-layer-group text-xs mr-2" style="color: {{ $colorSub }} !important;"></i>
                        &nbsp; 
                        {{ $primerSub->nombre_subsistema }}
                    </button>
                </h2>
                
                <div id="sub{{ $idSub }}" class="accordion-collapse collapse" data-bs-parent="#subAccordion{{ $idSistema }}">
                    <div class="list-group">
                        @foreach($estaciones as $estacion)
                            <a href="#" class="estacion-link"> 
                                <i class="fas fa-map-marker-alt text-xs mr-2" style="color: {{ $colorSub }};"></i>
                                &nbsp; {{ $estacion->nombre_estacion }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
            </div>
        </div>
    @endforeach
</div>
                
                 
                  
               </div>
               <div class="col-md-9">
                  <div class="panel">
                     <div id="mapid" style="height: 600px; position: relative;" class="rounded shadow-sm border border-gray-200">
                        <div class="layer-control" style="position: absolute; top: 10px; right: 10px; z-index: 1000; background: white; padding: 10px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
                           <label class="me-2"><input type="radio" name="map-style" value="mapa"> Mapa</label> 
                           <label><input type="radio" name="map-style" value="satelite" checked> Satélite</label>
                        </div>
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
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet-minimap/3.6.1/Control.MiniMap.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-minimap/3.6.1/Control.MiniMap.min.js"></script>
      <script type="text/javascript" src="{{ asset('map/sectores.js') }}"></script>
      <script type="text/javascript" src="{{ asset('map/rios.js') }}"></script>
      <script type="text/javascript" src="{{ asset('map/quebradas.js') }}"></script>
      <script type="text/javascript" src="{{ asset('map/mapa_sector_v1.js') }}"></script>
      <script type="text/javascript" src="{{ asset('map/spin.min.js') }}"></script>
      <script type="text/javascript" src="{{ asset('map/leaflet.spin.min.js') }}"></script>
      </script>
   </body>
</html>