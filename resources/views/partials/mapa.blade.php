
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
</style>



<style>
    /* Estilo del Título Principal con Michroma */
   
    .objetivo-line {
        width: 50px;
        height: 3px;
        background-color: #b08506; /* Dorado majestuoso */
        margin-bottom: 30px;
    }

    /* Carrusel Track */
    .carrusel-objetivos {
        overflow-x: auto;
        padding: 20px 0;
        scrollbar-width: none; /* Oculta scroll en Firefox */
    }

    .carrusel-track {
        display: flex;
        gap: 20px;
        padding-left: 5px;
    }

    /* Estilo de las Cards */
    .objetivo-card {
        min-width: 280px;
        background: #ffffff;
        padding: 25px;
        border-radius: 0 0 0 20px; /* Curva característica */
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        border-top: 2px solid #0f7c91;
        transition: transform 0.3s ease;
    }

    .objetivo-card:hover {
        transform: translateY(-10px);
    }

    .card-icon {
        font-size: 24px;
        color: #b08506;
        margin-bottom: 15px;
    }

    .card-title {
        font-family: 'Michroma', sans-serif; /* Consistencia con el logo */
        font-size: 14px;
        font-weight: 400;
        color: #2c3e50;
        margin-bottom: 12px;
        text-transform: uppercase;
    }

    .card-text {
        font-family: 'Poppins', sans-serif;
        font-size: 13px;
        color: #576574;
        line-height: 1.6;
        font-weight: 300;
    }

    .card-footer-line {
        width: 30px;
        height: 2px;
        background: #eee;
        margin-top: 15px;
    }
</style>



<style>
    .carrusel-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .carrusel-track {
        display: flex;
        gap: 25px;
        overflow-x: auto;
        scroll-behavior: smooth;
        padding: 20px 5px;
        scrollbar-width: none; /* Oculta scrollbar */
    }

    .carrusel-track::-webkit-scrollbar { display: none; }

    /* Botones de Navegación Maestuosos */
    .nav-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 45px;
        height: 45px;
        background: #0f7c91;
        color: white;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        z-index: 10;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.3s;
    }

    .nav-btn:hover { background: #b08506; }
    .prev { left: -20px; }
    .next { right: -20px; }

    /* Estilo de la Card */
    .objetivo-card {
        min-width: 300px;
        background: #ffffff;
        padding: 30px;
        border-radius: 0 0 0 20px; /* Curva característica */
        box-shadow: 0 8px 25px rgba(0,0,0,0.06);
        border-top: 3px solid #0f7c91;
        flex-shrink: 0;
    }

    .card-title {
        font-family: 'Michroma', sans-serif; /* Fuente del logo */
        font-size: 13px;
        color: #2c3e50;
        margin: 15px 0;
        text-transform: uppercase;
    }

    .card-text {
        font-size: 13px;
        color: #576574;
        font-weight: 300;
        line-height: 1.6;
    }
</style>


<style>
    .carrusel-wrapper {
        position: relative;
        padding: 0 40px; /* Espacio para que los botones no tapen las cards */
    }

    .carrusel-track {
        display: flex;
        gap: 20px;
        overflow-x: hidden; /* Ocultamos el scroll manual para usar los botones */
        scroll-behavior: smooth;
        padding: 20px 0;
    }

    /* Ajuste para ver 3 cards exactamente */
    .objetivo-card {
        flex: 0 0 calc((100% / 3) - (40px / 3)); /* (100% / 3) menos el proporcional del gap */
        min-width: calc((100% / 3) - (40px / 3));
        background: #ffffff;
        padding: 25px;
        border-radius: 0 0 0 20px; /* Curva majestuosa */
        box-shadow: 0 8px 25px rgba(0,0,0,0.06);
        border-top: 3px solid #0f7c91; /* Azul Caserones */
        display: flex;
        flex-direction: column;
    }

    .card-title {
        font-family: 'Michroma', sans-serif; /* Identidad de marca */
        font-size: 11px;
        color: #2c3e50;
        margin: 15px 0;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* Botones de Navegación */
    .nav-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 40px;
        height: 40px;
        background: #0f7c91;
        color: white;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        z-index: 10;
        transition: all 0.3s;
    }

    .nav-btn:hover { background: #b08506; scale: 1.1; }
    .prev { left: -5px; }
    .next { right: -5px; }
</style>


<style>
    .carrusel-wrapper { position: relative; padding: 0 40px; margin-top: 20px; }
    
    .carrusel-track {
        display: flex;
        gap: 20px;
        overflow-x: hidden;
        scroll-behavior: smooth;
        padding: 15px 0;
    }

    .objetivo-card {
        flex: 0 0 calc((100% / 3) - (40px / 3)); /* Visualización de 3 cards */
        background: #ffffff;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        border-bottom: 3px solid transparent;
        transition: all 0.3s ease;
    }

    .objetivo-card:hover {
        transform: translateY(-8px);
        border-bottom: 3px solid #b08506; /* Detalle dorado al pasar mouse */
    }

    .card-img-container { width: 100%; height: 160px; overflow: hidden; }
    .card-img-container img { width: 100%; height: 100%; object-fit: cover; }

    .card-body-content { padding: 25px 20px; text-align: center; }

    .card-title-institucional {
        font-family: 'Michroma', sans-serif; /* Identidad Caserones */
        font-size: 14px;
        color: #0f7c91;
        margin-bottom: 15px;
        text-transform: uppercase;
    }

    .card-text-narrative {
        font-family: 'Poppins', sans-serif;
        font-size: 13px;
        color: #576574;
        line-height: 1.7; /* Interlineado elegante */
        font-weight: 300;
        margin: 0;
    }

    .nav-btn {
        position: absolute; top: 50%; transform: translateY(-50%);
        width: 38px; height: 38px; background: #0f7c91; color: white;
        border: none; border-radius: 50%; cursor: pointer; z-index: 10;
        box-shadow: 0 3px 8px rgba(0,0,0,0.2);
    }
    .prev { left: -10px; } .next { right: -10px; }
</style>


<style>
    /* Ajuste específico para que la imagen se vea más ancha */
    .card-img-container {
        width: 100%;
        height: 160px; /* Reducimos la altura para enfatizar el ancho */
        margin: 0;
        padding: 0;
        overflow: hidden;
        border-radius: 8px 8px 0 0; /* Solo curvas arriba para no chocar con el texto */
    }

    .card-img-container img {
        width: 100%;
        height: 100%;
        object-fit: cover; /* Esto estira la imagen a todo el ancho sin deformar */
        display: block;
    }

    /* Para que el cuerpo no se vea apretado tras ensanchar la imagen visualmente */
    .card-body-content {
        padding: 20px 15px;
        text-align: center;
    }
</style>


<style>
    .objetivo-card {
        flex: 0 0 calc((100% / 3) - (40px / 3));
        background: #ffffff;
        border-radius: 12px; /* Aumentamos un poco el radio para el efecto marco */
        box-shadow: 0 8px 20px rgba(0,0,0,0.06);
        display: flex;
        flex-direction: column;
        overflow: hidden;
        /* El secreto: un padding mínimo arriba y a los lados */
        padding: 8px; 
        transition: all 0.3s ease;
    }

    .card-img-container {
        width: 100%;
        height: 150px; /* Altura reducida para que se vea más ancha */
        overflow: hidden;
        border-radius: 8px; /* Redondeado interno para la imagen */
    }

    .card-img-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.25, 1, 0.5, 1);
    }

    .objetivo-card:hover .card-img-container img {
        transform: scale(1.08); /* Zoom sutil al pasar el mouse */
    }

    .card-body-content {
        padding: 15px 10px 10px 10px; /* Padding interno para el texto */
        text-align: center;
    }

    .card-title-institucional {
        font-family: 'Poppins', sans-serif; /* Fuente Caserones */
        font-size: 13px;
        color: #0f7c91;
        margin-bottom: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .card-text-narrative {
        font-family: 'Poppins', sans-serif;
        font-size: 12.5px;
        color: #576574;
        line-height: 1.6;
        font-weight: 300;
        text-align: justify;
    }

    /* Estilo del Botón "Ver Más" */
    .btn-ver-mas {
        font-family: 'Poppins', sans-serif;
        font-size: 12px;
        font-weight: 600;
        color: #0f7c91; /* Azul institucional */
        text-decoration: none;
        text-transform: uppercase;
        letter-spacing: 1px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        padding: 5px 0;
        border-bottom: 2px solid transparent;
    }

    .btn-ver-mas i {
        font-size: 10px;
        transition: transform 0.3s ease;
    }

    /* Efecto Hover Artístico */
    .btn-ver-mas:hover {
        color: #b08506; /* Cambia al dorado majestuoso */
        border-bottom: 2px solid #b08506;
    }

    .btn-ver-mas:hover i {
        transform: translateX(5px); /* La flecha se mueve sutilmente hacia la derecha */
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
      <div id="mapid" style="height: 600px; position: relative;" class="rounded shadow-sm border border-gray-200">
         <div class="badge-caserones-floating">
            <i class="fas fa-map-marker-alt"></i>
            <span> MLCC</span>
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
      <div class="seccion-objetivo-full">
         <div class="objetivo-header-minimal">
            <h2 class="objetivo-titulo">CASERONES</h2>
            <div class="objetivo-line"></div>
         </div>
         <div class="carrusel-wrapper">
            <button class="nav-btn prev" onclick="scrollCarrusel(-1)"><i class="fas fa-chevron-left"></i></button>
            <button class="nav-btn next" onclick="scrollCarrusel(1)"><i class="fas fa-chevron-right"></i></button>
            <div class="carrusel-track" id="carruselTrack">
               <div class="objetivo-card">
                  <div class="card-img-container">
                     <img src="{{ asset('images/rajo.png') }}" alt="Operación">
                  </div>
                  <div class="card-body-content">
                     <h3 class="card-title-institucional">Operación</h3>
                     <p class="card-text-narrative">Su operación comenzó oficialmente el 30 de julio de 2014, procesando mineral porfídico de cobre y molibdeno de baja ley a rajo abierto.</p>
                  </div>
               </div>
               <div class="objetivo-card">
                  <div class="card-img-container">
                     <img src="{{ asset('images/Minera-Caserones.jpg') }}" alt="Proceso Productivo">
                  </div>
                  <div class="card-body-content">
                     <h3 class="card-title-institucional">Proceso Productivo</h3>
                     <p class="card-text-narrative">
                        Su faena tiene una planta concentradora para producir concentrados de cobre y molibdeno a partir de sulfuros primarios, y otra de extracción por solvente y electro-obtención (SX-EW) para producir cátodos de cobre mediante el procesamiento de minerales oxidados, mixtos y sulfuros secundarios.
                     </p>
                     <div class="card-action">
                        <a href="#" class="btn-ver-mas">
                        Ver detalles <i class="fas fa-arrow-right"></i>
                        </a>
                     </div>
                  </div>
               </div>
               <div class="objetivo-card">
                  <div class="card-img-container">
                     <img src="{{ asset('images/depositolamas.jpg') }}" alt="Relaves">
                  </div>
                  <div class="card-body-content">
                     <h3 class="card-title-institucional">Relaves</h3>
                     <p class="card-text-narrative">Los relaves son el producto del proceso de separación del mineral -cobre- de la roca, y cuya principal composición es piedra molida, agua, minerales y otros componentes. Este material es transportado a través de un ducto para ser depositado de manera segura en el lugar que la RCA aprobó para su depósito final.</p>
                     <div class="card-action">
                        <a href="#" class="btn-ver-mas">
                        Ver detalles <i class="fas fa-arrow-right"></i>
                        </a>
                     </div>
                  </div>
               </div>
               <div class="objetivo-card">
                  <div class="card-img-container">
                     <img src="{{ asset('images/ramadillasriver.jpg') }}" alt="Calidad Basal">
                  </div>
                  <div class="card-body-content">
                     <h3 class="card-title-institucional">Sistema Río Ramadillas</h3>
                     <p class="card-text-narrative">El sistema río Ramadillas considera el flujo de aguas superficiales y aguas subterráneas que escurren a través del valle del mismo nombre. Recibe aportes de aguas subterráneas provenientes de las quebradas Caserones y La Brea y finalmente se junta con el sistema río Vizcachas de Pulido para formar el sistema río Pulido.</p>
                     <div class="card-action">
                        <a href="#" class="btn-ver-mas">
                        Ver detalles <i class="fas fa-arrow-right"></i>
                        </a>
                     </div>
                  </div>
               </div>
               <div class="objetivo-card">
                  <div class="card-img-container">
                     <img src="{{ asset('images/Dep.Lastre.jpg') }}" alt="Biodiversidad">
                  </div>
                  <div class="card-body-content">
                     <h3 class="card-title-institucional">Depósito de Lastre</h3>
                     <p class="card-text-narrative">Esta instalación, ubicada en el lado oeste del rajo minero, almacena principalmente material estéril (sin mineral) proveniente del sector mina, el cual estará ubicado en el lado oeste del rajo, en la cabecera de la quebrada La Brea. La cantidad total de lastre a ser depositado en la vida útil del proyecto alcanzará a 735 Millones de Toneladas, con un llenado del botadero mediante sistema de vaciado radial en terrazas.</p>
                     <div class="card-action">
                        <a href="#" class="btn-ver-mas">
                        Ver detalles <i class="fas fa-arrow-right"></i>
                        </a>
                     </div>
                  </div>
               </div>
               <div class="objetivo-card">
                  <div class="card-img-container">
                     <img src="{{ asset('images/campamento.jpg') }}" alt="Vigilancia">
                  </div>
                  <div class="card-body-content">
                     <h3 class="card-title-institucional">Campamento</h3>
                     <p class="card-text-narrative">Se encuentra ubicado junto a la ribera Este del Río Pulido a 162 kilómetros al sureste de Copiapó, a 9 km de la frontera con Argentina y a una altura máxima de 4.600 m.s.n.m.
                        Personal propio: 930 personas
                        Personal colaborador: 2.000 a 2.500 personas
                     </p>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>