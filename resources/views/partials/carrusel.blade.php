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


<style>
:root {
    --caserones-teal: #1a7b85;
    --caserones-dark: #135d66;
    --text-gray: #555;
}

/* Contenedor de la Card */
.objetivo-card {
    background: #ffffff;
    border-radius: 20px;
    overflow: hidden;
    border: 1px solid rgba(0,0,0,0.05);
    transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    display: flex;
    flex-direction: column;
}

.objetivo-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.12);
}

/* Imagen con Zoom al Hover */
.card-img-container {
    position: relative;
    overflow: hidden;
    height: 200px;
}

.card-img-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s ease;
}

.objetivo-card:hover .card-img-container img {
    transform: scale(1.1);
}

/* Etiqueta flotante sobre la imagen */
.card-tag {
    position: absolute;
    top: 15px;
    left: 15px;
    background: rgba(26, 123, 133, 0.9);
    color: white;
    font-size: 10px;
    text-transform: uppercase;
    padding: 5px 12px;
    border-radius: 50px;
    letter-spacing: 1px;
    font-weight: 600;
}

/* Cuerpo de la Card */
.card-body-content {
    padding: 25px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.card-title-institucional {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--caserones-dark);
    margin-bottom: 10px;
}

.title-divider {
    width: 40px;
    height: 3px;
    background: var(--caserones-teal);
    margin-bottom: 15px;
    transition: width 0.3s ease;
}

.objetivo-card:hover .title-divider {
    width: 60px;
}

.card-text-narrative {
    color: var(--text-gray);
    font-size: 12px;
    line-height: 1.6;
    margin-bottom: 20px;
}

/* Botón Estilo Modal */
.btn-ver-mas-premium {
    text-decoration: none !important;
    color: var(--caserones-teal);
    font-weight: 700;
    font-size: 14px;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    transition: all 0.3s ease;
    margin-top: auto;
}

.btn-ver-mas-premium i {
    width: 30px;
    height: 30px;
    background: #f0f7f8;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.btn-ver-mas-premium:hover {
    color: var(--caserones-dark);
}

.btn-ver-mas-premium:hover i {
    background: var(--caserones-teal);
    color: white;
    transform: translateX(5px);
}

/* 1. Asegúrate de que el contenedor del carrusel estire las cards */
.carrusel-track {
    display: flex;
    align-items: stretch; /* Esto iguala el alto de todas las cards en la fila */
}

/* 2. Modifica esta clase para que el texto sea el que empuje al botón */
.card-text-narrative {
    /* Cambia var(--text-gray) por un color sólido más oscuro */
    color: #444444; /* Un gris carbón profesional */
    font-size: 13px;
    line-height: 1.8;
    margin-bottom: 20px;  
    flex-grow: 1; 
    
    /* Propiedad adicional para mejorar la definición */
    -webkit-font-smoothing: antialiased; 
}

/* 3. El contenedor de la acción debe tener el margin-top auto */
.card-action {
    margin-top: auto; 
    padding-top: 10px; /* Un poco de respiro entre el texto y el botón */
}
</style>



<div class="seccion-objetivo-full">
   <div class="objetivo-header-minimal">
      <h2 class="objetivo-titulo" style="font-weight: BOLD;">CASERONES</h2>
      <div class="objetivo-line"></div>
   </div>
   <div class="carrusel-wrapper">
      <button class="nav-btn prev" onclick="scrollCarrusel(-1)"><i class="fas fa-chevron-left"></i></button>
      <button class="nav-btn next" onclick="scrollCarrusel(1)"><i class="fas fa-chevron-right"></i></button>
      <div class="carrusel-track" id="carruselTrack">
         <div class="objetivo-card">
            <div class="card-img-container">
               <div class="card-overlay"></div>
               <img src="{{ asset('images/rajo.png') }}" alt="Operación">
               <div class="card-tag">Operación</div>
            </div>
            <div class="card-body-content">
               <h3 class="card-title-institucional"></h3>
               <div class="title-divider"></div>
               <p class="card-text-narrative">Su operación comenzó oficialmente el 30 de julio de 2014, procesando mineral porfídico de cobre y molibdeno de baja ley a rajo abierto.</p>
            </div>
         </div>
         <div class="objetivo-card">
            <div class="card-img-container">
               <div class="card-overlay"></div>
               <img src="{{ asset('images/Minera-Caserones.jpg') }}" alt="Proceso_Productivo">
               <div class="card-tag">Proceso Productivo</div>
            </div>
            <div class="card-body-content">
               <h3 class="card-title-institucional"></h3>
               <div class="title-divider"></div>
               <p class="card-text-narrative">
                  Su faena tiene una planta concentradora para producir concentrados de cobre y molibdeno a partir de sulfuros primarios, y otra de extracción por solvente y electro-obtención (SX-EW) para producir cátodos de cobre mediante el procesamiento de minerales oxidados, mixtos y sulfuros secundarios
               </p>
               <div class="card-action">
                  <a href="#" class="btn-ver-mas-premium" data-bs-toggle="modal" data-bs-target="#modalProceso">
                  <span>Ver detalles</span>
                  <i class="fas fa-arrow-right"></i>
                  </a>
               </div>
            </div>
         </div>
         <div class="objetivo-card">
            <div class="card-img-container">
               <div class="card-overlay"></div>
               <img src="{{ asset('images/depositolamas.jpg') }}" alt="Relaves">
               <div class="card-tag">Relaves</div>
            </div>
            <div class="card-body-content">
               <h3 class="card-title-institucional"></h3>
               <div class="title-divider"></div>
               <p class="card-text-narrative">Los relaves son el producto del proceso de separación del mineral -cobre- de la roca, y cuya principal composición es piedra molida, agua, minerales y otros componentes. Este material es transportado a través de un ducto para ser depositado de manera segura en el lugar que la RCA aprobó para su depósito final.</p>
               <div class="card-action">
                  <a href="#" class="btn-ver-mas-premium" data-bs-toggle="modal" data-bs-target="#modalRelaves">
                  <span>Ver detalles</span>
                  <i class="fas fa-arrow-right"></i>
                  </a>
               </div>
            </div>
         </div>
         <div class="objetivo-card">
            <div class="card-img-container">
               <div class="card-overlay"></div>
               <img src="{{ asset('images/ramadillasriver.jpg') }}" alt="Calidad Basal">
               <div class="card-tag">Sistema Río Ramadillas</div>
            </div>
            <div class="card-body-content">
               <h3 class="card-title-institucional"></h3>
               <div class="title-divider"></div>
               <p class="card-text-narrative">El sistema río Ramadillas considera el flujo de aguas superficiales y aguas subterráneas que escurren a través del valle del mismo nombre. Recibe aportes de aguas subterráneas provenientes de las quebradas Caserones y La Brea y finalmente se junta con el sistema río Vizcachas de Pulido para formar el sistema río Pulido.</p>
               <div class="card-action">
                  <a href="{{ url('sector/3') }}" class="btn-ver-mas-premium" >
                  <span>Ver detalles</span>
                  <i class="fas fa-arrow-right"></i>
                  </a>
               </div>
            </div>
         </div>
         <div class="objetivo-card">
            <div class="card-img-container">
               <div class="card-overlay"></div>
               <img src="{{ asset('images/Dep.Lastre.jpg') }}" alt="Calidad Basal">
               <div class="card-tag">Depósito de Lastre</div>
            </div>
            <div class="card-body-content">
               <h3 class="card-title-institucional"></h3>
               <div class="title-divider"></div>
               <p class="card-text-narrative">Esta instalación, ubicada en el lado oeste del rajo minero, almacena principalmente material estéril (sin mineral) proveniente del sector mina, el cual estará ubicado en el lado oeste del rajo, en la cabecera de la quebrada La Brea. La cantidad total de lastre a ser depositado en la vida útil del proyecto alcanzará a 735 Millones de Toneladas, con un llenado del botadero mediante sistema de vaciado radial en terrazas.</p>
               <div class="card-action">
                  <a href="{{ url('sector/4') }}" class="btn-ver-mas-premium">
                  <span>Ver detalles</span>
                  <i class="fas fa-arrow-right"></i>
                  </a>
               </div>
            </div>
         </div>
         <div class="objetivo-card">
            <div class="card-img-container">
               <div class="card-overlay"></div>
               <img src="{{ asset('images/campamento.jpg') }}" alt="Vigilancia">
               <div class="card-tag">Campamento</div>
            </div>
            <div class="card-body-content">
               <h3 class="card-title-institucional"></h3>
               <div class="title-divider"></div>
               <p class="card-text-narrative">Se encuentra ubicado junto a la ribera Este del Río Pulido a 162 kilómetros al sureste de Copiapó, a 9 km de la frontera con Argentina y a una altura máxima de 4.600 m.s.n.m.
                  Personal propio: 930 personas
                  Personal colaborador: 2.000 a 2.500 personas
               </p>
            </div>
         </div>
      </div>
   </div>
</div>