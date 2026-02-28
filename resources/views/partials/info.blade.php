<div class="col-md-4">
   <div class="card h-100 border-0 shadow-sm rounded-3">
      <div class="card-header border-0 py-3 d-flex align-items-center text-dark bg-white" style="border-radius: 8px 8px 0 0; border-bottom: 1px solid #f0f0f0 !important;">
         <i class="fas fa-file-invoice me-2 opacity-75" style="color:#117588 !important;"></i>
         <h6 class="mb-0 fw-bold" style="letter-spacing: 0.5px; font-size: 12px; color: #2c3e50;">Ficha Técnica</h6>
      </div>
      <div class="card-body p-0">
         <div class="technical-info-list">
            <div class="info-block px-4 py-3 border-bottom">
               <label class="info-title">Identificador</label>
               <div class="info-text " >
                  @if(isset($ficha['multinivel']) && $ficha['multinivel'] == 1 && isset($ficha['datosMultinivel']))
                  {{ collect($ficha['datosMultinivel'])->pluck('nombre_estacion')->implode(' ; ') }}
                  @else
                  {{ $ficha['nombre_estacion_unificado'] ?? 'Nombre no definido' }}
                  @endif
               </div>
            </div>
            <div class="info-block px-4 py-3 border-bottom bg-light-subtle">
               <label class="info-title">Profundidad</label>
               <div class="info-text">
                  @if(isset($ficha['multinivel']) && $ficha['multinivel'] == 1 && isset($ficha['datosMultinivel']))
                  {{
                  collect($ficha['datosMultinivel'])
                  ->pluck('profundidad_sma')
                  ->filter(fn($v) => is_numeric($v))
                  ->map(function($v) {
                  $v = (float) $v;
                  return $v == intval($v)
                  ? intval($v)
                  : rtrim(rtrim(number_format($v, 2, ',', ''), '0'), ',');
                  })
                  ->implode(' m; ')
                  }} m
                  @else
                  @if(isset($ficha['profundidad_sma']) && is_numeric($ficha['profundidad_sma']))
                  @php
                  $v = (float) $ficha['profundidad_sma'];
                  @endphp
                  {{ $v == intval($v)
                  ? intval($v)
                  : rtrim(rtrim(number_format($v, 2, ',', ''), '0'), ',')
                  }} m
                  @else
                  No Aplica
                  @endif
                  @endif
               </div>
            </div>
            <div class="info-block px-4 py-3 border-bottom">
               <label class="info-title">Tipo de Agua</label>
               <div class="info-text ">
                  {{ (isset($ficha['profundidad_sma']) && is_numeric($ficha['profundidad_sma'])) ? 'Aguas Subterráneas' : 'Aguas Superficiales' }}
               </div>
            </div>
            <div class="info-block px-4 py-3 border-bottom bg-light-subtle">
               <label class="info-title">Frecuencia de Monitoreo</label>
               <div class="info-text">60 min</div>
            </div>
            <div class="info-block px-4 py-3">
               <label class="info-title">Inicio Mediciones</label>
               <div class="info-text">{{ $ficha['fecha_mediciones'] }}</div>
            </div>
         </div>
      </div>
   </div>
</div>
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
                              <span class="img-value">
                              @if(is_numeric($miembro->profundidad_sma))
                              @php
                              $valor = (float) $miembro->profundidad_sma;
                              // Si es entero, no mostrar decimales
                              if (floor($valor) == $valor) {
                              $formateado = number_format($valor, 0, ',', '');
                              } else {
                              $formateado = rtrim(rtrim(number_format($valor, 2, ',', ''), '0'), ',');
                              }
                              @endphp
                              {{ $formateado }}<small>m</small>
                              @else
                              {{ $miembro->profundidad_sma }}
                              @endif
                              </span>
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
               @php
               $prof = $ficha['profundidad_sma'] ?? null;
               @endphp
               <div class="img-divider-glass"></div>
               <div class="img-item">
                  <div class="img-data">
                     <span class="img-label">PROFUNDIDAD</span>
                     <span class="img-value">
                     @if(is_numeric($prof))
                     {{ rtrim(rtrim(number_format($prof, 2, ',', ''), '0'), ',') }}
                     <small>m</small>
                     @else
                     —
                     @endif
                     </span>
                  </div>
               </div>
            </div>
            @endif
         </div>
      </div>
   </div>
</div>
@include('partials.mapa_estacion')
