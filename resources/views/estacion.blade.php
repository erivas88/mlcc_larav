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
      @include('partials.navbar')
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
                            @foreach($registrosSistema->groupBy('id_subsistema')->sortBy(fn($grupo) => $grupo->first()->order) as $idSub => $estaciones)
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
                                    {{-- Ordenamos la colección alfabéticamente por el campo nombre_estacion --}}
                                    @foreach($estaciones->sortBy('nombre_estacion') as $estacion)
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
                  @include('partials.info')
                  @include('partials.chart')
                  <!--<h6 class="fw-bold">Datos de la Ficha (Array):</h6>
                     {{-- Imprime solo el arreglo de la ficha --}}
                     @dump($ficha)-->
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