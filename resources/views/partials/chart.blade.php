<div class="col-md-12" style="background-color: white;">
   <div class="card h-100 border-0 shadow-sm rounded-3">
      <div class="card-header border-0 py-3 d-flex align-items-center text-white" style="background-color: #2c3e50; border-radius: 8px 8px 0 0;">
         <i class="fas fa-chart-area me-2 opacity-75"></i>
         <h6 class="mb-0 fw-bold small" style="letter-spacing: 1px;">Monitoreo en Línea</h6>
      </div>
      <div class="card-body p-2" style="background-color: white !important;">
         <div class="filter-glass-container">
            <div class="row g-2 w-100 m-0">
               <div class="col-6">
                  <div class="filter-item">
                     <label class="info-title">
                        <!-- -->
                        <span class="info-title" >Periodo</span>
                     </label>
                     <select id="sel-periodo" class="select2-pro" style="width: 100%;">
                        <option value="1">Últimas 24 Horas</option>
                        <option value="2">Últimos 7 Días</option>
                        <option value="3">Último Mes</option>
                        <option value="4">Últimos 3 Meses</option>
                        <option value="6">Ultimo Año</option>
                        <option value="5">Todo</option>
                     </select>
                  </div>
               </div>
               <div class="col-6">
                  <div class="filter-item">
                     <label class="info-title">
                        <!--<i class="fas fa-leaf" style="color:#117588 !important;" ></i> -->
                        <span>Parámetro</span>
                     </label>
                     <select id="sel-parametro" class="select2-pro" style="width: 100%;">
                        @foreach($ficha['parametros'] as $p)
                        <option value="{{ $p->id_parametro }}">
                           {{ $p->nombre_largo }}
                        </option>
                        @endforeach
                     </select>
                  </div>
               </div>
               <div class="col-lg-12" id="chart-container" style="height: 450px; position: relative;">
                  
                                     
                  </div>
               </div>
               <hr>
               @if(!empty($ficha['nota']))
               <div class="col-lg-12 mb-3">
                  <div class="info-box-premium nota-blue">
                     <div class="d-flex align-items-start">
                        <div class="info-icon">
                           <i class="fas fa-info-circle"></i>
                        </div>
                        <div class="info-body">
                           <h6>NOTA</h6>
                           <p>{{ $ficha['nota'] }}</p>
                        </div>
                     </div>
                  </div>
               </div>
               @endif
               <div class="col-lg-12">
                  <div class="info-box-premium warning-amber">
                     <div class="d-flex align-items-start">
                        <div class="info-icon">
                           <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="info-body">
                           <h6>DESCARGO DE RESPONSABILIDAD</h6>
                           <p>
                              La información presentada ha sido levantada por sondas multiparamétricas instaladas en los puntos de medición, se trata de <strong>datos crudos</strong> sin un proceso de revisión. Se hace presente que se mantiene una adecuada mantención de los equipos y control metrológico; sin embargo, están sujetos a problemas de transmisión a distancia. Las mediciones en línea son solo referenciales.
                           </p>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>