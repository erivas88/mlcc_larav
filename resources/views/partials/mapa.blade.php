
<div class="col-md-9">
   <div class="panel">
      <div class="tope"> 
         <span id="sistema"> 
         <i class="fas fa-wave-square" style="color: {{ $sistemaActivo->color_sistema ?? '#1abc9c' }};"></i> &nbsp;
         <span class="text-normal">
         Sistema de Mediciones en Línea
         </span>
         </span>
      </div>
      <hr>
      <div id="mapid" style="height: 550px; position: relative;" class="rounded shadow-sm border border-gray-200">
         <div class="layer-control-floating">
        <label class="layer-opt">
            <input type="radio" name="map-style" value="mapa">
            <span>MAPA</span>
        </label>
        <label class="layer-opt">
            <input type="radio" name="map-style" value="satelite" checked>
            <span>SATÉLITE</span>
        </label>
    </div>
      </div>
      <div class="contenedor-revista">
         <div class="separador-sutil"></div>
         <p class="texto-editorial">
            Como parte del <span class="destaque">Programa de Cumplimiento (PdC)</span> presentado por Caserones de Minera Lumina Copper Chile, que fue aprobado por la Superintendencia del Medioambiente (SMA), la Compañía asumió el compromiso de generar un sistema de medición en línea abierto a la comunidad, que contempla <span class="numero-enfasis">56 puntos de monitoreo</span> hidrogeológicos e hidrológicos, con el objetivo de tener un seguimiento de las variables ambientales relacionadas aguas abajo de la faena, para estudiar su comportamiento y evitar potenciales efectos de la operación o algunos fenómenos naturales como el cambio climático en el sector. 
         </p>
         <p class="texto-nota">
            Se presenta las mediciones a distancia efectuadas con sondas multiparamétricas instaladas en los puntos de medición; por tanto, se trata de datos crudos sin un proceso de revisión.
         </p>
      </div>
   </div>
</div>