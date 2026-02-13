<div class="container mt-3">
    <?php
        if($_SESSION['rolcod']===2 || $_SESSION['rolcod']===1){
    ?>
    <h2 class="text-center display-4" style="margin-top: 5px; margin-bottom: 15px;">Consultar PQRSF</h2>
    <?php
        }else{
    ?>
    <h2 class="text-center display-4" style="margin-top: 5px; margin-bottom: 15px;">Mis PQRSF</h2>
    <?php
        }
    ?>

    <?php
        if(COUNT($pqrsf) ==0){
    ?>
            <h4 class="text-center text-danger" >No hay pqrsf registrados</h4>
    <?php
        }else{
    ?>
   <div class="row mb-3">
        <div class="col-md-4 mt-5">
            <input type="text" id="filtroBuscar" class="form-control" placeholder="Buscar...">
        </div>

        <div class="col-md-2 mt-5">
            <button class="btn btn-secondary" onclick="limpiarFiltros()">Limpiar filtros</button>
        </div>

    </div>

    <p><b>Se puede filtrar por cualquier campo disponible en el listado.</b></p>
    <div style="max-height: 400px; overflow-y: auto; border: 1px solid #ccc;" >
    
        <table id="tablaConsultar" class="table table-striped">
        
            <thead style="position: sticky; top: 0; background: #fff; z-index: 100;">
    
                <tr>
                    <?php
                        if($_SESSION['rolcod']===2 ||$_SESSION['rolcod']===1 ){
                    ?>
                    <th>ID</th>
                    <?php
                        }
                    ?>
                    <th>Fecha</th>
                    <th>Tipo PQRSF</th>
                    <th>Descripción</th>
                    <?php
                        if($_SESSION['rolcod']===2 ||$_SESSION['rolcod']===1 ){
                    ?>
                    <th>Usuario</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th style="text-align: center">Rol</th>
                    <?php
                        }
                    ?>
                    </tr>
            </thead>
            <tbody>
                <?php
                    foreach($pqrsf as $pq){
                        echo "<tr>";
                        if($_SESSION['rolcod']===2 ||$_SESSION['rolcod']===1 ){
                             echo "<td>". $pq['pqrsfcod'] ."</td>";
                        }
                        echo "<td>". $pq['pqrsffecha'] ."</td>"; 
                        echo "<td>". $pq['tpqrsfdescripcion'] ."</td>"; 
                        echo "<td>". $pq['pqrsfdescripcion'] ."</td>"; 

                        if($_SESSION['rolcod']===2 ||$_SESSION['rolcod']===1 ){
                             echo "<td>". $pq['usunombrecompleto'] ."</td>";
                             echo "<td>". $pq['usucorreo'] ."</td>";
                             echo "<td>". $pq['usutelefono'] ."</td>";
                             echo "<td style='text-align: center'>". $pq['rol'] ."</td>"; 
                        }
                        echo "</tr>";
                    }
                ?>
                <tr id="filaSinResultados" style="display: none;">
                    <td colspan="7" class="text-center text-danger">Ningún resultado coincide con los criterios de búsqueda ingresados.</td>
                </tr>
            </tbody>
        </table>
        <?php
        }
        ?>
    </div>
    <div class="col-md-12 text-end">
        <?php
            if($_SESSION ['rolcod']===2){
        ?>

            <a onclick="window.location.href='<?php echo getUrl('Usuario', 'Funcionario', 'getBotonesFuncionario'); ?>'"  class="btn btn-danger mt-4 px-4 ms-2">Volver</a>
        <?php
            } elseif($_SESSION['rolcod']===3){
        ?>
            <a onclick="window.location.href='<?php echo getUrl('Usuario', 'Ciudadano', 'getBotonesCiudadano'); ?>'"  class="btn btn-danger mt-4 px-4 ms-2">Volver</a>
        <?php   
            }else {
            
        ?>  
            <a onclick="window.location.href='<?php echo getUrl('Usuario', 'Administrador', 'getBotonesAdministrador'); ?>'"  class="btn btn-danger mt-4 px-4 ms-2">Volver</a>
        <?php
            }
        ?> 
    </div>
</div>



<script src="../web/assets/js/solicitud/pqrsfConsultar.js"></script>

