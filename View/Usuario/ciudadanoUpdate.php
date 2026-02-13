
<div class="container mt-1">
    <h3 class="display-4 text-center mt-0 mb-5" style="font-family: 'Poppins', sans-serif;">Actualizar mis datos</h3>
    <p>Los campos que contengan asterisco(<span class="text-danger">*</span>) no pueden quedar vacíos.</p>
    <?php
        foreach($ciudadano as $ciu){

    ?>
    <form id="ciudadano" action="<?php echo getUrl('Usuario', 'Ciudadano', 'postUpdateCiudadano', false, 'ajax'); ?>" method="post" enctype="multipart/form-data">
        <div class="row g-3">
            <div class="col-md-3">
                <label>Primer nombre</label>
                <input type="text" name="usuPrimerNombre" class="form-control" placeholder="Primer nombre" disabled pattern="[A-Za-zÀ-ÿ\s]+" title="Solo se permiten letras" value="<?php echo $ciu ['usuprimernombre'];?>">
            </div>
            <div class="col-md-3">
                <label>Segundo nombre</label>
                <input type="text" name="usuSegundoNombre" class="form-control" placeholder="Segundo nombre"  disabled pattern="[A-Za-zÀ-ÿ\s]+" title="Solo se permiten letras" value="<?php echo $ciu ['ususegundonombre'];?>">
            </div>
            <div class="col-md-3">
                <label>Primer apellido</label>
                <input type="text" name="usuPrimerApellido" class="form-control" placeholder= "Primer Apellido" disabled pattern="[A-Za-zÀ-ÿ\s]+" title="Solo se permiten letras"value="<?php echo $ciu ['usuprimerapellido'];?>">
            </div>
            <div class="col-md-3">
                <label>Segundo apellido</label>
                <input type="text" name="usuSegundoApellido" class="form-control" placeholder="Segundo Apellido" disabled pattern="[A-Za-zÀ-ÿ\s]+" title="Solo se permiten letras" value="<?php echo $ciu ['ususegundoapellido'];?>">
            </div>
            <div class= "col-md-3">
                    <label>Tipo de documento</label>
                    <select name="tDocCod" class = "form-control" disabled>
                        <option value="">Seleccione...</option>
                        <?php
                        foreach($tipoDoc as $doc){
                            if($doc['tdoccod'] == $ciu['tdoccod']){
                                $selected ="selected";
                            }else{
                                $selected="";
                            }
                            echo "<option value ='".$doc['tdoccod']."' $selected>".$doc['tdocdescripcion']."</option>";
                        }
                        ?>
                    </select>
            </div>
            <div class="col-md-3">
                <label>Número de identificación</label>
                <input type="text" name="usuNumDoc" class="form-control" maxlength="11" pattern="\d{8,11}" title="Debe contener maximo 11 números" placeholder="Numero de documento" disabled value="<?php echo $ciu ['usunumdoc'];?>">
            </div>
            <div class="col-md-3">
                <label>Correo electrónico<span class="text-danger">*</span></label>
                <input type="email" name="usuCorreo"  class="form-control" placeholder="Correo electronico" required value="<?php echo $ciu ['usucorreo'];?>">
            </div>
            <div class="col-md-3">
                <label>Teléfono<span class="text-danger">*</span></label>
                <input type="text" name="usuTelefono" class="form-control" maxlength="10" pattern="\d{10}" title="Debe contener exactamente 10 números" placeholder="Telefono" value="<?php echo $ciu ['usutelefono'];?>">
            </div>
            <div class="col-md-6">
                <label>Contraseña</label>
                <div class="position-relative">
                    <input type="password" id="usuClave" name="usuClave" class="form-control pr-5" placeholder="Contraseña">
                    <i id="toggleIcon" class="fas fa-eye position-absolute" 
                    style="right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"
                    onclick="togglePassword()">
                    </i>
                </div>
                
            </div> 
            <div class="col-md-6">
                <label>Confirmar contraseña</label>
                <div class="position-relative">
                    <input type="password" id="usuConfirmarClave" name="usuConfirmarClave" class="form-control pr-5" placeholder="Repite la contraseña" >
                    <i id="toggleConfirmIcon" class="fas fa-eye position-absolute" 
                        style="right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"
                        onclick="toggleConfirmPassword()">
                    </i>
                </div>
            </div> 

            <div class="col-md-8">
                <p>La contraseña debe contener:</p>
                <li>
                    Minimo 8 caracteres.
                </li>
                <li>
                    Una letra mayuscula.  
                </li>
                <li>
                    Un numero.
                </li>
                <li>
                    Un caracter especial como (#,$,%,&,/,*).
                </li>
                <li>
                    No debe contener espacios.
                </li>
            </div>
            <b class="text-danger">Nota: Si no desea cambiar la contraseña, deje los campos de la contraseña en blanco.</b>


            <p>Ingrese dirección de residencia</p>
            <div class="col-md-4">
            
                <label for="tipoDireccion" class="form-label">Tipo vía </span></label>
                <select id="tipoDireccion" class="form-control">
                    <option value="">Seleccione...</option>
                    <option value="Calle">Calle</option>
                    <option value="Carrera">Carrera</option>
                    <option value="Avenida">Avenida</option>
                    <option value="Transversal">Transversal</option>
                    <option value="Diagonal">Diagonal</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="numeroVia" class="form-label">Número/Letras:</label>
                <input type="text" id="numeroVia" name="numeroVia" pattern="[0-9]{1,3}[A-Za-z]?" class="form-control" placeholder="Ejemplo: 123 o 123A">
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
                <label for="numero" class="form-label">Número después de #:</label>
                <input type="text" id="numero" name="numero" pattern="[0-9]+[A-Za-z]?-[0-9]+" class="form-control" placeholder="Ejemplo: 34a-70">
            </div> 
            <div class="col-md-4">
                <label for="direccionCompleta" class="form-label">Dirección completa:<span class="text-danger">*</span></label>
                <input type="text" name="usuDireccion" id="direccionCompleta" class="form-control" placeholder="La dirección se completará aquí" readonly value="<?php echo $ciu ['usudireccion'];?>">
            </div>
            <p><b>NOTA: En caso de querer actualizar un dato deshabilitado, contactarse con un administrador.</p>
            <div class="col-md-12 text-center">
                <input type="submit" value="Actualizar" class="btn btn-success mt-4 px-4">
                <a href="../web/index.php" class="btn btn-danger mt-4 px-4 ms-2">Cancelar</a>
            </div>
        </div>
    </form>
    <?php
        }
    ?>
</div>

<script src="../web/assets/js/usuario/ciudadano.js"></script>