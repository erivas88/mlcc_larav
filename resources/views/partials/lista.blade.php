
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
        font-size: 16px;
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
    .glosario-container {
        padding: 20px 0;
        font-family: 'Poppins', sans-serif;
    }

    /* Navegación Alfabética */
    .alfabeto-nav {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-bottom: 40px;
        padding: 10px;
        background: #f8f9fa;
        border-radius: 30px;
    }

    .alfabeto-nav a {
        text-decoration: none;
        color: #0f7c91;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s;
    }

    .alfabeto-nav a:hover { color: #b08506; transform: scale(1.2); }

    /* Estructura de Secciones */
    .letra-seccion {
        display: flex;
        gap: 30px;
        margin-bottom: 50px;
        position: relative;
    }

    .letra-badge {
        font-size: 42px;
        font-weight: 200;
        color: rgba(15, 124, 145, 0.15); /* Color institucional tenue */
        min-width: 60px;
        line-height: 1;
        position: sticky;
        top: 20px;
    }

    .termino-item {
        flex: 1;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }

    .termino-titulo {
        font-size: 16px;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 8px;
        letter-spacing: 0.5px;
    }

    .termino-def {
        font-size: 14px;
        color: #576574;
        line-height: 1.6;
        font-weight: 300;
        text-align: justify;
    }

    /* Destaque para términos complejos como LDD */
    .destaque-tecnico {
        background: rgba(176, 133, 6, 0.03);
        padding: 15px;
        border-left: 3px solid #b08506;
        border-bottom: none;
    }

    /* Contenedor general */
.glosario-container {
    position: relative;
}

/* Navegación sticky */
.alfabeto-nav {
    position: sticky;
    top: 0;
    background: #fff;
    z-index: 10;
    padding: 10px 0;
    border-bottom: 1px solid #eaeaea;
    text-align: center;
}

.alfabeto-nav a {
    margin: 0 8px;
    text-decoration: none;
    font-weight: 600;
    color: #2c3e50;
    transition: 0.2s ease;
}

.alfabeto-nav a:hover {
    color: #007bff;
}

/* 🔥 Scroll interno */
.glosario-scroll {
    max-height: 600px; /* Ajusta a tu layout */
    overflow-y: auto;
    scroll-behavior: smooth;
    padding-right: 10px;
}

/* Scroll moderno */
.glosario-scroll::-webkit-scrollbar {
    width: 8px;
}

.glosario-scroll::-webkit-scrollbar-thumb {
    background: #cfcfcf;
    border-radius: 6px;
}

.glosario-scroll::-webkit-scrollbar-thumb:hover {
    background: #9e9e9e;
}

/* Secciones */
.letra-seccion {
    padding: 25px 10px;
    scroll-margin-top: 80px;
    border-bottom: 1px solid #f1f1f1;
}

/* Badge de letra */
.letra-badge {
    display: inline-block;
    font-size: 22px;
    font-weight: bold;
    background: #f4f6f9;
    padding: 6px 14px;
    border-radius: 8px;
    margin-bottom: 15px;
}

/* Términos */
.termino-item {
    margin-bottom: 15px;
}

.termino-item h3 {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 5px;
}

.termino-item p {
    font-size: 14px;
    color: #555;
}


/* Contenedor general */
.glosario-container {
    position: relative;
}

/* Navegación sticky */
.alfabeto-nav {
    position: sticky;
    top: 0;
    background: #fff;
    z-index: 10;
    padding: 10px 0;
    border-bottom: 1px solid #eaeaea;
    text-align: center;
}

.alfabeto-nav a {
    margin: 0 8px;
    text-decoration: none;
    font-weight: 600;
    color: #2c3e50;
    transition: 0.2s ease;
}

.alfabeto-nav a:hover {
    color: #007bff;
}

/* 🔥 Scroll interno */
.glosario-scroll {
    max-height: 600px; /* Ajusta a tu layout */
    overflow-y: auto;
    scroll-behavior: smooth;
    padding-right: 10px;
}

/* Scroll moderno */
.glosario-scroll::-webkit-scrollbar {
    width: 8px;
}

.glosario-scroll::-webkit-scrollbar-thumb {
    background: #cfcfcf;
    border-radius: 6px;
}

.glosario-scroll::-webkit-scrollbar-thumb:hover {
    background: #9e9e9e;
}

/* Secciones */
.letra-seccion {
    padding: 25px 10px;
    scroll-margin-top: 80px;
    border-bottom: 1px solid #f1f1f1;
}

/* Badge de letra */
.letra-badge {
    display: inline-block;
    font-size: 22px;
    font-weight: bold;
    background: #f4f6f9;
    padding: 6px 14px;
    border-radius: 8px;
    margin-bottom: 15px;
}

/* Términos */
.termino-item {
    margin-bottom: 15px;
}

.termino-item h3 {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 5px;
}

.termino-item p {
    font-size: 14px;
    color: #555;
}
</style>

<div class="col-md-9">
   <div class="panel">
      <div class="tope-majestuoso-inicio"> 
    <div id="sistema-header"> 
        <div class="sistema-main">
         
            <i class="fas fa-atlas sistema-icon"></i>
            <h1 class="sistema-title">Glosario</h1>
        </div>

       

        <div class="sistema-brand-corporate">
           
            <span class="brand-secondary"></span>
        </div>
    </div>
</div>
      <hr>

      <div class="glosario-container">
    <div class="alfabeto-nav">
        <a href="#sec-A">A</a> <a href="#sec-B">B</a> <a href="#sec-C">C</a> 
        <a href="#sec-F">F</a> <a href="#sec-L">L</a> <a href="#sec-M">M</a> 
        <a href="#sec-P">P</a> <a href="#sec-Q">Q</a> <a href="#sec-R">R</a>
    </div>
<div class="glosario-scroll">

    <div class="glosario-list">
        <div id="sec-A" class="letra-seccion">
            <span class="letra-badge">A</span>
            <div class="terminos-wrapper">
                <div class="termino-item">
                    <h3 class="termino-titulo">Aforador Drenes</h3>
                    <p class="termino-def">Obras construidas para medir las aguas industriales capturadas por los drenes basales del depósito.</p>
                </div>
            </div>
        </div>

        <div id="sec-B" class="letra-seccion">
            <span class="letra-badge">B</span>
            <div class="terminos-wrapper">
                <div class="termino-item">
                    <h3 class="termino-titulo">Baja Ley</h3>
                    <p class="termino-def">Material de baja ley es el que tiene un bajo porcentaje de mineral (en este caso cobre).</p>
                </div>
            </div>
        </div>

        <div id="sec-C" class="letra-seccion">
            <span class="letra-badge">C</span>
            <div class="terminos-wrapper">
                <div class="termino-item">
                    <h3 class="termino-titulo">Concentrado de cobre</h3>
                    <p class="termino-def">Es el resultante de un proceso en donde el material mineralizado proveniente del rajo se muele y se somete a flotación para separar el mineral (cobre) de la roca.</p>
                </div>
                <div class="termino-item">
                    <h3 class="termino-titulo">Concentrado de molibdeno</h3>
                    <p class="termino-def">Es el resultante de un proceso en donde el material mineralizado proveniente del rajo se muele y se somete a flotación para separar el mineral (molibdeno) de la roca.</p>
                </div>
                <div class="termino-item">
                    <h3 class="termino-titulo">Cátodo de cobre</h3>
                    <p class="termino-def">Son las placas de cobre de alta pureza que se obtienen en el proceso de electrorrefinación y electroobtención. Estos cátodos tienen una concentración de 99,9% de cobre.</p>
                </div>
            </div>
        </div>

        <div id="sec-F" class="letra-seccion">
            <span class="letra-badge">F</span>
            <div class="terminos-wrapper">
                <div class="termino-item">
                    <h3 class="termino-titulo">Faena (Minera)</h3>
                    <p class="termino-def">Sitio o área industrial dedicada a la actividad minera.</p>
                </div>
                <div class="termino-item">
                    <h3 class="termino-titulo">Fisicoquímica</h3>
                    <p class="termino-def">También llamada química física, es una rama de la ciencia que estudia la interrelación entre las propiedades físicas y químicas de una sustancia.</p>
                </div>
            </div>
        </div>

        <div id="sec-L" class="letra-seccion">
            <span class="letra-badge">L</span>
            <div class="terminos-wrapper">
                <div class="termino-item">
                    <h3 class="termino-titulo">Limite de Detección (LDD) o Concentración Neta Mínima Detectable</h3>
                    <p class="termino-def">Se define habitualmente como la cantidad o concentración mínima de sustancia que puede ser detectada con fiabilidad por un método analítico determinado. Cada Laboratorio aplica sus métodos acreditados (INN) y autorizados (SMA) y pueden tener más de un método para un mismo analito, con diferentes LDD. Los métodos a ser aplicados pueden ser diferentes entre un laboratorio y otro, métodos siempre acreditados y autorizados. Por lo anterior, al cambiar de laboratorio o de método analítico, es posible que se modifiquen los LDD informados.

</p>
                </div>
             
            </div>
        </div>

        <div id="sec-M" class="letra-seccion">
            <span class="letra-badge">M</span>
            <div class="terminos-wrapper">
                <div class="termino-item">
                    <h3 class="termino-titulo">Monitoreo Hidrogeológico</h3>
                    <p class="termino-def">
                        Medición de aguas subterráneas y toma de muestras en pozos ubicados en distintas partes de las cuencas en estudio. Las muestras son sometidas a análisis para obtener sus parámetros fisicoquímicos, como pH, Temperatura, Conductividad Eléctrica y concentración de metales, entre otros elementos
                    </p>
                </div>
                <div class="termino-item">
                    <h3 class="termino-titulo">Monitoreo Hidrológico</h3>
                    <p class="termino-def">Medición y muestreo de aguas superficiales en estaciones de monitoreo. Las muestras son análisadas en laboratorio para obtener sus parámetros fisicoquímicos, como pH, Temperatura, Conductividad Eléctrica y concentración de metales, entre otros elementos.</p>
                </div>
            </div>
        </div>

        <div id="sec-P" class="letra-seccion">
            <span class="letra-badge">P</span>
            <div class="terminos-wrapper">
                <div class="termino-item"><h3 class="termino-titulo">Planta concentradora</h3><p class="termino-def">Es el lugar donde a través de flotación se obtiene el concentrado de cobre y molibdeno a partir de material mineralizado proveniente del rajo.</p></div>
                <div class="termino-item"><h3 class="termino-titulo">Porfídico</h3><p class="termino-def">Mosaico cristalino en que existen cristales de mayor tamaño(Fenocristales) inmersos en una masa de fondo de tamaño cristalino inferio. se observa la existencia de poblaciones de tamaños bien diferenciadas, con el consecuente contraste.</p></div>
                <div class="termino-item "><h3 class="termino-titulo">Plan de Remediación</h3><p class="termino-def">Corresponde a una secuencia de acciones que se pueden tomar para controlar una situación anomala y evitar que se produzcan efectos negativos en el acuifero que subyace a las distintas instalaciones industriales. Por ejemplo, activar el bombeo de los pozos de remediación/recuperación cuando se detecten fugas de aguas (industriales o de contacto) desde los depósitos de lamas o de arenas</p></div>
                <div class="termino-item"><h3 class="termino-titulo">Pozo</h3><p class="termino-def">Perforación realizada en el suelo o roca que permite obtener agua subterránea desde el acuífero, de forma manual o por bombeo.</p></div>
                <div class="termino-item"><h3 class="termino-titulo">Pozos de Observación</h3><p class="termino-def">OObras construidas para medir la calidad de las aguas subterráneas.

</p></div>
                <div class="termino-item"><h3 class="termino-titulo">Pozos de Monitoreo Multinivel</h3><p class="termino-def">Pozo habilitado con ranurado a distintas profundidades, para contar con una mayor capacidad de análisis ante eventuales alteraciones en la química del agua subterránea en profundidad.</p></div>
                <div class="termino-item"><h3 class="termino-titulo">Pozos Aguas Arriba</h3><p class="termino-def">Obras construidas para medir la calidad de las aguas subterráneas, aguas arriba de una actividad industrial.

</p></div>
                <div class="termino-item"><h3 class="termino-titulo">Pozos Bajo Depósito (de Arenas, de Lamas, de Lastre)</h3><p class="termino-def">Obras construidas para medir la calidad de las aguas subterráneas, aguas abajo del depósito.

</p></div>
                <div class="termino-item"><h3 class="termino-titulo">Pozos de Alerta Temprana</h3><p class="termino-def">Corresponden a pozos ubicados inmediatamente aguas abajo de las instalaciones (depósito de lastre, arenas, lamas), cuya calidad fisicoquímica se utiliza como indicador para activar o desactivar el Plan de Remediación.</p></div>
                <div class="termino-item"><h3 class="termino-titulo">Pozos de Recuperación </h3><p class="termino-def">
                    Obras construidas próximas al depósito, para capturar y extraer del sistema acuífero las posibles fugas de aguas industriales o de contacto. El bombeo de estos pozos se realizara sólo cuando se haya activado el Plan de Remediación
                </p></div>
                <div class="termino-item"><h3 class="termino-titulo">Pozos de Remediación</h3><p class="termino-def">Obras construidas para capturar y extraer del sistema acuífero las posibles fugas de aguas (industriales o de contacto) desde el depósito. El bombeo de estos pozos se realizará sólo cuando se haya activado el Plan de Remediación</p></div>

                <div class="termino-item"><h3 class="termino-titulo">Pozos de Medición de la Eficiencia de Remediación</h3><p class="termino-def">Estos pozos tienen el objetivo de permitir monitorear la calidad y el nivel del agua subterránea en el sector aguas abajo de los Pozos de Remediación, para verificar que la condición basal se mantiene aguas abajo de los depósitos de arenas y lamas y en la cuenca del río Ramadillas, aún con el Plan de Remediación en funcionamiento.</p>
            </div>

            
                <div class="termino-item"><h3 class="termino-titulo">Pozos Ramadillas</h3><p class="termino-def">Obras construidas para medir la calidad de las aguas subterráneas en el sistema acuifero del río Ramadillas, aguas abajo de todas las instalaciones mineras.</p>
            </div>
            </div>
        </div>

        <div id="sec-Q" class="letra-seccion">
            <span class="letra-badge">Q</span>
            <div class="terminos-wrapper">
                <div class="termino-item">
                    <h3 class="termino-titulo">Quebrada</h3>
                    <p class="termino-def">Corriente natural de agua que normalmente fluye con continuidad, pero que a diferencia de un río, tiene escaso caudal, que incluso puede desaparecer en la estación seca, verano o invierno, dependiendo de la temporada de lluvia para su existencia.</p>
                </div>
            </div>
        </div>

        <div id="sec-R" class="letra-seccion">
            <span class="letra-badge">R</span>
            <div class="terminos-wrapper">
                <div class="termino-item"><h3 class="termino-titulo">Río</h3><p class="termino-def">Corriente de agua continua y más o menos caudalosa que desemboca en otra, en un lago o en el mar.</p></div>
                  <div class="termino-item"><h3 class="termino-titulo">Río Ramadillas, muestreo de aguas superficiales</h3><p class="termino-def">Puntos de medición de la calidad de las aguas superficiales, aguas abajo de las instalaciones mineras, para apoyar el análisis de eventuales eventos de alteraciones de la calidad de las aguas.</p></div>
                
                <div class="termino-item"><h3 class="termino-titulo">Rajo Abierto</h3><p class="termino-def">Mina explotada en la superficie utilizando una línea de explosivos. Luego de la tronadura, que remueve el material mineralizado, se realiza el carguío en camiones o en cintas transportadoras. Para ello se usan cargadores frontales o palas mecánicas, que llevan las rocas hasta la planta de chancado para iniciar el proceso de concentración.</p></div>
                <div class="termino-item">
                    <h3 class="termino-titulo">RCA (Resolución de Calificación Ambiental)</h3>
                    <p class="termino-def">
                        La Resolución de Calificación Ambiental o RCA es la autorización que entrega la Comisión de Evaluación Ambiental, que corresponde a un documento administrativo que se obtiene una vez culminado favorablemente el proceso de evaluación de impacto ambiental de un proyecto, conducido por el Servicio de Evaluación Ambiental (SEA), a partir de un Estudio de Impacto Ambiental (EIA) o de una Declaración de Impacto Ambiental (DIA)
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>  
</div>
     
