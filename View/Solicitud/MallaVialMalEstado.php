<div class="container mt-1">
    <h3 class="display-4 text-center mt-0 mb-5" style="font-family: 'Poppins', sans-serif;">Solicitud de vía publica en mal estado</h3>
    <p> Los campos marcados con un asterisco (<span class="text-danger">*</span>) son obligatorios.</p>
   
    <form id="solicitudMalla" action="<?php echo getUrl('Solicitud', 'MallaVialMalEstado', 'postMallaVialMalEstado', false, 'ajax'); ?>" method="post" enctype="multipart/form-data">
        <div class="row g-3">
            <div class= "col-md-4">
                <label>Tipo de daño<span class="text-danger">*</span></label>
                <select name="tdanocod" class = "form-control"  data-url="<?php echo getUrl("Solicitud","Solicitud","getTipoDano")?>" required>
                    <option value="">Seleccione...</option>
                    <?php
                    foreach($tipoDano as $dano){
                        echo "<option value = '".$dano['tdanocod']."'>".$dano['tdanodescripcion']."</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-4">
                <label>Descripción<span class="text-danger">*</span></label>
                <textarea type="text" name="vmedescripcion" class="form-control" rows="1" placeholder= "Escribe una descripción detallada" required></textarea>
            </div>
            <div class="col-md-4">
                <label>Subir imagen<span class="text-danger">*</span></label>
                <input type="file" name="vmeimagen" class="form-control" accept=".jpg, .jpeg, .png" required>
            </div>
            
            <p>Ingrese la dirección de la vía publica en mal estado.</p>
            <div class="col-md-4">
            
                <label for="tipoDireccion" class="form-label">Tipo vía <span class="text-danger">*</span></label>
                <select id="tipoDireccion" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <option value="Calle">Calle</option>
                    <option value="Carrera">Carrera</option>
                    <option value="Avenida">Avenida</option>
                    <option value="Transversal">Transversal</option>
                    <option value="Diagonal">Diagonal</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="numeroVia" class="form-label">Número/Letras:<span class="text-danger">*</span></label>
                <input type="text" id="numeroVia" name="numeroVia" pattern="[0-9]{1,3}[A-Za-z]?" class="form-control" placeholder="Ejemplo: 123 o 123A" required>
            </div>
            <div class="col-md-4">
            <label for="prefijo" class="form-label">Prefijo:</label>
                    <select id="prefijo" name="prefijo" class="form-control">
                        <option value="">(Ninguno)</option>
                        <option value="BIS">BIS</option>
                        <option value="NORTE">NORTE</option>
                        <option value="SUR">SUR</option>
                        <option value="ESTE">ESTE</option>
                        <option value="OESTE">OESTE</option>
                    </select>
            </div>
            <div class="col-md-4">
                <label for="numero" class="form-label">Número después de #:<span class="text-danger">*</span></label>
                <input type="text" id="numero" name="numero" pattern="[0-9]+[A-Za-z]?-[0-9]+" class="form-control" placeholder="Ejemplo: 34-70 o 34A-70" required>
            </div>
            <div class="col-md-4">
                <label for="direccionCompleta" class="form-label">Dirección completa:<span class="text-danger">*</span></label>
                <input type="text" name ="vmedireccion" id="direccionCompleta" class="form-control" placeholder="La dirección se completará aquí" readonly>
            </div>  
            
            <div class="col-md-4">
                <label class="d-block">Coordenadas<span class="text-danger">*</span></label>
                <input class="form-control" type="text" id="x_input" name="x" placeholder="X: " readonly>
                <br>
                <input class="form-control" type="text" id="y_input" name="y" placeholder="Y: " readonly>
            </div>
            <p><b>Indica en el mapa el punto de la vía en mal estado.</b></p>
        
            <div class="container mt-1 d-flex "style="margin-left: 70px;">
                <div class="mscross" style="overflow: hidden; width: 550px; height: 500px; -moz-user-select: none; position: relative;" id="dc_main"></div>
            </div>
            <div>
                <div style="position: absolute; right: 70px; top: 110%; transform: translateY(-200%); display: flex; align-items: center; gap: 10px; font-family: Arial, sans-serif;">
                    <img src="../Web/assets/js/Visor/misc/img/mundo.png" alt="Restaurar mapa" style="width: 25px; vertical-align: middle;">
                    <p style="margin: 0; color: #555; font-size: 14px; line-height: 25px;">
                        <b>Restaura el mapa a su tamaño inicial.</b>
                    </p>
                </div>
            </div>
            <div>
                <div style="position: absolute; right: 215px; top: 117%; transform: translateY(-200%); display: flex; align-items: center; gap: 10px; font-family: Arial, sans-serif;">
                    <img src="../Web/assets/js/Visor/misc/img/mano.png" alt="Restaurar mapa" style="width: 28px; vertical-align: middle;">
                    <p style="margin: 0; color: #555; font-size: 14px; line-height: 25px;">
                    <b>Mover el mapa.</b>
                    </p>
                </div>
            </div>
            <div>
                <div style="position: absolute; right: 133px; top: 124%; transform: translateY(-200%); display: flex; align-items: center; gap: 10px; font-family: Arial, sans-serif;">
                    <img src="../Web/assets/js/Visor/misc/img/lupa.png" alt="Restaurar mapa" style="width: 28px; vertical-align: middle;">
                    <p style="margin: 0; color: #555; font-size: 14px; line-height: 25px;">
                        <b>Zoom en áreas específicas.</b>
                    </p>
                </div>
            </div>
            <div>
                <div style="position: absolute; right: 212px; top: 131%; transform: translateY(-200%); display: flex; align-items: center; gap: 10px; font-family: Arial, sans-serif;">
                    <img src="../Web/assets/js/Visor/misc/img/lupamas.png" alt="Restaurar mapa" style="width: 28px; vertical-align: middle;">
                    <p style="margin: 0; color: #555; font-size: 14px; line-height: 25px;">
                        <b>Acercar mapa.</b>
                    </p>
                </div>
            </div>

            <div>
                <div style="position: absolute; right: 222px; top: 138%; transform: translateY(-200%); display: flex; align-items: center; gap: 10px; font-family: Arial, sans-serif;">
                    <img src="../Web/assets/js/Visor/misc/img/lupamenos.png" alt="Restaurar mapa" style="width: 28px; vertical-align: middle;">
                    <p style="margin: 0; color: #555; font-size: 14px; line-height: 25px;">
                        <b>Alejar mapa.</b>
                    </p>
                </div>
            </div>

            <div>
                <div style="position: absolute; right: 122px; top: 145%; transform: translateY(-200%); display: flex; align-items: center; gap: 10px; font-family: Arial, sans-serif;">
                    <img src="../Web/assets/js/Visor/misc/img/insert_.png" alt="Restaurar mapa" style="width: 28px; vertical-align: middle;">
                    <p style="margin: 0; color: #555; font-size: 14px; line-height: 25px;">
                        <b>Insertar punto de accidente.</b>
                    </p>
                </div>
            </div>
            
            <div class="col-md-12 text-center">
                <input type="submit" value="Enviar" class="btn btn-success mt-4 px-4">
                <a href="../web/index.php" class="btn btn-danger mt-4 px-4 ms-2">Cancelar</a>
            </div>
           
        </div>
    </form>
</div>


<script src="../web/assets/js/visor/misc/lib/mscross-1.1.9.js" type="text/javascript"></script>
<script src="../web/assets/js/Visor/visor.js" type="text/javascript"></script>
<script src="../web/assets/js/solicitud/mallaVialMalEstado.js"></script>