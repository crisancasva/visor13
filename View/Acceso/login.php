
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-6 col-sm-8">
        
            <div class="card shadow-lg border-0">   
                <div class="card-body p-3">
                    <div class="d-flex flex-column align-items-center ms-3">
                        <img src="assets/img/kaiadmin/logoFinalSinFondo.png" alt="navbar brand" class="navbar-brand" height="150">
                    </div>
                    <form id="login-user" action="<?php echo getUrl("Acceso","Acceso","postLogin", false , 'ajax') ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group mb-1">
                            <label for="usuario">
                                <i class="fas fa-user"></i> Correo:
                            </label>
                            <input type="email" class="form-control" name="usuario" id="usuario" placeholder="Ingrese su correo" required>
                        </div>
                        <div class="form-group mb-3 position-relative">
                            <label for="usuClave">
                                <i class="fas fa-lock"></i> Contraseña:
                            </label>
                            <div class="position-relative">
                                <input type="password" class="form-control" name="usuClave" id="usuClave" placeholder="Ingrese su contraseña" required>
                                <i id="toggleIcon" class="fas fa-eye position-absolute"
                                style="right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer;"
                                onclick="togglePassword()">
                                </i>
                            </div>
                        </div>

                        <?php if (isset($_GET["mensaje"])) { ?>
                            <div class="alert alert-danger mt-3">
                                <?php echo $_GET["mensaje"] ?>
                            </div>
                        <?php } ?>
                        <button type="submit" class='btn' style='background:#4E74A6 !important; color:white;'>
                            <i class="fas fa-sign-in-alt"></i> Ingresar
                        </button>
                        <a href="<?php echo getUrl('Recuperar', 'Recuperar', 'getRecuperar'); ?>" class="ms-3">
                        ¿Has olvidado tu contraseña?
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="../web/assets/js/Acceso/login.js"></script>

