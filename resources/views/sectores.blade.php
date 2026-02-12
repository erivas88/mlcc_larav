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
      <link rel="stylesheet" href="https://unpkg.com/leaflet-search@3.0.2/dist/leaflet-search.min.css" />
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
                     // Lógica de apertura dinámica para Sectores o Estaciones
                     $sistemaOpen = ($idSistema == $idActivo || $registrosSistema->contains('estado_seleccion', 'open'));
                     @endphp
                     <div class="accordion-item border-0 mb-1">
                       <!-- <h2 class="accordion-header d-flex bg-white" style="border-left: 4px solid {{ $primerRegistro->color_sistema }};">
                           <a href="{{ url('/sector/' . $idSistema) }}" class="flex-grow-1 text-decoration-none">
                           <button class="accordion-button {{ $sistemaOpen ? '' : 'collapsed' }} py-2 px-3 bg-transparent shadow-none" 
                              type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $idSistema }}">
                               <span class="icon-square" style="background: rgba(237, 142, 36, 0.1); border: 1px solid rgba(237, 142, 36, 0.2);">
                           <i class="fas fa-layer-group me-2" style="color: {{ $primerRegistro->color_sistema }};"></i></span>
                           <span class="fw-bold" style="color: white; font-size: 13px; font-weight: normal !important">{{ $primerRegistro->nombre_sistema }}</span>
                           </button>
                           </a>
                        </h2>-->

                        <h2 class="accordion-header d-flex bg-white" style="border-left: 4px solid {{ $primerRegistro->color_sistema }};">
    <a href="{{ url('/sector/' . $idSistema) }}" class="flex-grow-1 text-decoration-none">
        <button class="accordion-button {{ $sistemaOpen ? '' : 'collapsed' }} py-2 px-3 bg-transparent shadow-none" 
                type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $idSistema }}">
            
            <span class="icon-square" style="background-color: {{ $primerRegistro->color_sistema }}1A; border: 1px solid {{ $primerRegistro->color_sistema }}33;">
                <i class="fas fa-layer-group" style="color: {{ $primerRegistro->color_sistema }}; font-size: 16px;"></i>
            </span>

            <span class="fw-bold" style="color: white; font-size: 13px; font-weight: normal !important">
                {{ $primerRegistro->nombre_sistema }}
            </span>
            
        </button>
    </a>
</h2>

                        <div id="collapse{{ $idSistema }}" class="accordion-collapse collapse {{ $sistemaOpen ? 'show' : '' }}" data-bs-parent="#accordionExample">
                           <div class="accordion-body p-0">
                              <div class="list-group list-group-flush" id="subAccordion{{ $idSistema }}">
                                 {{-- 1. Agrupamos y luego ordenamos la colección por el campo 'order' del primer elemento de cada grupo --}}
                                 @foreach($registrosSistema->groupBy('id_subsistema')->sortBy(fn($grupo) => $grupo->first()->order) as $idSub => $estaciones)
                                 @php 
                                 $primerSub = $estaciones->first(); 
                                 $subOpen = ($idSub == $idSubActivo);
                                 @endphp
                                 <div class="accordion-item border-0 bg-transparent position-relative">
                                    <a href="{{ url('/sector/' . $idSistema . '/' . $idSub) }}" class="text-decoration-none">
                                       <button class="sub-btn border-0 d-flex align-items-center w-100 py-2 ps-4 bg-white {{ $subOpen ? '' : 'collapsed' }}" 
                                          type="button" 
                                          data-bs-toggle="collapse" 
                                          data-bs-target="#sub{{ $idSub }}">
                                          <i class="fas fa-caret-right me-2 icon-transition"></i>
                                          <i class="fas fa-map-marker-alt me-2" 
                                             style="color: {{ $primerSub->color_subsistema }}; font-size: 12px;"></i>
                                          <span style="font-size: 12px; color: #555; font-weight: 500;">
                                          {{-- Ahora el orden será consecutivo según tu base de datos --}}
                                          {{ $primerSub->nombre_subsistema }}
                                          </span>
                                          @if($subOpen)
                                          <div class="indicador-lateral"></div>
                                          @endif
                                       </button>
                                    </a>
                                    <div id="sub{{ $idSub }}" 
                                       class="accordion-collapse collapse {{ $subOpen ? 'show' : '' }}" 
                                       data-bs-parent="#subAccordion{{ $idSistema }}">
                                       <div class="accordion-body p-0">
                                          <div class="list-group list-group-flush">
                                             {{-- Opcional: También puedes ordenar las estaciones internamente si tienen un campo 'nombre' o 'orden_estacion' --}}
                                             @foreach($estaciones->sortBy('nombre_estacion') as $estacion)
                                             <a href="{{ url('/estacion/' . $estacion->id_estacion) }}" 
                                                class="estacion-link d-flex align-items-center text-decoration-none py-2 ps-5 {{ ($estacion->estado_seleccion ?? '') == 'open' ? 'active-estacion' : '' }}">
                                             <i class="fas fa-map-marker-alt me-3" 
                                                style="font-size: 11px; 
                                                color: {{ ($estacion->estado_seleccion ?? '') == 'open' ? '#2ecc71' : $estacion->color_subsistema }};">
                                             </i>
                                             <span class="nombre-estacion" 
                                                style="font-weight: 500; font-size: 12px; color: {{ ($estacion->estado_seleccion ?? '') == 'open' ? '#2ecc71' : '#666' }};">
                                             {{ $estacion->nombre_estacion }}
                                             </span>
                                             </a>
                                             @endforeach
                                          </div>
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
                     <!--<div class="tope"> 
                        <span id="sistema"> 
                        <i class="fas fa-layer-group" style="color: {{ $sistemaActivo->color_sistema ?? '#1abc9c' }};"></i> &nbsp;
                        <span class="text-normal">
                        {{ $sistemaActivo->nombre_sistema ?? 'Sistema...' }}
                        </span>
                        </span>
                        @if($nombreSubActivo)
                        <span id="subsistema-breadcrumb" style="color: #bdc3c7; font-weight: 400; font-size: 15px; text-transform: none !important;">
                        &nbsp; <i class="fas fa-chevron-right" style="font-size: 10px; opacity: 0.5;"></i> &nbsp; 
                        <span id="nombre-sub-sistema" style="color: {{ $colorSubActivo }}; font-weight: 600;">
                        {{ $nombreSubActivo }}
                        </span>
                        </span>
                        @endif
                     </div>-->

     <style>
    .tope-majestuoso {
        background-color: #34495e; /* Azul pizarra profundo constante */
        padding: 0 25px;           /* Padding lateral para aire visual */
        display: flex;
        align-items: center;       /* Centrado vertical perfecto */
        min-height: 55px;          /* Altura estandarizada */
        border-radius: 0 0 0 20px; /* Curva majestuosa inferior izquierda */
        margin-bottom: 20px;
        border: none;
        overflow: hidden;
    }

    #sistema-header {
        display: flex;
        align-items: center;       /* Asegura que todos los elementos hijos se alineen al centro */
        width: 100%;
        flex-wrap: nowrap; 
    }

    .sistema-main {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .sistema-icon {
        font-size: 18px;
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
    }

    /* Título: Delgado, blanco y centrado verticalmente */
    .sistema-title {
        font-family: 'Poppins', sans-serif;
        font-size: 17px;
        font-weight: 300;
        color: #FFFFFF;
        letter-spacing: 2px;
        margin: 0;
        text-transform: none;
        white-space: nowrap;
        line-height: 1;            /* Elimina espacios extra de línea para centrado puro */
    }

    /* Separador dorado artístico */
    .sistema-divider {
        color: #b08506;
        font-size: 22px;
        font-weight: 200;
        margin: 0 20px;
        opacity: 0.5;
        line-height: 1;
    }

    /* Bloque de Sub-sistema / Marca Corporativa */
    .sistema-brand {
        display: flex;
        flex-direction: column; 
        justify-content: center;   /* Centrado vertical del bloque de texto doble */
        line-height: 1.1;
    }

    .brand-name {
        font-size: 15px;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: none;
    }

    .brand-group {
        font-size: 10px;
        font-weight: 400;
        color: #95a5a6;
        letter-spacing: 3px;       /* Espaciado de lujo majestuoso */
        margin-top: 2px;
        text-transform: uppercase;
    }

    @media (max-width: 1200px) {
        .sistema-title { font-size: 15px; letter-spacing: 1px; }
        .sistema-divider { margin: 0 10px; }
        .brand-group { letter-spacing: 1.5px; }
    }
</style>

                     <div class="tope tope-majestuoso"> 
    <div id="sistema-header"> 
        <div class="sistema-main">
            <i class="fas fa-layer-group sistema-icon" style="color: {{ $sistemaActivo->color_sistema ?? '#1abc9c' }};"></i>
            <h1 class="sistema-title">
                {{ $sistemaActivo->nombre_sistema ?? 'Sistema...' }}
            </h1>
        </div>

        @if($nombreSubActivo)
        <span class="sistema-divider"><i class="fas fa-chevron-right "></i></span>
        
        <div class="sistema-brand">
            <span class="brand-name" style="color: {{ $colorSubActivo ?? '#0f7c91' }}; font-weight: normal">
                {{ $nombreSubActivo }}
            </span>
           
        </div>
        @endif
    </div>
</div>
                     <hr>
                     <style>
                        /* --- SELECTOR DE CAPAS PREMIUM --- */
                        .layer-control-floating {
                        position: absolute;
                        top: 20px;
                        right: 20px;
                        z-index: 1000;
                        display: flex;
                        gap: 2px;
                        /* Fondo translúcido tipo iOS */
                        background: rgba(15, 23, 42, 0.2); 
                        backdrop-filter: blur(10px) saturate(160%);
                        -webkit-backdrop-filter: blur(10px) saturate(160%);
                        padding: 4px;
                        border-radius: 8px; /* Bordes rectos elegantes */
                        border: 1px solid rgba(255, 255, 255, 0.2);
                        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
                        }
                        .layer-opt {
                        margin: 0;
                        cursor: pointer;
                        }
                        /* Ocultamos el radio button real */
                        .layer-opt input {
                        display: none;
                        }
                        /* Estilo del texto/botón */
                        .layer-opt span {
                        display: block;
                        padding: 6px 14px;
                        font-family: 'Poppins', sans-serif;
                        font-size: 10px;
                        font-weight: 700;
                        color: rgba(255, 255, 255, 0.9);
                        letter-spacing: 1px;
                        border-radius: 6px;
                        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                        }
                        /* ESTADO ACTIVO: El efecto de "botón seleccionado" */
                        .layer-opt input:checked + span {
                        background: #ffffff;
                        color: #1e293b;
                        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
                        transform: scale(1.02);
                        }
                        /* Efecto hover suave */
                        .layer-opt:hover span:not(input:checked + span) {
                        background: rgba(255, 255, 255, 0.1);
                        }
                     </style>
                     <div id="mapid" style="height: 600px; position: relative;" class="rounded shadow-sm border-0">
                        <div class="layer-control-floating">
                           <label class="layer-opt"><input type="radio" name="map-style" value="mapa"><span>MAPA</span></label>
                           <label class="layer-opt"><input type="radio" name="map-style" value="satelite" checked><span>SATÉLITE</span></label>
                        </div>
                        @if($nombreSubActivo)
                        <div class="glass-compact-box">
                           <div class="legend-indicator" style="background-color: {{ $colorSubActivo }};"></div>
                           <div class="legend-body-slim">
                              <i class="fas fa-map-marker-alt" style="color: {{ $colorSubActivo }}; font-size: 12px;"></i>
                              <span class="legend-text-slim">{{ $textoSubActivo ?? $nombreSubActivo }}</span>
                           </div>
                        </div>
                        @endif
                     </div>
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
      <link rel="stylesheet" href="{{ asset('map/leaflet.css') }}">
      <script type="text/javascript" src="{{ asset('map/leaflet.js') }}"></script>
      <script type="text/javascript" src="{{ asset('map/leaflet-label.js') }}"></script>
      <script type="text/javascript" src="{{ asset('map/leaflet-river.js') }}"></script>
      <script type="text/javascript" src="{{ asset('map/L.Control.ZoomBox.js') }}"></script> 
      <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-minimap/3.6.1/Control.MiniMap.min.js"></script>
      <script type="text/javascript" src="{{ asset('map/sectores.js') }}"></script>
      <script type="text/javascript" src="{{ asset('map/rios.js') }}"></script>
      <script type="text/javascript" src="{{ asset('map/quebradas.js') }}"></script>
      <script src="https://unpkg.com/leaflet-search@3.0.2/dist/leaflet-search.min.js"></script>
      <script type="text/javascript" src="{{ asset('map/coreleaflet_1.js') }}"></script>
      <script type="text/javascript" src="{{ asset('map/spin.min.js') }}"></script>
      <script type="text/javascript" src="{{ asset('map/leaflet.spin.min.js') }}"></script>
      </script>
   </body>
</html>