
<div class="container mt-1">
    <h3 class="display-4 text-center mt-0 mb-5" style="font-family: 'Poppins', sans-serif;">Ver Accidente de Transito</h3>
    <?php 
   
    $report = reset($reporteaccidente);
                ?>

     <form id="reporteAccidente" action="<?php echo getUrl('Solicitud', 'ReporteAccidente', 'postReporteAccidente', false, 'ajax'); ?>" method="post" enctype="multipart/form-data">
        <div class="row g-3">
            <div class= "col-md-4">
                    <label>Vehículos Involucrados<span class="text-danger">*</span></label>
                    <input type="text" name="numvehiculo" id="numvehiculo" value= "<?php echo  $filas?>" class="form-control" data-url="<?php echo getUrl("Solicitud","ReporteAccidente","vehiSeleccionados",false,"ajax")?>" disabled placeholder="Cantidad de vehículos" >
                </div>
                <div class="col-md-4">
                    <label>Tipos de vehiculos involucrados<span class="text-danger">*</span></label>
                    
                    <textarea type="text" class="form-control" rows="1" value="<?php echo $vehiculos;?>" placeholder="<?php echo $vehiculos;?>" disabled></textarea>
              </div>
            <div class= "col-md-4">
                <label>Tipo de Accidente<span class="text-danger">*</span></label>
                <input type="text" name="tsinicod" id="tsinicod" value= "<?php echo  $report['tsinidescripcion']?>" class="form-control" data-url="<?php echo getUrl("Solicitud","ReporteAccidente","vehiSeleccionados",false,"ajax")?>" disabled placeholder="Tipo siniestro" >
                </div>
                <?php 
                     $otro=$report['acciotro'];
                        if($report['tsinidescripcion']==='Otro'){
                        echo "<div class='col-md-4'>";
                        echo "<label>Otro siniestro<span class='text-danger'>*</span></label>";
                        echo "<textarea type='text' class='form-control' rows='1' placeholder='$otro' disabled></textarea>";
                        echo "</div>";                    
                    }
                    ?>
            <div class= "col-md-4">
                <label>Lesionados<span class="text-danger">*</span></label>
                <input type="number" name="lesionados" id="lesionados" class="form-control" min="0" value="<?php echo $report['accilesionados'];?>" disabled>
            </div>
            
            <div class="col-md-4">
                <label>Detalle del accidente<span class="text-danger">*</span></label>
                <textarea type="text" name="raObservacion" class="form-control" rows="1" placeholder= "<?php echo $report['acciobservaciones'];?>" value="<?php echo $report['acciobservaciones'];?>" disabled></textarea>
            </div>

            <div class="col-md-4">
                <label>Imagen<span class="text-danger">*</span></label>
                <img src="<?php echo $report['acciimagen']; ?> "alt="Imagen actual" class="img-thumbnail d-block mx-auto" style="width: 120px; height: auto; margin-top: 10px;">
            </div>
            <p>Dirección donde ocurrio el accidente.</p>
                 
            <div class="col-md-4">
                <label for="direccionCompleta" class="form-label">Dirección completa:<span class="text-danger">*</span></label>
                <input type="text" name = "raDireccion" id="direccionCompleta" class="form-control" value="<?php echo $report['accidireccion'];?>"  placeholder="La dirección se completará aquí" readonly>
            </div>   
            <div class="col-md-8">
                <?php
                    $astext = $report['astext'];
                    $x = substr($astext, 6, 16);
                    $arreglo = explode(" ", $astext);
                    $y = substr($arreglo[1], 0, 16);
                ?>
                <label class="d-block">Coordenadas<span class="text-danger">*</span></label>
                <div class="row g-4">
                    <div class="col-md-6 ">
                <input class="form-control mt-2" type="text" id="x_input" name="x" value="<?php echo $x; ?> " readonly>
                </div>
                    <div class="col-md-6">
                <input class="form-control mt-2" type="text" id="y_input" name="y" value="<?php echo $y; ?>" readonly>
            </div>
            </div>
            </div>            
            <p><b>Indica en el mapa el punto de accidente.</b></p>
            <div class="container mt-1 d-flex "style="margin-left: 50px;">
                <div class="mscross" style="overflow: hidden; width: 550px; height: 500px; -moz-user-select: none; position: relative;" id="dc_main"></div>
            </div>
            <div>
                <div style="position: relative; right: -660px; top: 147%; transform: translateY(-2200%); display: flex; align-items: center; gap: 10px; font-family: Arial, sans-serif;">
                    <img src="../Web/assets/js/Visor/misc/img/mundo.png" alt="Restaurar mapa" style="width: 25px; vertical-align: middle;">
                    <p style="margin: 0; color: #555; font-size: 14px; line-height: 25px;">
                        <b>Restaura el mapa a su tamaño inicial.</b>
                    </p>
                </div>
            </div>
            <div>
                <div style="position: relative; right: -660px; top: 154%; transform: translateY(-2000%); display: flex; align-items: center; gap: 10px; font-family: Arial, sans-serif;">
                    <img src="../Web/assets/js/Visor/misc/img/mano.png" alt="Restaurar mapa" style="width: 28px; vertical-align: middle;">
                    <p style="margin: 0; color: #555; font-size: 14px; line-height: 25px;">
                    <b>Mover el mapa.</b>
                    </p>
                </div>
            </div>
            <div>
                <div style="position: relative; right: -660px; top: 161%; transform: translateY(-2000%); display: flex; align-items: center; gap: 10px; font-family: Arial, sans-serif;">
                    <img src="../Web/assets/js/Visor/misc/img/lupa.png" alt="Restaurar mapa" style="width: 28px; vertical-align: middle;">
                    <p style="margin: 0; color: #555; font-size: 14px; line-height: 25px;">
                        <b>Zoom en áreas específicas.</b>
                    </p>
                </div>
            </div>
            <div>
                <div style="position: relative; right: -660px; top: 168%; transform: translateY(-2000%); display: flex; align-items: center; gap: 10px; font-family: Arial, sans-serif;">
                    <img src="../Web/assets/js/Visor/misc/img/lupamas.png" alt="Restaurar mapa" style="width: 28px; vertical-align: middle;">
                    <p style="margin: 0; color: #555; font-size: 14px; line-height: 25px;">
                        <b>Acercar mapa.</b>
                    </p>
                </div>
            </div>

            <div>
                <div style="position: relative; right: -660px; top: 175%; transform: translateY(-2000%); display: flex; align-items: center; gap: 10px; font-family: Arial, sans-serif;">
                    <img src="../Web/assets/js/Visor/misc/img/lupamenos.png" alt="Restaurar mapa" style="width: 28px; vertical-align: middle;">
                    <p style="margin: 0; color: #555; font-size: 14px; line-height: 25px;">
                        <b>Alejar mapa.</b>
                    </p>
                </div>
            </div>

            <div>
                <div style="position: relative; right: -660px; top: 182%; transform: translateY(-2000%); display: flex; align-items: center; gap: 10px; font-family: Arial, sans-serif;">
                    <img src="../Web/assets/js/Visor/misc/img/insert_.png" alt="Restaurar mapa" style="width: 28px; vertical-align: middle;">
                    <p style="margin: 0; color: #555; font-size: 14px; line-height: 25px;">
                        <b>Insertar punto de accidente.</b>
                    </p>
                </div>
            </div>
            
            
            <div class="col-md-12 text-center">
        <a onclick="window.location.href='<?php echo getUrl('Solicitud', 'ReporteAccidente', 'getConsulAccidente'); ?>'" class="btn btn-primary mt-4 px-4 ms-2">Volver</a>
      
        </div> 
        </div>
          
    </form>
</div>
<script src="../web/assets/js/visor/misc/lib/mscross-1.1.9.js" type="text/javascript"></script>
<script src="../web/assets/js/visor/visorveraccidente.js" type="text/javascript"></script>


