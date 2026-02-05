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
                  <i class="fas fa-map-marker-alt" style="color : {{ $ficha['color'] ?? '#1abc9c' }}"></i> &nbsp;
                  {{-- Accedemos a la clave 'nombre_estacion' del arreglo --}}
                  {{ $ficha['nombre_pdc'] ?? 'Nombre no definido' }}
                  </span>
                  <span id="subsistema-breadcrumb" style="color: #bdc3c7; font-weight: 400; font-size: 15px; text-transform: none !important;">
                  &nbsp; <i class="fas fa-chevron-right" style="font-size: 10px; opacity: 0.5;"></i> &nbsp; 
                  {{ $ficha['objetivo'] ?? 'Nombre no definido' }}
               </div>
               <hr>
               <div class="row g-4">
                  <div class="col-md-4">
                     <div class="card h-100 border-0 shadow-sm rounded-3">
                        <div class="card-header border-0 py-3 d-flex align-items-center text-dark bg-white" style="border-radius: 8px 8px 0 0; border-bottom: 1px solid #f0f0f0 !important;">
                           <i class="fas fa-file-invoice me-2 opacity-75" style="color:#117588 !important;"></i>
                           <h6 class="mb-0 fw-bold" style="letter-spacing: 0.5px; font-size: 12px; color: #2c3e50;">Ficha Técnica</h6>
                        </div>
                        <div class="card-body p-3">
                           <div class="table-responsive">
                              <table class="table table-borderless mb-0">
                                 <tbody class="technical-sheet">
                                    <tr>
                                       <td class="label-cell">
                                          Identificador
                                       </td>
                                       <td class="value-cell" style="color: {{ $colorSubActivo ?? '#2c3e50' }};">
                                          @if(isset($ficha['multinivel']) && $ficha['multinivel'] == 1 && isset($ficha['datosMultinivel']))
                                          {{ collect($ficha['datosMultinivel'])->pluck('nombre_estacion')->implode(' ; ') }}
                                          @else
                                          {{ $ficha['nombre_estacion_unificado'] ?? 'Nombre no definido' }}
                                          @endif
                                       </td>
                                    </tr>
                                    <tr class="bg-row">
                                       <td class="label-cell">
                                          Profundidad
                                       </td>
                                       <td class="value-cell">
                                          @if(isset($ficha['multinivel']) && $ficha['multinivel'] == 1 && isset($ficha['datosMultinivel']))
                                          {{ collect($ficha['datosMultinivel'])->pluck('profundidad_sma')->implode(' m; ') }} m
                                          @else
                                          {{ $ficha['profundidad_sma'] ?? 'No definida' }} {{ isset($ficha['profundidad_sma']) ? 'm' : '' }}
                                          @endif
                                       </td>
                                    </tr>
                                    <tr>
                                       <td class="label-cell">
                                          Tipo de Agua
                                       </td>
                                       <td class="value-cell text-uppercase">
                                          {{ (isset($ficha['profundidad_sma']) && is_numeric($ficha['profundidad_sma'])) ? 'Subterráneas' : 'Superficial' }}
                                       </td>
                                    </tr>
                                    <tr class="bg-row">
                                       <td class="label-cell">
                                          Monitoreo
                                       </td>
                                       <td class="value-cell ">60 min</td>
                                    </tr>
                                    <tr>
                                       <td class="label-cell">
                                          Inicio Mediciones
                                       </td>
                                       <td class="value-cell">30-12-2021</td>
                                    </tr>
                                 </tbody>
                              </table>
                           </div>
                           <div class="ficha-footer-glass mt-3">
                              <i class="fas fa-check-circle me-2"></i> Estación Operativa
                           </div>
                        </div>
                     </div>
                  </div>
                  <!--<div class="col-md-4">
                     <div class="card h-100 border-0 shadow-sm" style="border-radius: 8px;">
                        <div class="card-header border-0 py-3 d-flex align-items-center" style="background-color: #2c3e50; color: #ffffff; border-radius: 8px 8px 0 0;">
                           <i class="fas fa-file me-2 opacity-75"></i>
                           <h6 class="mb-0 fw-bold " style="letter-spacing: 1px; font-size: 12px;">Ficha Técnica</h6>
                        </div>
                        <div class="card-body p-0">
                           <table class="table mb-0">
                              <tbody style="font-size: 13px;">
                                 <tr>
                                    <td class="ps-4 py-3 text-muted border-bottom-0">Identificador:</td>
                                    <td class="pe-4 py-3 text-end fw-bold border-bottom-0">
                                       @if(isset($ficha['multinivel']) && $ficha['multinivel'] == 1 && isset($ficha['datosMultinivel']))
                                       {{-- Extraemos los nombres de todas las estaciones del grupo y los unimos --}}
                                       {{ collect($ficha['datosMultinivel'])->pluck('nombre_estacion')->implode(' ; ') }}
                                       @else
                                       {{-- Caso estándar o unificación por PDC --}}
                                       {{ $ficha['nombre_estacion_unificado'] ?? 'Nombre no definido' }}
                                       @endif
                                    </td>
                                 </tr>
                                 <tr class="bg-light">
                                    <td class="ps-4 py-3 text-muted border-bottom-0">Profundidad:</td>
                                    <td class="pe-4 py-3 text-end fw-bold border-bottom-0">
                                       @if(isset($ficha['multinivel']) && $ficha['multinivel'] == 1 && isset($ficha['datosMultinivel']))
                                       {{-- Extraemos las profundidades, las unimos con ';' y agregamos la unidad --}}
                                       {{ collect($ficha['datosMultinivel'])->pluck('profundidad_sma')->implode(' m; ') }} m
                                       @else
                                       {{-- Caso estándar o multinivel 0 --}}
                                       {{ $ficha['profundidad_sma'] ?? 'No definida' }} {{ isset($ficha['profundidad_sma']) ? 'm' : '' }}
                                       @endif
                                    </td>
                                 </tr>
                                 <tr>
                                    <td class="ps-4 py-3 text-muted border-bottom-0">Tipo de Agua:</td>
                                    <td class="pe-4 py-3 text-end fw-bold border-bottom-0">
                                       @if(isset($ficha['profundidad_sma']) && is_numeric($ficha['profundidad_sma']))
                                       SUBTERRÁNEAS
                                       @else
                                       SUPERFICIAL
                                       @endif
                                    </td>
                                 </tr>
                                 <tr>
                                    <td class="ps-4 py-3 text-muted border-bottom-0">Frecuencia/Monitoreo:</td>
                                    <td class="pe-4 py-3 text-end fw-bold border-bottom-0 text-uppercase">60 min</td>
                                 </tr>
                                 <tr>
                                    <td class="ps-4 py-3 text-muted border-bottom-0">Inicio Mediciones</td>
                                    <td class="pe-4 py-3 text-end fw-bold border-bottom-0 text-uppercase">30-12-2021</td>
                                 </tr>
                              </tbody>
                           </table>
                        </div>
                     </div>
                     </div>-->
                  <div class="col-md-4">
                     <div class="card h-100 border-0 shadow-sm rounded-3">
                        <div class="card-header border-0 py-3 d-flex align-items-center text-dark bg-white" style="border-radius: 8px 8px 0 0; border-bottom: 1px solid #f0f0f0 !important;">
                           <i class="fas fa-camera me-2 opacity-75" style="color:#117588 !important;"></i>
                           <h6 class="mb-0 fw-bold" style="letter-spacing: 0.5px; font-size: 12px; color: #2c3e50;">Registro Visual</h6>
                        </div>
                        <div class="card-body p-2">
                           <div class="rounded-2 overflow-hidden border bg-light d-flex align-items-center justify-content-center" style="height: 300px; position: relative; border-radius: 12px !important;">
                              @if( (isset($ficha['multinivel']) && $ficha['multinivel'] == 1 && isset($ficha['datosMultinivel']) && count($ficha['datosMultinivel']) > 0) || ($ficha['es_grupo'] && count($ficha['miembros_grupo']) > 1) )
                              @php
                              $itemsCarrusel = (isset($ficha['multinivel']) && $ficha['multinivel'] == 1) ? $ficha['datosMultinivel'] : $ficha['miembros_grupo'];
                              @endphp
                              <div id="carouselEstacion" class="carousel slide w-100 h-100" data-bs-ride="carousel">
                                 <div class="carousel-inner h-100">
                                    @foreach($itemsCarrusel as $index => $miembro)
                                    <div class="carousel-item h-100 {{ $index == 0 ? 'active' : '' }}">
                                       <img src="{{ asset('storage/img_estaciones/estaciones/' . $miembro->img . '.jpg') }}" 
                                          class="d-block w-100 h-100" 
                                          style="object-fit: cover;" 
                                          alt="{{ $miembro->nombre_estacion }}">
                                       <div class="img-cintillo-sharp-glass">
                                          <div class="img-item">
                                             <div class="img-data">
                                                <span class="img-label">ESTACIÓN</span>
                                                <span class="img-value">{{ $miembro->nombre_estacion }}</span>
                                             </div>
                                          </div>
                                          @if(isset($miembro->profundidad_sma))
                                          <div class="img-divider-glass"></div>
                                          <div class="img-item">
                                             <div class="img-data">
                                                <span class="img-label">PROFUNDIDAD</span>
                                                <span class="img-value">{{ $miembro->profundidad_sma }}<small>m</small></span>
                                             </div>
                                          </div>
                                          @endif
                                       </div>
                                    </div>
                                    @endforeach
                                 </div>
                                 <button class="carousel-control-prev" type="button" data-bs-target="#carouselEstacion" data-bs-slide="prev">
                                 <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                 </button>
                                 <button class="carousel-control-next" type="button" data-bs-target="#carouselEstacion" data-bs-slide="next">
                                 <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                 </button>
                              </div>
                              @else
                              <img src="{{ asset('storage/img_estaciones/estaciones/' . ($ficha['img'] ?? 'default') . '.jpg') }}" 
                                 class="w-100 h-100" 
                                 style="object-fit: cover;" 
                                 alt="{{ $ficha['nombre_estacion'] }}">
                              <div class="img-cintillo-sharp-glass">
                                 <div class="img-item">
                                    <div class="img-data">
                                       <span class="img-label">ESTACIÓN</span>
                                       <span class="img-value">{{ $ficha['nombre_estacion'] }}</span>
                                    </div>
                                 </div>
                                 @if(isset($ficha['profundidad_sma']))
                                 <div class="img-divider-glass"></div>
                                 <div class="img-item">
                                    <div class="img-data">
                                       <span class="img-label">PROFUNDIDAD</span>
                                       <span class="img-value">{{ $ficha['profundidad_sma'] }}<small>m</small></span>
                                    </div>
                                 </div>
                                 @endif
                              </div>
                              @endif
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="card h-100 border-0 shadow-sm rounded-3">
                        <div class="card-header border-0 py-3 d-flex align-items-center text-dark bg-white" style="border-radius: 8px 8px 0 0; border-bottom: 1px solid #f0f0f0 !important;">
                           <i class="fas fa-map-marked-alt me-2 text-primary opacity-75" style="color:#117588 !important;"></i>
                           <h6 class="mb-0 fw-bold" style="letter-spacing: 0.5px; font-size: 12px; color: #2c3e50;">Localización UTM</h6>
                        </div>
                        <div class="card-body p-2">
                           <div class="map-wrapper" style="position: relative; height: 300px; overflow: hidden; border-radius: 12px;">
                              <div class="utm-cintillo-sharp-glass">
                                 <div class="utm-item">
                                    <span class="indicator-n"></span>
                                    <div class="utm-data">
                                       <span class="label">NORTE</span>
                                       <span class="value">{{ number_format($ficha['utm_norte'], 0, ',', '.') }}<small>m</small></span>
                                    </div>
                                 </div>
                                 <div class="utm-divider-glass"></div>
                                 <div class="utm-item">
                                    <span class="indicator-e"></span>
                                    <div class="utm-data">
                                       <span class="label">ESTE</span>
                                       <span class="value">{{ number_format($ficha['utm_este'], 0, ',', '.') }}<small>m</small></span>
                                    </div>
                                 </div>
                              </div>
                              <div id="map-detail" class="w-100 h-100 border-0"></div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-12">
                     <div class="card h-100 border-0 shadow-sm rounded-3">
                        <div class="card-header border-0 py-3 d-flex align-items-center text-white" style="background-color: #2c3e50; border-radius: 8px 8px 0 0;">
                           <i class="fas fa-chart-line me-2 opacity-75"></i>
                           <h6 class="mb-0 fw-bold  small" style="letter-spacing: 1px;">Monitoreo en Línea</h6>
                        </div>
                        <div class="card-body p-2">
                           <div class="map-wrapper" style="position: relative; height: 300px; overflow: hidden; border-radius: 8px;">
                              <div id="map-detail" class="w-100 h-100 rounded-2 border"></div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!--<h6 class="fw-bold">Datos de la Ficha (Array):</h6>
                     {{-- Imprime solo el arreglo de la ficha --}}
                     @dump($ficha)-->
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
      </script>
   </body>
</html>