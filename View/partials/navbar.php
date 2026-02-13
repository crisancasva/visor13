<div class="main-header-logo" >
    <!-- Logo Header -->
    <div class="logo-header" data-background-color="white">

        <a href="index.html" class="logo">
            <img src="assets/img/kaiadmin/logoFinalSinFondo.png" alt="navbar brand" class="navbar-brand" height="40">
        </a>
        <!-- <div class="nav-toggle">
            <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
            </button>
            <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
            </button>
        </div>
        <button class="topbar-toggler more">
            <i class="gg-more-vertical-alt"></i>
        </button> -->

    </div>
    <!-- End Logo Header -->
</div>
<!-- Navbar Header -->


			
<!-- Navbar Header -->
<nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom" data-background-color="blue" style ="background:#4E74A6 !important">

    <div class="container-fluid" >

        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
            
            <li class="nav-item topbar-user dropdown hidden-caret">
                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                    <div class="avatar-sm"></div>
                    <?php
                        if($_SESSION['autenticado']==true){

                    ?>
                        <span class="profile-username">
                            <span class="op-7">Mi perfil,</span> 
                            <span class="fw-bold">
                                <?php 
                                if(isset($_SESSION['usunombre']) && isset($_SESSION['usuapellido'])) {
                                    echo $_SESSION['usunombre'] . " " . $_SESSION['usuapellido'];
                                } 
                                ?>
                            </span>
                        </span>
                    <?php
                        }else{
                    ?>
                        <span class="profile-username">
                                <span class="op-7">Hola,</span> 
                                <span class="fw-bold">
                                    <?php 
                                        echo "Invitado";
                                    ?>
                                </span>
                        </span>
                    <?php
                        }
                    ?>


                </a>
                <ul class="dropdown-menu dropdown-user animated fadeIn">
                    <div class="dropdown-user-scroll scrollbar-outer">
                        <li>
                            <div class="user-box">
                                <div class="avatar-lg"><img src="assets/img/fotoperfil.png" alt="image profile" class="avatar-img rounded"></div>
                                <div class="u-text">
                                    <?php
                                        // Iniciar la sesión
                                        session_start();

                                        // Validar si el nombre del usuario está disponible en la sesión
                                        if (isset($_SESSION['usunombre']) && isset($_SESSION['usuapellido'])) {
                                            echo '<h4>' . htmlspecialchars($_SESSION['usunombre'] . ' ' . $_SESSION['usuapellido'], ENT_QUOTES, 'UTF-8') . '</h4>';                                    } else {
                                            echo '<h4>Invitado</h4>';
                                        }
                                    ?>   
                                    <?php
                                        // Validar si el correo del usuario está disponible en la sesión
                                        if (isset($_SESSION['usucorreo'])) {
                                            echo '<p class="text-muted">' . htmlspecialchars($_SESSION['usucorreo'], ENT_QUOTES, 'UTF-8') . '</p>';
                                        } else {
                                            echo '<p class="text-muted">Invitado</p>';
                                        }
                                    ?>
                                </div>
                            </div>
                        </li>
                        <?php
                            if($_SESSION['autenticado']==true){

                        ?>
                        <li>
                            <div class="dropdown-divider"></div>
                            <?php
                   
                                if($_SESSION['rolcod']===3){
                            ?>
                            <a class="dropdown-item" href="#" onclick="window.location.href='<?php echo getUrl('Usuario', 'Ciudadano', 'getUpdateCiudadano'); ?>'">Actulizar mis datos</a>
                            <?php
                                }
                            ?>

                            
                            <?php
                   
                                if($_SESSION['rolcod']===2){
                            ?>
                            <a class="dropdown-item" href="#" onclick="window.location.href='<?php echo getUrl('Usuario', 'Funcionario', 'getUpdateFuncionario'); ?>'">Actulizar mis datos</a>
                            <?php
                                }
                            ?>

                            <?php
                   
                                if($_SESSION['rolcod']===1){
                            ?>
                            <a class="dropdown-item" href="#" onclick="window.location.href='<?php echo getUrl('Usuario', 'Administrador', 'getUpdateAdministrador'); ?>'">Actulizar mis datos</a>
                            <?php
                                }
                            ?>
                            <div class="dropdown-divider"></div>
                            <a href="#forms" id="cerrarSesion" class="dropdown-item" data-url='<?php echo getUrl('Acceso', 'CerrarSesion', 'postCerrarSesion',false,'ajax'); ?>'>Cerrar sesión</a>
                        </li>
                        <?php
                            }
                        ?>
                    </div>
                </ul>
            </li>
        </ul>
    </div>
</nav>
<script src="../web/assets/js/Acceso/cerrarSesion.js"></script>
