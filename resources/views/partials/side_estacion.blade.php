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
                     <i class="fas fa-layer-group me-2 fw-bold" style="color: {{ $primerRegistro->color_sistema }};"></i>
                     <span class="fw-bold" style="color: white; font-size: 13px; font-weight: normal !important">{{ $primerRegistro->nombre_sistema }}</span>
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