<div class="container mt-5">
    <h3 class="display-4 text-center mt-0 mb-5" style="font-family: 'Poppins', sans-serif;">Consultar Mis Solicitudes</h3>
   
    <!-- Fila 1 -->
    <div class="row mb-4 g-0"> 
    <div class="col-md-6 text-center mb-3">
            <a href='<?php echo getUrl('Solicitud', 'ReporteAccidente', 'getConsulAccidente'); ?>'
            class="btn btn-danger"  style="padding: 12px 20px; border-radius: 10px; display: inline-block; text-decoration: none; width: 70%;">
            Reporte de accidente
            </a>
        </div>
        <div class="col-md-6 text-center mb-3">
            <a href='<?php echo getUrl('Solicitud', 'NuevoReductor', 'getConsulNuevoRedu'); ?>'
               style="background:#4E74A6; color:white; padding: 12px 20px; border-radius: 10px; display: inline-block; text-decoration: none; width: 70%;">
               Nuevo reductor de velocidad
            </a>
        </div>
    </div>

    <!-- Fila 2 -->
    <div class="row mb-4 g-0">
        <div class="col-md-6 text-center mb-3">
            <a href='<?php echo getUrl('Solicitud', 'ReductorMalEstado', 'getConsulReduMalEstado'); ?>'
               style="background:#4E74A6; color:white; padding: 12px 20px; border-radius: 10px; display: inline-block; text-decoration: none; width: 70%;">
               Reductores de velocidad en mal estado
            </a>
        </div>
        <div class="col-md-6 text-center mb-3">
            <a href='<?php echo getUrl('Solicitud', 'SenalVialMalEstado', 'getSenalMalEstadoConsul'); ?>'
               style="background:#4E74A6; color:white; padding: 12px 20px; border-radius: 10px; display: inline-block; text-decoration: none; width: 70%;">
               Señalización vial en mal estado
            </a>
        </div>
    </div>

    <!-- Fila 3 -->
    <div class="row mb-4 g-0">
        <div class="col-md-6 text-center mb-3">
            <a href='<?php echo getUrl('Solicitud', 'MallaVialMalEstado', 'getMallaVialMalEstadoConsul'); ?>'
               style="background:#4E74A6; color:white; padding: 12px 20px; border-radius: 10px; display: inline-block; text-decoration: none; width: 70%;">
               Vía pública en mal estado
            </a>
        </div>
        <div class="col-md-6 text-center mb-3">
            <a href='<?php echo getUrl('Solicitud', 'Pqrsf', 'getPqrsfConsul'); ?>'
               style="background:#4E74A6; color:white; padding: 12px 20px; border-radius: 10px; display: inline-block; text-decoration: none; width: 70%;">
               PQRSF
            </a>
        </div>
    </div>
    <div class="row mb-4 g-0">
    <div class="col-md-6 text-center mb-3">
            <a href='<?php echo getUrl('Solicitud', 'NuevaSenal', 'getConsulNuevaSenal'); ?>'
               style="background:#4E74A6; color:white; padding: 12px 20px; border-radius: 10px; display: inline-block; text-decoration: none; width: 70%;">
               Nueva señalización vial
            </a>
        </div>
       
    </div>

</div>
