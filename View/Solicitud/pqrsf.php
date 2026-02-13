<div class="container mt-1">
    <h3 class="display-4 text-center mt-0 mb-5" style="font-family: 'Poppins', sans-serif;">PQRSF</h3>
    <p class="text-center">Los campos marcados con un asterisco (<span class="text-danger">*</span>) son obligatorios.</p>

    <form id="pqrsf" action="<?php echo getUrl('Solicitud', 'Pqrsf', 'postPqrsf', false, 'ajax'); ?>" method="post" enctype="multipart/form-data">
            
        <div class="col-md-6 mx-auto">
            <label class="form-label">Tipo de PQRSF<span class="text-danger">*</span></label>
            <select name="tipopqrsf" class="form-control" required>
                <option value="">Seleccione...</option>
                <?php
                foreach($pqrsf as $pqr){
                    echo "<option value = '".$pqr['tpqrsfcod']."'>".$pqr['tpqrsfdescripcion']."</option>";
                }
                ?>
            </select>
            
        </div>
        
        <div class="col-md-6 mx-auto mt-4">

            <label class="form-label">Descripción<span class="text-danger">*</span></label>
            <textarea name="reseña" class="form-control" placeholder="Escribe una descripción detallada" rows="5" style="resize: none;" required></textarea>

        </div>

        <div class="col-md-6 mx-auto">

            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="anonimo" name="anonimo" value="1">
                <label class="form-check-label" for="anonimo">
                    Enviar como anónimo
                </label>
            </div>

        </div >

        <div class="col-12 text-center">
            <input type="submit" value="Enviar" class="btn btn-success mt-4 px-4">
            <a href="../web/index.php" class="btn btn-danger mt-4 px-4 ms-2">Cancelar</a>
        </div>

        <div id="advertenciaAnonimo" class="alert alert-warning mt-2 d-none">
            <strong>Advertencia:</strong> Si registras una solicitud Anónima no podrás recibir respuesta de la misma, dado que no contamos con tu información personal y no podremos contactarte.
        </div>
    </form>
</div>

<script>
    const usuarioLogueado = <?php echo isset($_SESSION['usuid']) ? 'true' : 'false'; ?>;
</script>


<script src="../web/assets/js/solicitud/Pqrsf.js"></script>
