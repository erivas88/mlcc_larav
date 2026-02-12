
<style>
    .badge-caserones-floating {
        position: absolute;
        top: 15px;
        right: 15px; /* Lado opuesto a los controles de Leaflet si los tienes a la izquierda */
        z-index: 1000;
        background: transparent;
        backdrop-filter: blur(4px); /* Efecto de transparencia moderno */
        padding: 6px 14px;
        border-radius: 30px;
        border: 1px solid #0f7c91;
        display: flex;
        align-items: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        pointer-events: none; /* Evita interferir con los clics en el mapa */
    }

    .badge-caserones-floating i {
        color: #0f7c91;
        font-size: 14px;
        margin-right: 8px;
    }

    .badge-caserones-floating span {
        font-size: 11px;
        font-weight: 700;
        color: #2c3e50;
        letter-spacing: 0.6px;
        text-transform: uppercase;
        font-family: 'Poppins', sans-serif;
    }
</style>


<style>
    .contenedor-revista-premium {
        padding: 45px 60px;
        background-color: #ffffff;
        text-align: center;
        max-width: 900px;
        margin: 0 auto;
    }

    /* Título Objetivo: Estilo minimalista de alta gama */
    .header-objetivo {
        margin-bottom: 35px;
    }

    .titulo-elegante {
        font-family: 'Poppins', sans-serif;
        font-weight: 300;
        text-transform: uppercase;
        letter-spacing: 6px; /* Espaciado premium */
        color: #0f7c91;
        font-size: 16px;
        margin-bottom: 12px;
    }

    .divisor-dorado {
        height: 2px;
        width: 40px;
        background-color: #b08506; /* Dorado ocre sutil */
        margin: 0 auto;
        border-radius: 2px;
    }

    /* Texto Principal: Legibilidad majestuosa */
    .texto-editorial-principal {
        font-size: 15px;
        line-height: 1.9;
        color: #444;
        font-weight: 300;
        text-align: justify;
        margin-bottom: 30px;
        letter-spacing: 0.2px;
    }

    .badge-accent {
        color: #0f7c91;
        font-weight: 600;
        border-bottom: 1px solid rgba(15, 124, 145, 0.2);
    }

    .numero-destacado {
        font-weight: 700;
        color: #2c3e50;
        font-size: 1.05em;
    }

    /* Separador decorativo */
    .separador-sutil-icon {
        color: #eee;
        font-size: 10px;
        margin-bottom: 25px;
    }

    /* Nota al Pie: Discreta y técnica */
    .texto-nota-elegante {
        font-size: 11.5px;
        color: #888;
        line-height: 1.6;
        font-style: italic;
        border-top: 1px solid #f5f5f5;
        padding-top: 20px;
        max-width: 80%;
        margin: 0 auto;
    }
</style>


<style>
    /* Eliminamos restricciones de ancho para que use el 100% del col-md-9 */
    .seccion-objetivo-full {
        padding: 40px 0; /* 0 a los lados para usar el ancho total */
        width: 100%;
        text-align: center;
    }

    /* Título Objetivo centrado y majestuoso */
    .objetivo-header-minimal {
        margin-bottom: 30px;
    }

    .objetivo-titulo {
        font-family: 'Poppins', sans-serif;
        font-weight: 300;
        text-transform: uppercase;
        letter-spacing: 12px; /* Espaciado ultra-elegante */
        color: #0f7c91;
        font-size: 18px;
        margin-bottom: 15px;
    }

    .objetivo-line {
        height: 2px;
        width: 50px;
        background: #b08506; /* Dorado ocre sutil */
        margin: 0 auto;
    }

    /* Texto principal: 100% de ancho con interlineado majestuoso */
    .objetivo-texto {
        font-size: 16px;
        line-height: 2; /* Aire editorial */
        color: #333;
        font-weight: 300;
        text-align: justify; /* Centrado para look de la imagen a7aa9e.png */
        margin-bottom: 30px;
        width: 100%;
    }

    .destaque-sublime {
        color: #0f7c91;
        font-weight: 600;
        border-bottom: 1px solid rgba(15, 124, 145, 0.2);
    }

    .enfasis-majestuoso {
        font-weight: 700;
        color: #2c3e50;
    }

    /* Nota al pie técnica */
    .objetivo-nota {
        font-size: 11.5px;
        color: #999;
        font-style: italic;
        border-top: 1px solid #f0f0f0;
        padding-top: 20px;
        max-width: 80%; /* La nota sí se encajona un poco para elegancia */
        margin: 0 auto;
    }
</style>


<style>
    .tope {
        padding: 15px 0;
        border-bottom: 1px solid #eee; /* Mantiene la limpieza visual */
        margin-bottom: 20px;
    }

    #sistema {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
    }

    /* Estilo para "Sistema de Mediciones en Línea" */
    .main-concept {
        font-family: 'Poppins', sans-serif;
        font-weight: 300; /* Extra fino para elegancia */
        font-size: 19px;
        letter-spacing: 2px; /* Aire entre letras majestuoso */
        color: #2c3e50;
        text-transform: none; /* Mantenemos el casing original */
    }

    /* Separador Artístico */
    .brand-separator {
        margin: 0 15px;
        color: #b08506; /* Color ocre que conversa con tu 'Objetivo' */
        font-weight: 200;
        font-size: 24px;
        opacity: 0.5;
    }

    /* Estilo para "Caserones" */
    .brand-primary {
        font-family: 'Poppins', sans-serif;
        font-weight: 800; /* Peso máximo para autoridad de marca */
        font-size: 18px;
        color: #0f7c91; /* Tu azul institucional */
        letter-spacing: -0.5px; /* Un poco más apretado para look de logo */
    }

    /* Estilo para "Lundin Mining" */
    .brand-secondary {
        font-family: 'Poppins', sans-serif;
        font-weight: 400;
        font-size: 13px;
        color: #7f8c8d;
        text-transform: uppercase;
        letter-spacing: 3px; /* Look de marca de lujo */
        margin-left: 8px;
    }
</style>



<style>
    .tope-majestuoso-inicio {
        background-color: #34495e; /* Azul pizarra profundo de tus capturas */
        padding: 12px 25px;
        /* LA CURVA: 20px en la esquina inferior izquierda para look de sectores */
        border-radius: 0 0 0 20px; 
        display: flex;
        align-items: center;
        min-height: 55px;
        margin-bottom: 20px;
        border: none;
    }

    #sistema-header {
        display: flex;
        align-items: center;
        width: 100%;
        gap: 0; /* Controlamos el espacio con el divisor */
    }

    .sistema-main {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .sistema-icon {
        color: #1abc9c; /* Color turquesa original */
        font-size: 16px;
    }

    .sistema-title {
        font-family: 'Poppins', sans-serif;
        font-size: 17px;
        font-weight: 300;
        color: rgba(255, 255, 255, 0.9);
        letter-spacing: 1.5px;
        margin: 0;
        white-space: nowrap;
    }

    .sistema-divider {
        color: #b08506; /* El toque dorado de la imagen */
        font-size: 20px;
        font-weight: 200;
        margin: 0 25px;
        opacity: 0.6;
    }

    /* Estilo Corporativo Majestuoso */
    .sistema-brand-corporate {
        display: flex;
        align-items: baseline;
        gap: 10px;
    }

    .brand-primary {
        color: #0f7c91; /* El azul brillante de Caserones */
        font-weight: 800;
        font-size: 18px;
        letter-spacing: -0.5px;
    }

    .brand-secondary {
        color: rgba(255, 255, 255, 0.4);
        font-weight: 400;
        font-size: 11px;
        letter-spacing: 4px; /* Espaciado ultra-ancho para look Majestic */
        text-transform: uppercase;
    }


.map-legend-floating {
    position: absolute;
    bottom: 30px;
    left: 30px;
    z-index: 1000;
    /* Fondo de cristal ultra-transparente */
    background: rgba(255, 255, 255, 0.02); 
    backdrop-filter: blur(20px) saturate(180%);
    -webkit-backdrop-filter: blur(20px) saturate(180%);
    padding: 15px 22px;
    border-radius: 0; 
    
    /* El borde azulito solo a la izquierda */
    border-left: 2px solid #00d4ff; 
    /* Resplandor sutil para el borde azul */
    box-shadow: -5px 0 15px rgba(0, 212, 255, 0.2);
    
    font-family: 'Poppins', sans-serif;
}

.legend-item {
    display: flex;
    align-items: center;
    margin-bottom: 12px;
    cursor: pointer;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.legend-item:last-child {
    margin-bottom: 0;
}

/* Indicador FontAwesome con relleno tenue */
.indicator {
    font-size: 9px; /* Tamaño minimalista */
    margin-right: 15px;
    filter: drop-shadow(0 0 2px rgba(0,0,0,0.3));
}

.purple { 
    color: rgba(191, 90, 242, 0.2); 
    -webkit-text-stroke: 1.2px #bf5af2; 
}
.orange { 
    color: rgba(255, 159, 10, 0.2); 
    -webkit-text-stroke: 1.2px #ff9f0a; 
}
.yellow { 
    color: rgba(255, 214, 10, 0.2); 
    -webkit-text-stroke: 1.2px #ffd60a; 
}
.green { 
    color: rgba(50, 215, 75, 0.2); 
    -webkit-text-stroke: 1.2px #32d74b; 
}

.label {
    font-size: 0.55rem; /* Letra bien pequeña y elegante */
    color: rgba(255, 255, 255, 0.75);
    font-weight: 300;
    letter-spacing: 1.5px;
    text-transform: uppercase; /* Se ve mejor en tamaños pequeños */
}

/* Interacción: el borde azul brilla más al pasar el mouse por la caja */
.map-legend-floating:hover {
    border-left: 2px solid #55eaff;
    box-shadow: -5px 0 20px rgba(85, 234, 255, 0.4);
    transition: 0.5s;
}




</style>








<div class="col-md-9">
   <div class="panel">
      <div class="tope-majestuoso-inicio">
         <div id="sistema-header">
            <div class="sistema-main">
               <i class="fas fa-map-marked-alt sistema-icon"></i>
               <h1 class="sistema-title">Sistema de Mediciones en Línea</h1>
            </div>
            <span class="sistema-divider"></span>
            <div class="sistema-brand-corporate">
               <span class="brand-secondary"></span>
            </div>
         </div>
      </div>
      <hr>
     

      <div id="mapid" style="height: 600px; position: relative; overflow: hidden;" class="rounded shadow-sm border border-gray-200">
    
    <div class="badge-caserones-floating" style="position: absolute; top: 20px; right: 20px; z-index: 1000;">
        <i class="fas fa-map-marker-alt"></i>
        <span> MLCC</span>
    </div>

    

    <div class="map-legend-floating">
    <div class="legend-item">
        <i class="fas fa-circle indicator purple"></i>
        <span class="label">Depósito  de Lamas La Brea</span>
    </div>
    
    <div class="legend-item">
        <i class="fas fa-circle indicator orange"></i>
        <span class="label">Depósito de Arenas Caserones</span>
    </div>
    
    <div class="legend-item">
        <i class="fas fa-circle indicator yellow"></i>
        <span class="label">Depósito de Lastre</span>
    </div>
    
    <div class="legend-item">
        <i class="fas fa-circle indicator green"></i>
        <span class="label">Sector Río Ramadillas</span>
    </div>
</div>
</div>

      <p class="objetivo-nota">
         Se presenta las mediciones a distancia efectuadas con sondas multiparamétricas instaladas en los puntos de medición; por tanto, se trata de datos crudos sin un proceso de revisión.
      </p>
      <div class="seccion-objetivo-full" style="display: none">
         <div class="objetivo-header-minimal">
            <h2 class="objetivo-titulo">Objetivo</h2>
            <div class="objetivo-line"></div>
         </div>
         <p class="objetivo-texto">
            Como parte del <span class="destaque-sublime">Programa de Cumplimiento (PdC)</span> presentado por Caserones de Minera Lumina Copper Chile, que fue aprobado por la Superintendencia del Medioambiente (SMA), la Compañía asumió el compromiso de generar un sistema de medición en línea abierto a la comunidad, que contempla <span class="enfasis-majestuoso">56 puntos de monitoreo</span> hidrogeológicos e hidrológicos, con el objetivo de tener un seguimiento de las variables ambientales relacionadas aguas abajo de la faena, para estudiar su comportamiento y evitar potenciales efectos de la operación o algunos fenómenos naturales como el cambio climático en el sector. 
         </p>
         <p class="objetivo-nota">
            Se presenta las mediciones a distancia efectuadas con sondas multiparamétricas instaladas en los puntos de medición; por tanto, se trata de datos crudos sin un proceso de revisión.
         </p>
      </div>
      <!--@include('partials.carrusel')-->
   </div>
</div>
<div class="col-md-12">
   @include('partials.carrusel')
</div>