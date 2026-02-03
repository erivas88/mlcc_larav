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
               <div class="col-md-3 pr-0">
                  <div class="accordion custom-sidebar" id="accordionExample" style="font-family: 'Poppins', sans-serif !important;">
                     @foreach($sistemas as $idSistema => $registrosSistema)
                     @php 
                     $primerRegistro = $registrosSistema->first();
                     // El sistema se abre si su ID coincide con el activo O si algún registro interno es 'open'
                     $sistemaOpen = ($idSistema == $idActivo || $registrosSistema->contains('estado_seleccion', 'open'));
                     @endphp
                     <div class="accordion-item border-0 mb-1">
                        <h2 class="accordion-header d-flex bg-white" style="border-left: 4px solid {{ $primerRegistro->color_sistema }};">
                           <a href="{{ url('/sector/' . $idSistema) }}" class="flex-grow-1 text-decoration-none">
                           <button class="accordion-button {{ $sistemaOpen ? '' : 'collapsed' }} py-2 px-3 bg-transparent shadow-none" 
                              type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $idSistema }}">
                           <i class="fas fa-layer-group me-2" style="color: {{ $primerRegistro->color_sistema }};"></i>
                           <span class="fw-bold" style="color: white; font-size: 13px;">{{ $primerRegistro->nombre_sistema }}</span>
                           </button>
                           </a>
                        </h2>
                        <div id="collapse{{ $idSistema }}" class="accordion-collapse collapse {{ $sistemaOpen ? 'show' : '' }}" data-bs-parent="#accordionExample">
                           <div class="accordion-body p-0">
                              <div class="list-group list-group-flush" id="subAccordion{{ $idSistema }}">
                                 @foreach($registrosSistema->groupBy('id_subsistema') as $idSub => $estaciones)
                                 @php 
                                 $primerSub = $estaciones->first();                                
                                 $subOpen = $estaciones->contains('estado_seleccion', 'open');
                                 @endphp
                                 <div class="accordion-item border-0 bg-transparent">
                                    <a style="text-decoration: none" href="{{ url('/sector/' . $idSistema . '/' . $idSub) }}"><button class="sub-btn border-0 d-flex align-items-center w-100 py-2 ps-4 bg-white {{ $subOpen ? '' : 'collapsed' }}" 
                                       type="button" data-bs-toggle="collapse" data-bs-target="#sub{{ $idSub }}">
                                    <i class="fas fa-caret-right me-2 icon-transition"></i>
                                    <i class="fas fa-map-marker-alt me-2" style="color: {{ $primerSub->color_subsistema }}; font-size: 12px;"></i>
                                    <span style="font-size: 12px; color: #555; font-weight: 500;">{{ $primerSub->nombre_subsistema }}</span>
                                    </button></a>
                                    <div id="sub{{ $idSub }}" class="collapse {{ $subOpen ? 'show' : '' }}" data-bs-parent="#subAccordion{{ $idSistema }}">
                                       <div class="list-group list-group-flush">
                                          @foreach($estaciones as $estacion)
                                          <a href="{{ url('/estacion/' . $estacion->id_estacion) }}" 
                                             class="estacion-link d-flex align-items-center text-decoration-none py-2 ps-5 position-relative {{ $estacion->estado_seleccion == 'open' ? 'active-estacion' : '' }}">
                                          <i class="fas fa-map-marker-alt me-3" 
                                             style="font-size: 11px; color: {{ $estacion->estado_seleccion == 'open' ? '#2ecc71' : $estacion->color_subsistema }};">
                                          </i>
                                          <span class="nombre-estacion" 
                                             style="font-weight: 500; font-size: 12px; color: {{ $estacion->estado_seleccion == 'open' ? '#2ecc71' : '#555' }};">
                                          {{ $estacion->nombre_estacion }}
                                          </span>
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
                     <div class="tope">
                       <span id="sistema">
    <i class="fas fa-map-marker-alt" style="color: #1abc9c;"></i> &nbsp;
    
    {{-- Accedemos a la clave 'nombre_estacion' del arreglo --}}
    {{ $ficha['nombre_pdc'] ?? 'Nombre no definido' }}
</span>
                        <span id="subsistema" style="color: #bdc3c7; font-weight: 400; font-size: 15px;"></span>
                     </div>

                     <hr>

                     <div class="row g-4">
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm" style="border-radius: 8px;">
            <div class="card-header border-0 py-3 d-flex align-items-center" style="background-color: #2c3e50; color: #ffffff; border-radius: 8px 8px 0 0;">
                <i class="fas fa-database me-2 opacity-75"></i>
                <h6 class="mb-0 fw-bold text-uppercase" style="letter-spacing: 1px; font-size: 12px;">Ficha Técnica de Estación</h6>
            </div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <tbody style="font-size: 13px;">
                        <tr>
                            <td class="ps-4 py-3 text-muted border-bottom-0">Identificador:</td>
                            <td class="pe-4 py-3 text-end fw-bold border-bottom-0">{{ $ficha['nombre_estacion_unificado'] ?? 'Nombre no definido' }}</td>
                        </tr>
                        <tr class="bg-light">
                            <td class="ps-4 py-3 text-muted border-bottom-0">Profundidad Operativa:</td>
                            <td class="pe-4 py-3 text-end fw-bold border-bottom-0">22 m ; 16 m ; 8 m</td>
                        </tr>
                        <tr>
                            <td class="ps-4 py-3 text-muted border-bottom-0">Clasificación hídrica:</td>
                            <td class="pe-4 py-3 text-end fw-bold border-bottom-0">AGUAS SUBTERRÁNEAS</td>
                        </tr>
                        <tr class="bg-light">
                            <td class="ps-4 py-3 text-muted border-bottom-0">Sector Geográfico:</td>
                            <td class="pe-4 py-3 text-end fw-bold border-bottom-0 text-uppercase">Depósito de Lastre</td>
                        </tr>
                        <tr>
                            <td class="ps-4 py-3 text-muted border-bottom-0">UTM Este:</td>
                            <td class="pe-4 py-3 text-end font-monospace border-bottom-0">440.482 m</td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
          
        </div>
    </div>

    <div class="col-md-4">
    <div class="card h-100 border-0 shadow-sm" style="border-radius: 8px;">
        <div class="card-header border-0 py-3 d-flex align-items-center" style="background-color: #2c3e50; color: #ffffff; border-radius: 8px 8px 0 0;">
            <i class="fas fa-camera me-2 opacity-75"></i>
            <h6 class="mb-0 fw-bold text-uppercase" style="letter-spacing: 1px; font-size: 12px;">
                Registro Visual {{ $ficha['nombre_pdc'] ?? $ficha['nombre_estacion'] }}
            </h6>
        </div>
        
        <div class="card-body d-flex flex-column p-3">kk
            <div class="rounded-2 overflow-hidden border mb-3">
                @if($ficha['es_grupo'] && count($ficha['miembros_grupo']) > 1)
                    <div id="carouselEstacion" class="carousel slide bg-dark" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach($ficha['miembros_grupo'] as $index => $miembro)
                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                    <img src="{{ asset('storage/img_estaciones/' . $miembro->img) }}" 
                                         class="d-block w-100 opacity-75" 
                                         style="height: 240px; object-fit: cover;" 
                                         alt="{{ $miembro->nombre_estacion }}">
                                    <div class="carousel-caption d-none d-md-block py-1 px-2 rounded" style="background: rgba(0,0,0,0.6); bottom: 10px; left: 10px; right: auto;">
                                        <p class="mb-0 small fw-bold">{{ $miembro->nombre_estacion }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselEstacion" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true" style="width: 20px;"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselEstacion" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true" style="width: 20px;"></span>
                        </button>
                    </div>
                @else
                  <div class="position-relative">
                     <img src="{{ asset('storage/img_estaciones/estaciones/' . ($ficha['img'] ?? 'default') . '.jpg') }}" 
                     class="w-100" 
                     style="height: 300px; object-fit: cover; display: block;" 
                     alt="{{ $ficha['nombre_estacion'] }}">                
                 </div>
                @endif
            </div>

           

            
        </div>
    </div>
</div>

    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm" style="border-radius: 8px;">
            <div class="card-header border-0 py-3 d-flex align-items-center" style="background-color: #2c3e50; color: #ffffff; border-radius: 8px 8px 0 0;">
                <i class="fas fa-map-marker-alt me-2 opacity-75"></i>
                <h6 class="mb-0 fw-bold text-uppercase" style="letter-spacing: 1px; font-size: 12px;">Geolocalización Referencial</h6>
            </div>
            <div class="card-body p-2">
                <div id="map-detail" class="w-100 border" style="height: 340px; background-color: #f0f2f5; border-radius: 4px;">
                    </div>
            </div>
          
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