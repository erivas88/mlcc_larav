

<style>
.icon-square {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 6px; /* Ajusta este valor si lo quieres más o menos cuadrado */
    margin-right: 10px; /* Espacio entre el cuadro y el texto */
    flex-shrink: 0;
}

/* Nota: Cambié el color del texto de tu <span> de 'white' a '#444' 
   porque sobre el fondo blanco del acordeón no se vería el texto. */
</style>


<div class="col-md-3 pr-0">
   <div class="accordion custom-sidebar" id="accordionExample" style="font-family: 'Poppins', sans-serif !important;">    
     
      <div class="accordion-item border-0 mb-1">
         <h2 class="accordion-header d-flex bg-white" style="border-left: 4px solid #8e44ad;">
            <a href="{{ url('sector/1') }}" title="Ir a Depósito de Lamas La Brea" class="flex-grow-1 text-decoration-none">
            <button class="accordion-button collapsed py-2 px-3 bg-transparent shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1">
               <span class="icon-square" style="background: rgba(142, 68, 173, 0.1); border: 1px solid rgba(142, 68, 173, 0.2);">
                  <i class="fas fa-layer-group" style="color: #8e44ad; font-size: 16px" aria-hidden="true"></i>
               </span>
               <span class="fw-bold" style="color: white; font-size: 13px; font-weight: normal !important">Depósito de Lamas La Brea</span>
            </button>
            </a>
         </h2>
      </div>

      <div class="accordion-item border-0 mb-1">
         <h2 class="accordion-header d-flex bg-white" style="border-left: 4px solid #ed8e24;">
            <a href="{{ url('sector/2') }}"  title="Ir a Depósito de Arenas Caserones" class="flex-grow-1 text-decoration-none">
            <button class="accordion-button collapsed py-2 px-3 bg-transparent shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3">
               <span class="icon-square" style="background: rgba(237, 142, 36, 0.1); border: 1px solid rgba(237, 142, 36, 0.2);">
                  <i class="fas fa-layer-group" style="color: #f39c12; font-size: 16px" aria-hidden="true"></i>
               </span>
               <span class="fw-bold" style="color: white; font-size: 13px; font-weight: normal !important">Depósito de Arenas Caserones </span>
            </button>
            </a>
         </h2>
      </div>
    
      <div class="accordion-item border-0 mb-1">
         <h2 class="accordion-header d-flex bg-white" style="border-left: 4px solid #ffc107;">
            <a href="{{ url('sector/4') }}" title="Ir a Depósito de Lastre" class="flex-grow-1 text-decoration-none">
            <button class="accordion-button collapsed py-2 px-3 bg-transparent shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4">
               <span class="icon-square" style="background: rgba(255, 193, 7, 0.1); border: 1px solid rgba(255, 193, 7, 0.2);">
                  <i class="fas fa-layer-group" style="color: #ffc107; font-size: 16px" aria-hidden="true"></i>
               </span>
               <span class="fw-bold" style="color: white; font-size: 13px; font-weight: normal !important">Depósito de Lastre</span>
            </button>
            </a>
         </h2>
      </div>

      <div class="accordion-item border-0 mb-1">
         <h2 class="accordion-header d-flex bg-white" style="border-left: 4px solid #59d01b;">
            <a href="{{ url('sector/3') }}" title="Ir a Sistema Río Ramadillas" class="flex-grow-1 text-decoration-none">
            <button class="accordion-button collapsed py-2 px-3 bg-transparent shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3">
               <span class="icon-square" style="background: rgba(89, 208, 27, 0.1); border: 1px solid rgba(89, 208, 27, 0.2);">
                  <i class="fas fa-layer-group" style="color: #59d01b; font-size: 16px" aria-hidden="true"></i>
               </span>
               <span class="fw-bold" style="color: white; font-size: 13px; font-weight: normal !important">Sistema Río Ramadillas</span>
            </button>
            </a>
         </h2>
      </div>

   </div>
</div>
