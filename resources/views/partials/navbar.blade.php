

<style>
    /* Header Superior */
    .main-header-sublime {
        background-color: #ffffff;
        padding: 12px 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .img-logo {
        max-width: 150px;
        height: auto;
    }

    /* Navegación Superior: Más natural */
    .nav-links-artistic a {
        font-family: 'Poppins', sans-serif;
        text-decoration: none;
        color: #576574;
        font-size: 14px;
        font-weight: 400;
        margin-left: 25px;
        transition: color 0.3s ease;
    }

    .nav-links-artistic a:hover {
        color: #02697e;
    }

    /* Barra del Sistema */
    .system-nav-majestuoso {
        background: linear-gradient(to right, #02697e, #3e98a6); /* Tu gradiente institucional */
        padding: 10px 0;
        box-shadow: 0 2px 15px rgba(0,0,0,0.1);
    }

    /* Monitoreo en Línea: Semi-Bold y Natural */
    .system-title-link {
        font-family: 'Poppins', sans-serif;
        color: #ffffff;
        text-decoration: none;
        font-size: 18px;
        font-weight: 600; /* CAMBIO: Ahora es bold pero elegante */
        letter-spacing: 0.5px;
        text-transform: none; /* Adiós a las mayúsculas permanentes */
    }

    /* Detalle Artístico: El separador dorado */
    .title-divider-gold {
        width: 1px;
        height: 20px;
        background-color: rgba(176, 133, 6, 0.6); /* Dorado ocre sutil */
        margin: 0 15px;
    }

    /* Subtítulo ligero para balancear el bold */
    .system-subtitle {
        color: rgba(255, 255, 255, 0.7);
        font-size: 13px;
        font-weight: 300;
        letter-spacing: 1px;
    }
</style>


<style>
    .nav-links-artistic {
        display: flex;
        gap: 25px;
    }

    .nav-links-artistic a {
        font-family: 'Poppins', sans-serif;
        text-decoration: none;
        color: #576574;
        font-size: 14px;
        font-weight: 400;
        position: relative; /* Necesario para posicionar la línea */
        padding-bottom: 8px; /* Espacio para que la línea no choque con el texto */
        transition: color 0.3s ease;
    }

    /* La Línea Artística (Estado Inicial) */
    .nav-links-artistic a::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;         /* Inicia en el centro */
        width: 0;          /* Ancho cero inicial */
        height: 4px;       /* Grosor "gruesito" artístico */
        background-color: #02697e; /* Tu azul corporativo */
        border-radius: 2px; /* Bordes redondeados para suavidad */
        transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55); /* Efecto elástico */
        transform: translateX(-50%);
        opacity: 0;
    }

    /* Efecto al pasar el Mouse (Hover) */
    .nav-links-artistic a:hover {
        color: #02697e;    /* El texto cambia al color de la marca */
    }

    .nav-links-artistic a:hover::after {
        width: 100%;       /* La línea se expande al ancho total del link */
        opacity: 1;        /* Se vuelve visible */
    }

    .main-header-sublime {
        background-color: #ffffff;
        /* Aumentamos el padding vertical para que no se vea pegado al top */
        padding: 25px 0; 
        border-bottom: 1px solid #f0f0f0;
    }

    /* Contenedor Flex con alineación central perfecta */
    .main-header-sublime .container-fluid {
        display: flex;
        align-items: center; /* Alinea logo y links por su eje central */
    }

    .img-logo {
        max-width: 150px;
        height: auto;
    }

    /* Navegación Superior: Espaciado Artístico */
    .nav-links-artistic {
        display: flex;
        gap: 40px; /* Aumentamos el espacio entre links para que no se vean apretados */
    }

    .nav-links-artistic a {
        font-family: 'Poppins', sans-serif;
        text-decoration: none;
        color: #576574;
        font-size: 14px;
        font-weight: 400;
        position: relative;
        /* Padding balanceado para alejar el texto de la línea y del borde superior */
        padding: 10px 0; 
        transition: color 0.3s ease;
    }

    /* La Línea Artística (Grosor y Posición) */
    .nav-links-artistic a::after {
        content: '';
        position: absolute;
        bottom: -2px;      /* Bajamos un poco la línea para que respire */
        left: 50%;
        width: 0;
        height: 4px;       /* Grosor majestuoso */
        background-color: #02697e;
        border-radius: 2px;
        transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        transform: translateX(-50%);
        opacity: 0;
    }

    .nav-links-artistic a:hover::after {
        width: 100%;
        opacity: 1;
    }

    /* Barra del Sistema con más altura */
    .system-nav-majestuoso {
        background: linear-gradient(to right, #02697e, #3e98a6);
        padding: 15px 0; /* Un poco más de cuerpo a la barra azul */
        box-shadow: 0 2px 15px rgba(0,0,0,0.1);
    }

    .nav-links-artistic a.active {
        color: #02697e; /* Color institucional activo */
        font-weight: 600; /* Un toque más de peso para resaltar */
    }

    .nav-links-artistic a.active::after {
        width: 100%;   /* Línea extendida al 100% */
        opacity: 1;    /* Visible permanentemente */
    }
    
    /* Mantenemos el grosor majestuoso de 4px que definimos antes */
    .nav-links-artistic a::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 50%;
        width: 0;
        height: 4px; 
        background-color: #02697e;
        border-radius: 2px;
        transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        transform: translateX(-50%);
        opacity: 0;
    }
</style>

<header class="main-header-sublime">
   <div class="container-fluid d-flex justify-content-between align-items-center px-4">
      <a href="{{ url('/') }}" class="logo-wrapper">
         <img src="{{ asset('images/logo.png') }}" alt="Logo Caserones" class="img-logo">
      </a>
      
      <nav class="nav-links-artistic">
    <a href="{{ url('/') }}" class="{{ Request::is('/') ? 'active' : '' }}">Inicio</a>
    <a href="{{ url('glosario') }}" class="{{ Request::is('glosario') ? 'active' : '' }}">Glosario</a>
    <a href="https://www.caserones.cl/contacto/" class="{{ Request::is('contacto') ? 'active' : '' }}">Contáctenos</a>
</nav>
   </div>
</header>

<nav class="system-nav-majestuoso">
   <div class="container-fluid px-4">
      <div class="d-flex align-items-center">
         <a href="{{ url('/') }}" class="system-title-link">
            Monitoreo en Línea
         </a>
         <span class="title-divider-gold"></span>
         <span class="system-subtitle">Plataforma de Vigilancia Ambiental</span>
      </div>
   </div>
</nav>