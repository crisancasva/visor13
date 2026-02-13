<div class="container mt-1">
    <h3 class="display-4 text-center mt-0 mb-5" style="font-family: 'Poppins', sans-serif;">Solicitud de vía publica en mal estado</h3> 
    <?php
        foreach($viamal as $via){
    ?>  
    <form id="mallaVialMalEstadoUpdate" action="<?php echo getUrl('Solicitud', 'MallaVialMalEstado', 'postMallaVialMalEstadoUpdate', false, 'ajax'); ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="vmecod" value="<?php echo $via['vmecod']; ?>">
        <div class="row g-3">
            <div class= "col-md-4">
                <label>Tipo de daño<span class="text-danger">*</span></label>
                <select name="tdanocod" class = "form-control"  disabled>
                    <option value="">Seleccione...</option>
                    <?php
                    foreach($tipoDano as $dano){
                        if($dano['tdanocod'] == $via['tdanocod']){
                            $selected ="selected";
                        }else{
                            $selected="";
                        }
                        echo "<option value ='".$dano['csencod']."' $selected>".$dano['tdanodescripcion']."</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-4">
                <label>Descripción</label>
                <textarea name="vmedescripcion" disabled class="form-control"><?php echo $via['vmedescripcion']; ?></textarea>
            </div>
            <div class="col-md-4">
                <label>Imagen</label><br>
                <img src="<?php echo $via['vmeimagen']; ?> "alt="Imagen actual" class="img-thumbnail d-block mx-auto" style="width: 120px; height: auto; margin-top: 10px;">
            </div>  
            <div class="col-md-4">
                <label for="direccionCompleta" class="form-label">Dirección</label>
                <input type="text" name ="vmedireccion" id="direccionCompleta" class="form-control" value="<?php echo $via['vmedireccion'];?>" disabled>
            </div>
            <div class="col-md-4">
                <label>Fecha</label>
                <input type="text" name="vmefecha" class="form-control" value="<?php echo $via['vmefecha'];?>"disabled>
            </div>


            <div class="col-md-4">
                <label class="d-block">Coordenadas<span class="text-danger">*</span></label>
                <input class="form-control" type="text" id="x_input" name="x" value="X: <?php echo $via['coord_x']; ?> " disabled>
                <br>
                <input class="form-control" type="text" id="y_input" name="y" value="Y: <?php echo $via['coord_y']; ?> " disabled>
            </div>
            
            <div class= "col-md-4">
                <label>Estado</label>
                <select name="estcod" class = "form-control" required>
                    <option value="">Seleccione...</option>
                    <?php
                        foreach($estado as $est){
                            if($est['estcod'] == $via['estcod']){
                                $selected ="selected";
                            }else{
                                $selected="";
                            }
                            echo "<option value ='".$est['estcod']."' $selected>".$est['estdescripcion']."</option>";
                        }
                    ?>   
                </select>
            </div>
            <div class="col-md-4">
                <label>Observación</label>
                <textarea name="vmeobservacion" rows="1" class="form-control"><?php echo $via['vmeobservacion']; ?></textarea>
            </div> 
         

            <div class="container mt-4 d-flex "style="margin-left: 70px;">
                <div class="mscross" style="overflow: hidden; width: 550px; height: 500px; -moz-user-select: none; position: relative;" id="dc_mainUpdate"></div>
            </div>
            <div>
                <div style="position: absolute; right: 70px; top: 110%; transform: translateY(-680%); display: flex; align-items: center; gap: 10px; font-family: Arial, sans-serif;">
                    <img src="../Web/assets/js/Visor/misc/img/mundo.png" alt="Restaurar mapa" style="width: 25px; vertical-align: middle;">
                    <p style="margin: 0; color: #555; font-size: 14px; line-height: 25px;">
                        <b>Restaura el mapa a su tamaño inicial.</b>
                    </p>
                </div>
            </div>
            <div>
                <div style="position: absolute; right: 215px; top: 117%; transform: translateY(-630%); display: flex; align-items: center; gap: 10px; font-family: Arial, sans-serif;">
                    <img src="../Web/assets/js/Visor/misc/img/mano.png" alt="Restaurar mapa" style="width: 28px; vertical-align: middle;">
                    <p style="margin: 0; color: #555; font-size: 14px; line-height: 25px;">
                    <b>Mover el mapa.</b>
                    </p>
                </div>
            </div>
            <div>
                <div style="position: absolute; right: 133px; top: 124%; transform: translateY(-630%); display: flex; align-items: center; gap: 10px; font-family: Arial, sans-serif;">
                    <img src="../Web/assets/js/Visor/misc/img/lupa.png" alt="Restaurar mapa" style="width: 28px; vertical-align: middle;">
                    <p style="margin: 0; color: #555; font-size: 14px; line-height: 25px;">
                        <b>Zoom en áreas específicas.</b>
                    </p>
                </div>
            </div>
            <div>
                <div style="position: absolute; right: 212px; top: 131%; transform: translateY(-630%); display: flex; align-items: center; gap: 10px; font-family: Arial, sans-serif;">
                    <img src="../Web/assets/js/Visor/misc/img/lupamas.png" alt="Restaurar mapa" style="width: 28px; vertical-align: middle;">
                    <p style="margin: 0; color: #555; font-size: 14px; line-height: 25px;">
                        <b>Acercar mapa.</b>
                    </p>
                </div>
            </div>

            <div>
                <div style="position: absolute; right: 222px; top: 138%; transform: translateY(-630%); display: flex; align-items: center; gap: 10px; font-family: Arial, sans-serif;">
                    <img src="../Web/assets/js/Visor/misc/img/lupamenos.png" alt="Restaurar mapa" style="width: 28px; vertical-align: middle;">
                    <p style="margin: 0; color: #555; font-size: 14px; line-height: 25px;">
                        <b>Alejar mapa.</b>
                    </p>
                </div>
            </div>

            <div class="col-md-12 text-center">
                <input type="submit" value="Enviar" class="btn btn-success mt-4 px-4">
                <a onclick="window.location.href='<?php echo getUrl('Solicitud', 'MallaVialMalEstado', 'getMallaVialMalEstadoConsul'); ?>'" class="btn btn-danger mt-4 px-4 ms-2">Volver</a>
            </div>
        </div>
    </form>
    <?php
        }
    ?>
</div>



<script src="../web/assets/js/visor/misc/lib/mscross-1.1.9.js" type="text/javascript"></script>
<script src="../web/assets/js/Visor/visorUpdateMalla.js" type="text/javascript"></script>
<script src="../web/assets/js/solicitud/mallaVialMalEstadoUpdate.js"></script>