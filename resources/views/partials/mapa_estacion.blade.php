@php
    $esMultinivel = isset($ficha['multinivel']) 
        && $ficha['multinivel'] == 1 
        && !empty($ficha['datosMultinivel']);
@endphp

<div class="col-md-4">
    <div class="card h-100 border-0 shadow-sm rounded-3">

        <div class="card-header border-0 py-3 d-flex align-items-center text-dark bg-white"
             style="border-radius: 8px 8px 0 0; border-bottom: 1px solid #f0f0f0 !important;">
            <i class="fas fa-map me-2 opacity-75" style="color:#117588 !important;"></i>
            <h6 class="mb-0 fw-bold" style="letter-spacing:0.5px;font-size:12px;color:#2c3e50;">
                {{ $esMultinivel ? 'Localización Multinivel' : 'Localización' }}
            </h6>
        </div>

        <div class="card-body p-2">
            <div class="rounded-2 overflow-hidden border bg-light"
                 style="height:300px;position:relative;border-radius:12px !important;">

                {{-- ===== MULTINIVEL ===== --}}
                @if($esMultinivel)

                    <div id="carouselMapas" class="carousel slide w-100 h-100" data-bs-ride="carousel">
                        <div class="carousel-inner h-100">

                            @foreach($ficha['datosMultinivel'] as $index => $miembro)
                                <div class="carousel-item h-100 {{ $index == 0 ? 'active' : '' }}">

                                    <div id="map-{{ $miembro->id_estacion }}" class="w-100 h-100"></div>

                                    <!-- Cintillo con las coordenadas UTM de cada estación -->
                                    <div class="utm-cintillo-sharp-glass">

                                        <div class="utm-item">
                                            <span class="indicator-n"></span>
                                            <div class="utm-data">
                                                <span class="label">NORTE</span>
                                                <span class="value">
                                                    {{ number_format($miembro->utm_norte ?? 0, 0, ',', '.') }}
                                                    <small>m</small>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="utm-divider-glass"></div>

                                        <div class="utm-item">
                                            <span class="indicator-e"></span>
                                            <div class="utm-data">
                                                <span class="label">ESTE</span>
                                                <span class="value">
                                                    {{ number_format($miembro->utm_este ?? 0, 0, ',', '.') }}
                                                    <small>m</small>
                                                </span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Controles del carrusel -->
                        <button class="carousel-control-prev" type="button"
                                data-bs-target="#carouselMapas" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>

                        <button class="carousel-control-next" type="button"
                                data-bs-target="#carouselMapas" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>

                {{-- ===== MAPA NORMAL ===== --}}
               {{-- ===== MAPA NORMAL ===== --}}
@else
    <div id="map-detail" class="w-100 h-100"></div>

    <!-- Cintillo UTM para mapa normal -->
    <div class="utm-cintillo-sharp-glass">

        <div class="utm-item">
            <span class="indicator-n"></span>
            <div class="utm-data">
                <span class="label">NORTE</span>
                <span class="value">
                    {{ number_format($ficha['utm_norte'] ?? 0, 0, ',', '.') }}
                    <small>m</small>
                </span>
            </div>
        </div>

        <div class="utm-divider-glass"></div>

        <div class="utm-item">
            <span class="indicator-e"></span>
            <div class="utm-data">
                <span class="label">ESTE</span>
                <span class="value">
                    {{ number_format($ficha['utm_este'] ?? 0, 0, ',', '.') }}
                    <small>m</small>
                </span>
            </div>
        </div>

    </div>
@endif

            </div>
        </div>
    </div>
</div>


<!--<div class="col-md-4">
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
</div>-->