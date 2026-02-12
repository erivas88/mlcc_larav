<style>

    /* Variables de Marca */
:root {
  --teal-dark: #135d66;
  --teal-mid: #1a7b85;
  --teal-light: #eef7f8;
}

/* Banner de encabezado con imagen de fondo */
.process-banner {
  background: linear-gradient(135deg, rgba(19, 93, 102, 0.9), rgba(26, 123, 133, 0.7)), 
              url('/images/Minera-Caserones.jpg');
  background-size: cover;
  background-position: center;
  height: 180px;
  position: relative;
  display: flex;
  align-items: center;
  padding: 0 3rem;
}

.btn-close-white {
  position: absolute;
  top: 20px;
  right: 20px;
  opacity: 0.8;
}

/* Diseño de Flujo */
.production-flow {
  border-radius: 15px;
  overflow: hidden;
  background: #fff;
}

.flow-step {
  padding: 40px 20px;
  text-align: center;
  border-right: 1px solid #eee;
  position: relative;
}

.flow-step.last { border-right: none; }

.step-inner {
  padding: 20px;
  transition: transform 0.3s ease;
}

.step-icon {
  width: 70px;
  height: 70px;
  background: var(--teal-light);
  color: var(--teal-mid);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 20px;
  font-size: 1.8rem;
}

.output-label {
  margin-top: 15px;
  padding: 8px 15px;
  background: var(--teal-mid);
  color: white;
  border-radius: 6px;
  font-size: 0.8rem;
  font-weight: 600;
  text-transform: uppercase;
}

.bg-light-teal { background-color: #f8fbfa; }

.italic-quote {
  font-style: italic;
  color: #555;
  line-height: 1.6;
}

.border-teal { border-color: var(--teal-mid) !important; }

/* Efecto Hover para interactividad */
.flow-step:hover .step-inner {
  transform: translateY(-5px);
}

@media (max-width: 992px) {
  .flow-step { border-right: none; border-bottom: 1px solid #eee; }
}
</style>


<div class="modal fade" id="modalProceso" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            
            <div class="objective-header-premium" style="background-image: linear-gradient(rgba(19, 93, 102, 0.9), rgba(19, 93, 102, 0.9)), url('{{ asset('images/Minera-Caserones.jpg') }}');">
                <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="header-content-box">
                    <h2 class="h3 fw-bold text-white mb-1">Proceso Productivo</h2>
                    <div class="header-divider"></div>
                    <p class="text-white-50 small text-uppercase tracking-widest mb-0">Eficiencia en condiciones extremas</p>
                </div>
            </div>

            <div class="modal-body p-4 p-md-5">
                <div class="mb-5">
                    <p class="fs-5 text-dark lh-lg" style="font-weight: 300; border-left: 3px solid #1a7b85; padding-left: 1.5rem;">
                        "La ubicación geográfica y el trabajo en condiciones extremas exigen incorporar nuevas y mejores prácticas a nuestro modelo de negocio."
                    </p>
                </div>

                <div class="row g-4">
                    <div class="col-md-4">
                        <h6 class="fw-bold text-teal text-uppercase small mb-2">Sulfuros Primarios</h6>
                        <p class="text-muted small lh-base mb-3">Procesamiento en Planta Concentradora para la obtención de concentrados.</p>
                        <span class="d-inline-block py-1 px-2 bg-light border text-teal fw-bold" style="font-size: 10px;">Cobre y Molibdeno</span>
                    </div>
                    
                    <div class="col-md-4 border-start-pro">
                        <h6 class="fw-bold text-teal text-uppercase small mb-2">Minerales Oxidados</h6>
                        <p class="text-muted small lh-base mb-3">Extracción por solvente y electro-obtención (SX-EW) de alta pureza.</p>
                        <span class="d-inline-block py-1 px-2 bg-light border text-teal fw-bold" style="font-size: 10px;">Cátodos de Cobre</span>
                    </div>
                    
                    <div class="col-md-4 border-start-pro">
                        <h6 class="fw-bold text-teal text-uppercase small mb-2">Logística</h6>
                        <p class="text-muted small lh-base mb-3">Traslado estratégico a puntos de embarque para distribución global.</p>
                        <span class="d-inline-block py-1 px-2 bg-dark text-white fw-bold" style="font-size: 10px;">Exportación Global</span>
                    </div>
                </div>
            </div>

            <div class="modal-footer border-0 pb-4 pe-5">
                <button type="button" class="btn btn-dark btn-sm rounded-0 px-4 py-2 text-uppercase tracking-widest" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Estilo Base Caserones */
.bg-caserones { background-color: #1a7b85; }
.text-caserones { color: #1a7b85; }
.border-orange { border-color: #f39c12 !important; }
.border-purple { border-color: #8e44ad !important; }

/* Tipografía y Espaciado */
.tracking-widest { letter-spacing: 0.15em; }
.lh-lg { line-height: 1.8 !important; }

.modal-content {
    border-radius: 0; /* Un look cuadrado a veces se ve más serio/arquitectónico */
}

.bg-light {
    background-color: #f8f9fa !important;
}

/* Efecto en botones internos */
.btn-outline-dark {
    font-size: 0.75rem;
    text-transform: uppercase;
    font-weight: 700;
    letter-spacing: 1px;
    transition: 0.3s;
}

.btn-outline-dark:hover {
    background-color: #1a7b85;
    border-color: #1a7b85;
}

/* Quitar el outline azul de Bootstrap al hacer click */
.btn:focus, .btn-close:focus {
    box-shadow: none !important;
}
</style>

<div class="modal fade" id="modalRelaves" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            
            <div class="objective-header-premium" style="background-image: linear-gradient(rgba(19, 93, 102, 0.9), rgba(19, 93, 102, 0.9)), url('{{ asset('images/depositolamas.jpg') }}');">
                <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="header-content-box">
                    <h2 class="h3 fw-bold text-white mb-1">Relaves y Clasificación</h2>
                    <div class="header-divider"></div>
                    <p class="text-white-50 small text-uppercase tracking-widest mb-0">Gestión de Residuos y Sustentabilidad</p>
                </div>
            </div>

            <div class="modal-body p-4 p-md-5">
                <div class="mb-5">
                    <p class="fs-5 text-dark lh-lg" style="font-weight: 300; border-left: 3px solid #1a7b85; padding-left: 1.5rem;">
                        "El diseño de relaves en Caserones busca minimizar el consumo hídrico y energético, asegurando un depósito seguro según la normativa RCA."
                    </p>
                </div>

                <div class="row g-4">
                    <div class="col-md-4">
                        <h6 class="fw-bold text-teal text-uppercase small mb-2">Composición</h6>
                        <p class="text-muted small lh-base mb-3">Mezcla de roca molida y agua resultante del proceso de flotación.</p>
                        <span class="d-inline-block py-1 px-2 bg-light border text-secondary fw-bold" style="font-size: 10px; border-radius: 4px;">Transporte vía Ducto</span>
                    </div>
                    
                    <div class="col-md-4 border-start-pro">
                        <h6 class="fw-bold text-teal text-uppercase small mb-2">Arenas (Gruesa)</h6>
                        <p class="text-muted small lh-base mb-3">Depositadas en Quebrada Caserones, aledaña a la Planta Concentradora.</p>
                        <a href="{{ url('sector/2') }}" class="d-inline-block py-1 px-2 text-white fw-bold text-decoration-none shadow-sm" style="font-size: 10px; background-color: #ed8e24; border-radius: 4px;">
                            Ir a Depósito de Arenas <i class="fas fa-external-link-alt ms-1" style="font-size: 8px;"></i>
                        </a>
                    </div>
                    
                    <div class="col-md-4 border-start-pro">
                        <h6 class="fw-bold text-teal text-uppercase small mb-2">Lamas (Fina)</h6>
                        <p class="text-muted small lh-base mb-3">Fracción transportada por gravedad hacia la Quebrada La Brea.</p>
                        <a href="{{ url('sector/1') }}" class="d-inline-block py-1 px-2 text-white fw-bold text-decoration-none shadow-sm" style="font-size: 10px; background-color: #8e44ad; border-radius: 4px;">
                            Ir a Depósito de Lamas <i class="fas fa-external-link-alt ms-1" style="font-size: 8px;"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="modal-footer border-0 pb-4 pe-5">
                <button type="button" class="btn btn-dark btn-sm rounded-0 px-4 py-2 text-uppercase tracking-widest" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<style>
/* El Header ahora usa padding-left idéntico al modal-body para alinear el texto */
.objective-header-premium {
    background-size: cover;
    background-position: center;
    padding: 40px 3rem; /* 3rem coincide con el padding p-md-5 del cuerpo */
    position: relative;
}

.header-content-box {
    max-width: 100%;
}

.header-divider {
    width: 50px;
    height: 2px;
    background: #1a7b85;
    margin: 15px 0;
}

/* Tipografía */
.tracking-widest { letter-spacing: 0.15em; }
.text-teal { color: #1a7b85; }

/* Bordes verticales sutiles */
.border-start-pro {
    border-left: 1px solid #eaeaea;
    padding-left: 1.5rem;
}

/* Botón Minimalista */
.btn-dark.rounded-0 {
    font-size: 0.75rem;
    background: #135d66;
    border: none;
}

/* Ajuste de cierre */
.btn-close-white {
    position: absolute;
    top: 25px;
    right: 25px;
}

@media (max-width: 768px) {
    .objective-header-premium { padding: 40px 1.5rem; }
    .border-start-pro { border-left: none; padding-left: 0; }
}
</style>

<div class="modal fade" id="modalObjetivo" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            
            <div class="objective-header-premium" style="background-image: linear-gradient(rgba(19, 93, 102, 0.9), rgba(19, 93, 102, 0.9)), url('{{ asset('images/Minera-Caserones.jpg') }}');">
                <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="header-content-box">
                    <h2 class="h3 fw-bold text-white mb-1">Sistema de Mediciónes en Línea</h2>
                    <div class="header-divider"></div>                  
                </div>
            </div>

            <div class="modal-body p-4 p-md-5">
              

                 <div class="mb-5">
                    <p class="fs-5 text-dark lh-lg" style="font-weight: 300; border-left: 3px solid #1a7b85; padding-left: 1.5rem; text-align: justify;">
                           Como parte del <strong>Programa de Cumplimiento (PdC)</strong> aprobado por la Superintendencia del Medioambiente (SMA), Caserones de Minera Lumina Copper Chile ha implementado un sistema de monitoreo abierto a la comunidad.
                 </p>
                </div>

                <div class="row g-4 mb-5">
                    <div class="col-md-4">
                        <h6 class="fw-bold text-teal text-uppercase small mb-3">Cobertura</h6>
                        <p class="text-muted small lh-base">56 puntos de monitoreo hidrogeológicos e hidrológicos.</p>
                    </div>
                    <div class="col-md-4 border-start-pro">
                        <h6 class="fw-bold text-teal text-uppercase small mb-3">Finalidad</h6>
                        <p class="text-muted small lh-base">Seguimiento de variables ante efectos operativos o cambio climático.</p>
                    </div>
                    <div class="col-md-4 border-start-pro">
                        <h6 class="fw-bold text-teal text-uppercase small mb-3">Tecnología</h6>
                        <p class="text-muted small lh-base">Mediciones a distancia mediante sondas multiparamétricas en tiempo real.</p>
                    </div>
                </div>

                <footer class="pt-4 border-top">
                    <p class="small text-secondary font-italic mb-0">
                        <i class="fas fa-info-circle me-1"></i> 
                        <strong>Transparencia Técnica:</strong> Los datos presentados corresponden a mediciones crudas sin proceso de revisión manual, garantizando la inmediatez de la información recopilada.
                    </p>
                </footer>
            </div>

            <div class="modal-footer border-0 pb-4 pe-5">
                <button type="button" class="btn btn-dark btn-sm rounded-0 px-4 py-2 text-uppercase tracking-widest" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>