<div class="container mt-1">
    <h3 class="display-4 text-center mt-0 mb-5" style="font-family: 'Poppins', sans-serif;">Solicitud de nuevo reductor</h3>
    <?php
        foreach($nuevoredu as $nred){
    ?>
    <form id="nuevoReductorUpdate" action="<?php echo getUrl('Solicitud', 'NuevoReductor', 'postNuevoReductorUpdate', false, 'ajax'); ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="nrcod" value="<?php echo $nred['nrcod']; ?>">  
    <div class="row g-3">
        <div class="col-md-4">
                <label >Tipo de reductor</label>
                <select name="reductor" id="reductor" class="form-control" disabled>
                    <option value="">seleccione...</option>
                    <?php 
                        foreach($reductor as $redu){
                            if($redu['reducod'] == $nred['reducod']){
                                $selected ="selected";
                            }else{
                                $selected="";
                            }
                            echo "<option value ='".$redu['reducod']."' $selected>".$redu['redudescripcion']."</option>";
                        }
                    ?>  
                    </select>
           </div>
            <div class= "col-md-4">
                <label>Categoría reductor</label>
                <select name="categoria" id= "categoria" class = "form-control" disabled>
                    <option value="">Seleccione...</option>
                    <?php 
                        foreach($reductor as $redu){
                            if($redu['crcod'] == $nred['crcod']){
                                $selected ="selected";
                            }else{
                                $selected="";
                            }
                            echo "<option value ='".$redu['crcod']."' $selected>".$nred['crdescripcion']."</option>";
                        }
                    ?>           
                </select>
            </div>
           
            <div class="col-md-4">
                <label>Descripción</label>
                <textarea name="nsdescripcion" disabled class="form-control" rows="1"><?php echo $nred['nrdescripcion']; ?></textarea>
            </div>
           
            <div class="col-md-4">
                <label for="direccionCompleta" class="form-label">Dirección completa</label>
                <input type="text" name="nrDireccion" id="direccionCompleta" class="form-control"  value="<?php echo $nred['nrdireccion'];?>" disabled>
            </div> 
            <div class="col-md-4">
                <label>Imagen</label><br>
                <img src="<?php echo $nred['nrimagen']; ?> "alt="Imagen actual" class="img-thumbnail d-block mx-auto" style="width: 120px; height: auto; margin-top: 10px;">
            </div>  
            <div class="col-md-4">
                <label>Fecha</label>
                <input type="text" name="nsfecha" class="form-control" value="<?php echo $nred['nrfecha'];?>"disabled>
            </div>

            
            <div class= "col-md-4">
                <label>Estado</label>
                <select name="estcod" class = "form-control" required>
                    <option value="">Seleccione...</option>
                    <?php
                        foreach($estado as $est){
                            if($est['estcod'] == $nred['estcod']){
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
                <textarea name="nrobservacion" class="form-control" rows="1" ><?php echo $nred['nrobservacion']; ?></textarea>
            </div>
            <div class="col-md-4">
                <label class="d-block">Coordenadas<span class="text-danger">*</span></label>
                <input class="form-control" type="text" id="x_input" name="x" value="X:  <?php echo $nred['coord_x']; ?>" disabled>
                <br>
                <input class="form-control" type="text" id="y_input" name="y" value="Y:  <?php echo $nred['coord_y']; ?>" disabled>
            </div>

            <div class="container mt-4 d-flex "style="margin-left: 70px;">
                <div class="mscross" style="overflow: hidden; width: 550px; height: 500px; -moz-user-select: none; position: relative;" id="dc_main"></div>
            </div>
            <div>
                <div style="position: absolute; right: 70px; top: 110%; transform: translateY(-630%); display: flex; align-items: center; gap: 10px; font-family: Arial, sans-serif;">
                    <img src="../Web/assets/js/Visor/misc/img/mundo.png" alt="Restaurar mapa" style="width: 25px; vertical-align: middle;">
                    <p style="margin: 0; color: #555; font-size: 14px; line-height: 25px;">
                        <b>Restaura el mapa a su tamaño inicial.</b>
                    </p>
                </div>
            </div>
            <div>
                <div style="position: absolute; right: 215px; top: 117%; transform: translateY(-580%); display: flex; align-items: center; gap: 10px; font-family: Arial, sans-serif;">
                    <img src="../Web/assets/js/Visor/misc/img/mano.png" alt="Restaurar mapa" style="width: 28px; vertical-align: middle;">
                    <p style="margin: 0; color: #555; font-size: 14px; line-height: 25px;">
                    <b>Mover el mapa.</b>
                    </p>
                </div>
            </div>
            <div>
                <div style="position: absolute; right: 133px; top: 124%; transform: translateY(-580%); display: flex; align-items: center; gap: 10px; font-family: Arial, sans-serif;">
                    <img src="../Web/assets/js/Visor/misc/img/lupa.png" alt="Restaurar mapa" style="width: 28px; vertical-align: middle;">
                    <p style="margin: 0; color: #555; font-size: 14px; line-height: 25px;">
                        <b>Zoom en áreas específicas.</b>
                    </p>
                </div>
            </div>
            <div>
                <div style="position: absolute; right: 212px; top: 131%; transform: translateY(-580%); display: flex; align-items: center; gap: 10px; font-family: Arial, sans-serif;">
                    <img src="../Web/assets/js/Visor/misc/img/lupamas.png" alt="Restaurar mapa" style="width: 28px; vertical-align: middle;">
                    <p style="margin: 0; color: #555; font-size: 14px; line-height: 25px;">
                        <b>Acercar mapa.</b>
                    </p>
                </div>
            </div>

            <div>
                <div style="position: absolute; right: 222px; top: 138%; transform: translateY(-580%); display: flex; align-items: center; gap: 10px; font-family: Arial, sans-serif;">
                    <img src="../Web/assets/js/Visor/misc/img/lupamenos.png" alt="Restaurar mapa" style="width: 28px; vertical-align: middle;">
                    <p style="margin: 0; color: #555; font-size: 14px; line-height: 25px;">
                        <b>Alejar mapa.</b>
                    </p>
                </div>
            </div>
            <div class="col-md-12 text-center">
                <input type="submit" value="Enviar" class="btn btn-success mt-4 px-4">
                <a onclick="window.location.href='<?php echo getUrl('Solicitud', 'NuevoReductor', 'getconsulNuevoRedu'); ?>'" class="btn btn-danger mt-4 px-4 ms-2">Volver</a>
            </div>
        </div>
    </form>
    <?php
        }
    ?>
</div>

<script src="../web/assets/js/visor/misc/lib/mscross-1.1.9.js" type="text/javascript"></script>
<script src="../web/assets/js/Visor/visorUpdateNuevoReductor.js" type="text/javascript"></script>
<script src="../web/assets/js/solicitud/nuevoReductorUpdate.js"></script>