

<style>
    .footer-majestuoso {
        background-color: #0e7286; /* O el color pizarra de tu tope */
        color: #ffffff;
        font-family: 'Poppins', sans-serif;
        margin-top: 50px;
    }

    /* Logos refinados */
    .footer-logo-main {
        max-width: 160px;
        height: auto;
        opacity: 0.9;
    }

    .footer-logo-partner {
        max-width: 90px;
        height: auto;
        opacity: 0.6;
        transition: opacity 0.3s;
    }

    .footer-logo-partner:hover { opacity: 1; }

    /* Divisores artísticos entre columnas */
    .border-end-sublime { border-right: 1px solid rgba(255,255,255,0.1); }
    .border-start-sublime { border-left: 1px solid rgba(255,255,255,0.1); }

    /* Tipografía de Contacto */
    .info-contact { padding-left: 40px; }

    .footer-link {
        text-decoration: none;
        display: block;
        margin-bottom: 10px;
        transition: transform 0.2s;
    }

    .footer-link .label {
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: #b08506; /* Tu dorado ocre majestuoso */
        display: block;
        font-weight: 600;
    }

    .footer-link .value {
        font-size: 13px;
        color: rgba(255,255,255,0.8);
        font-weight: 300;
        letter-spacing: 0.5px;
    }

    .footer-link:hover { transform: translateX(5px); }

    /* Créditos de Desarrollo */
    .info-credits { padding-left: 40px; }

    .credit-text {
        font-size: 13px;
        font-weight: 300;
        color: rgba(255,255,255,0.7);
        line-height: 1.5;
        margin-bottom: 5px;
    }

    .gp-highlight {
        font-weight: 600;
        color: #ffffff;
    }

    .credit-email {
        font-size: 11px;
        color: #b08506;
        letter-spacing: 1px;
    }

    @media (max-width: 991px) {
        .border-end-sublime, .border-start-sublime { border: none; }
        .info-contact, .info-credits { padding: 20px 0; text-align: center; align-items: center; }
    }
</style>

<footer class="footer-majestuoso">
   <div class="container-fluid">
      <div class="row align-items-center py-5">
         <div class="col-lg-3 d-flex justify-content-center border-end-sublime">
            <img src="{{ asset('images/logo_white.png') }}" class="footer-logo-main" alt="Caserones">
         </div>

         <div class="col-lg-3 d-flex flex-column info-contact">
            <a href="tel:+56234567890" class="footer-link">
                <span class="label">Teléfono</span> <span class="value"> +(56 52) 2485050</span>
            </a>           
            <a href="https://www.caserones.cl" target="_blank" class="footer-link">
                <span class="label">Web</span> <span class="value">www.caserones.cl</span>
            </a>
         </div>

         <div class="col-lg-3 d-flex flex-column info-credits border-start-sublime">
            <p class="credit-text">
                Desarrollo e Innovación por <span class="gp-highlight">GP Consultores</span>
            </p>
            <span class="credit-email">gp@gpconsultores.cl</span>
         </div>

         <div class="col-lg-3 d-flex justify-content-center">
            <img src="{{ asset('images/gp-blanco.png') }}" class="footer-logo-partner" alt="GP Consultores">
         </div>
      </div>
   </div>
</footer>