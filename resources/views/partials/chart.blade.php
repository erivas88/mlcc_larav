<div class="col-md-12" style="background-color: white;">
   <div class="card h-100 border-0 shadow-sm rounded-3">
      <div class="card-header border-0 py-3 d-flex align-items-center text-white" style="background-color: #2c3e50; border-radius: 8px 8px 0 0;">
         <i class="fas fa-chart-area me-2 opacity-75"></i>
         <h6 class="mb-0 fw-bold small" style="letter-spacing: 1px;">Monitoreo en Línea</h6>
      </div>
      <div class="card-body p-2" style="background-color: white !important;">
         <div class="filter-glass-container p-2">
            <div class="row g-2 w-100 m-0">
               <div class="col-6">
                  <div class="filter-item">
                     <label class="info-title">
                     <i class="fas fa-history" style="color:#117588 !important;"></i> 
                     <span>Periodo</span>
                     </label>
                     <select id="sel-periodo" class="select2-pro" style="width: 100%;">
                        <option value="1">Últimas 24 Horas</option>
                        <option value="2">Últimos 7 Días</option>
                        <option value="3">Último Mes</option>
                     </select>
                  </div>
               </div>
               <div class="col-6">
                  <div class="filter-item">
                     <label class="info-title">
                     <i class="fas fa-leaf" style="color:#117588 !important;" ></i> 
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
               <hr>
               <div class="col-lg-12">
                  <div id="chart-container" style="height: 450px; position: relative;">                      
                  </div>

               </div>
               <hr>
               <div class="col-lg-12">
    <div class="alert alert-warning border-warning shadow-sm" style="background-color: #fffdf0; border-radius: 8px; padding: 15px;">
        <div class="d-flex align-items-start">
            <div class="me-3">
                <i class="fas fa-exclamation-triangle" style="color: #0f7c91; font-size: 20px;"></i>
            </div>
            <div>
                <h6 class="alert-heading fw-bold mb-1" style="color: #0f7c91; font-size: 14px;">Descargo de Responsabilidad</h6>
                <p class="mb-0 text-muted" style="font-size: 11.5px; line-height: 1.5;">
                    La Información presentada ha sido levantada por sondas multiparamétricas instaladas en los puntos de medición, se trata de datos crudos sin un proceso de revisión. Se hace presente que se mantiene una adecuada mantención de los equipos y control metrológico; sin embargo, ellos están sujetos a problemas propios de transmisión a distancia. Las Mediciones en línea de estos parámetros son solo referenciales.
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