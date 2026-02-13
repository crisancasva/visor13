<div class="container-fluid mt-2">
    <h2 class="text-center display-4" style="margin-top: 1px; margin-bottom: 15px;">Consultar Usuario</h2>
    <?php
        if(COUNT($usuarios) ==0){
    ?>
            <h4 class="text-center text-danger" >No hay usuarios registrados</h4>
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

    <div style="max-height: 400px; overflow: auto; border: 1px solid #ccc; margin-top: 40px;">
    <table id = "tablaConsultar" class="table table-striped table-hover" >
        <thead style="position: sticky; top: 0; background: #fff; z-index: 100;">
            <tr>
                <th>ID</th>
                <th>Tipo documento</th>
                <th>Numero documento</th>
                <th>Primer nombre</th>
                <th>Segundo nombre</th>
                <th>Primer apellido</th>
                <th>Segundo apellido</th>
                <th style="text-align: center">Correo</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th style="text-align: center">Rol</th>
                
            </tr>
        </thead>
            <tbody>
                <?php
                    foreach($usuarios as $usu){
                        echo "<tr>";
                        echo "<td>". $usu['usuid']."</td>";
                        echo "<td>". $usu['tdocdescripcion']."</td>";
                        echo "<td>". $usu['usunumdoc']."</td>";
                        echo "<td>". $usu['usuprimernombre']."</td>";
                        echo "<td>". $usu['ususegundonombre']."</td>";
                        echo "<td>". $usu['usuprimerapellido']."</td>";
                        echo "<td>". $usu['ususegundoapellido']."</td>";
                        echo "<td>". $usu['usucorreo']."</td>";
                        echo "<td>". $usu['usudireccion']."</td>";
                        echo "<td>". $usu['usutelefono']."</td>";
                        echo "<td>". $usu['rolnombre']."</td>";
                        echo "</tr>";
                    }
                ?>
                <tr id="filaSinResultados" style="display: none;">
                    <td colspan="11" class="text-center text-danger">Ningún usuario coincide con los criterios de búsqueda.</td>
                </tr>
            </tbody>      
        </table>
        <?php
        }
        ?>
    </div>
</div>
<script src="../web/assets/js/usuario/funcionarioConsultarUsu.js"></script>