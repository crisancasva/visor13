<div class="container-fluid mt-2">
    <?php
        if($_SESSION['rolcod']===2 || $_SESSION['rolcod']===1){
    ?>
    <h2 class="text-center display-4" style="margin-top: 5px; margin-bottom: 15px;">Solicitudes de reductores en mal estado</h2>
    <?php
        }else{
    ?>
    <h2 class="text-center display-4" style="margin-top: 5px; margin-bottom: 15px;">Mis solicitudes de reductores en mal estado</h2>
    <?php
        }
    ?>


    <?php
        if(COUNT($redumal) ==0){
    ?>
            <h4 class="text-center text-danger" >No hay solicitudes registradas</h4>
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
    <div style="max-height: 400px; overflow: auto; border: 1px solid #ccc; margin-top: 20px;">
    <table id = "tablaConsultar" class="table table-striped table-hover">
        <thead style="position: sticky; top: 0; background: #fff; z-index: 100;">
            <tr>
                <?php
                    if($_SESSION['rolcod']===2 || $_SESSION['rolcod']===1){
                ?>
                <th>Codigo</th>
                <?php
                    }
                ?>
                <th>Descripción</th>
                <th>Imagen</th>
                <th>Dirección</th>
                <th>Fecha</th>  
                <th>Observación</th>     
                <th>Estado</th>
                <?php
                    if($_SESSION['rolcod']===2 || $_SESSION['rolcod']===1){
                ?>
                <th>Usuario</th>
                <?php
                    }
                ?>
                <th>Daño</th>
                <th>Reductor</th>
                <?php
                    if($_SESSION['rolcod']===2 || $_SESSION['rolcod']===1){
                ?>
                <th>Editar</th>
                <?php
                    }
                ?>

            </tr>
        </thead>
            <tbody>
                <?php
                    foreach($redumal as $redu){
                        echo "<tr>";
                        if($_SESSION['rolcod']===2 || $_SESSION['rolcod']===1){
                            echo "<td>". $redu['rmecod']."</td>";
                        }
                        echo "<td>". $redu['rmedescripcion']."</td>";
                        echo "<td><img src='". $redu['rmeimagen']."'width='60px'></td>";
                        echo "<td>". $redu['rmedireccion']."</td>";
                        echo "<td>". $redu['rmefecha']."</td>";
                        echo "<td>". $redu['rmeobservacion']."</td>";
                        echo "<td>". $redu['estdescripcion']."</td>";
                        if($_SESSION['rolcod']===2 || $_SESSION['rolcod']===1){
                            echo "<td>". $redu['usunombrecompleto']."</td>";
                        }
                        echo "<td>". $redu['tdanodescripcion']."</td>";
                        echo "<td>". $redu['redudescripcion']."</td>";
                        if($_SESSION['rolcod']===2 || $_SESSION['rolcod']===1){
                            echo "<td><button class='btn' style='background:#4E74A6 !important; color:white;' onclick=\"window.location.href='" . getUrl('Solicitud', 'ReductorMalEstado', 'getUpdateReduMalEstado', array('rmecod' => $redu['rmecod'])) . "'\">Editar</button></td>";
                        }
                        echo "</tr>";
                    }
                ?>
                <tr id="filaSinResultados" style="display: none;">
                    <td colspan="11" class="text-center text-danger">Ningún resultado coincide con los criterios de búsqueda ingresados.</td>
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
<script src="../web/assets/js/solicitud/reductorMalEstadoConsul.js"></script>