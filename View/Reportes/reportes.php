<div class="container mt-1">
    <h3 class="display-4 text-center mt-0 mb-5" style="font-family: 'Poppins', sans-serif;">Reportes</h3>

    <!-- Primera fila -->
    <div class="row mb-4">
        <div class="col-md-6 text-center">
        <a href="<?php echo getUrl('Reportes','Reportes','generarReporteRAT',false,'ajax')?>" class="ajax-trigger">
            <i class="fas fa-file-excel fa-5x" style="color: rgb(32, 160, 60) ;"  aria-hidden="true"></i>
            </a>
            <h5 class="mt-2">Accidentes de transito</h5>
        </div>
        <div class="col-md-6 text-center">
            <a href="<?php echo getUrl('Reportes','Reportes','generarReporteRSV',false,'ajax')?>" class="ajax-trigger">
                <i class="fas fa-file-excel fa-5x" style="color: rgb(32, 160, 60);"  aria-hidden="true"></i>
            </a>
            <h5 class="mt-2">Solicitudes de reparación de señales viales</h5>
        </div>
    </div>

    <!-- Segunda fila -->
    <div class="row">
        <div class="col-md-6 text-center">
            <a href="<?php echo getUrl('Reportes','Reportes','generarReporteRR',false,'ajax')?>" class="ajax-trigger">
                <i class="fas fa-file-excel fa-5x" style="color:rgb(32, 160, 60);"  aria-hidden="true"></i>
            </a>
            <h5 class="mt-2">Solicitudes de reparación de reductores</h5>
        </div>
        <div class="col-md-6 text-center">
            <a href="<?php echo getUrl('Reportes','Reportes','generarReporteRMV',false,'ajax')?>" class="ajax-trigger">
                <i class="fas fa-file-excel fa-5x" style="color:rgb(32, 160, 60);" aria-hidden="true"></i>
            </a>
            <h5 class="mt-2">Solicitudes de reparación malla vial</h5>
        </div>
    </div>
    
</div>
<div class=" mt-5 mb-5" style="margin-top: 120px;">
<p class="bold-text text-danger"><b>Nota: </b> Para proceder con la descarga del archivo, haz clic en el ícono.</p>
</div>
<script src="../web/assets/js/Reportes/reportes.js"></script>