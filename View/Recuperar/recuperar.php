<div class="container mt-1">
    <h3 class="display-4 text-center mt-0 mb-5" style="font-family: 'Poppins', sans-serif;">Recuperar Contraseña</h3>
    
    <form id="recuperar" action="<?php echo getUrl('Recuperar', 'Recuperar', 'postRecuperar', false, 'ajax'); ?>" method="post" enctype="multipart/form-data">
        <div class="row g-3">
            <div class="col-md-4 mx-auto text-cente">
                <label>Correo electrónico<span class="text-danger">*</span></label>
                <input type="email" name="correo" class="form-control" placeholder="Correo electronico" required>
            </div>
        </div>
        <div class="col-md-12 text-center">
            <input type="submit" value="Enviar" class="btn btn-success mt-4 px-4">
            <a href="<?php echo getUrl('Acceso', 'Acceso', 'getLogin'); ?>" class="btn btn-danger mt-4 px-4 ms-2">Cancelar</a>
        </div>
    </form>
</div>

<script src="../web/assets/js/Recuperar/recuperar.js"></script>