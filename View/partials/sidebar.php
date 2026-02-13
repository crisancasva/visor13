<div class="sidebar" data-background-color="white" >
    <div class="sidebar-logo" >
        <!-- Logo Header -->
        <div class="logo-header bg-light" data-background-color="white">
            <div class="logo-header" >
                <div class="d-flex flex-column align-items-center ms-5">
                    <a href="index.php" class="logo ">
                        <img src="assets/img/kaiadmin/logoFinalSinFondo.png" alt="navbar brand" class="navbar-brand" height="90">
                    </a>

                </div>

                <div class="nav-toggle" style="display: flex; justify-content: flex-end;">
                  
                    <button class="btn toggle-sidebar" style="background:#FFFFFF !important; border: none; margin-left: right;">

                        <i class="gg-menu-right" style="--ggs:1; color:#4E74A6 !important;"></i>
                    </button>
                </div>




            </div>
        </div>
        <!-- End Logo Header -->	
    </div>	


    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item active">
                    
                    <li class="nav-item">
                        <a href="../web/index.php">
                            <i class="fas fa-home"></i>
                            <p>Inicio</p>
                        </a>
                    </li>
                </li>
                <?php
                    if($_SESSION['autenticado']==false){

                ?>
                <li class="nav-item">
                    <a href="#" onclick="window.location.href='<?php echo getUrl('Acceso', 'Acceso', 'getLogin'); ?>'">
                        <i class="fas fa-door-open"></i>
                        <p>Iniciar sesión</p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="#" onclick="window.location.href='<?php echo getUrl('Usuario', 'Ciudadano', 'getRegistro'); ?>'" >
                        <i class="fas fa-user-plus"></i>
                        <p>Registrarse</p>
                    </a>
                </li>
                <?php
                    }
                ?>

              <?php
                   
                if($_SESSION['rolcod']===1){
              ?>
                <li class="nav-item">
                    <a href="#" onclick="window.location.href='<?php echo getUrl('Usuario', 'Administrador', 'getAdministradorConsul'); ?>'" >
                        <i class="fas fa-search"></i>
                        <p>Consultar usuarios</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#forms" onclick="window.location.href='<?php echo getUrl('Usuario', 'Administrador', 'getBotonesAdministrador'); ?>'" >
                        <i class="fas fa-folder-open"></i>
                        <p>Consultar solicitudes</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#forms" onclick="window.location.href='<?php echo getUrl('Solicitud', 'ReporteAccidente', 'getConsulAccidente'); ?>'" >
                        <i class="fas fa-motorcycle"></i>
                        <p>Consultar accidentes</p>
                    </a>
                </li>

                <?php
                    }
                ?>


                <?php
                if($_SESSION['rolcod']===2){
                ?>

                <li class="nav-item">
                    <a href="#forms" onclick="window.location.href='<?php echo getUrl('Usuario', 'Funcionario', 'getUsuarios'); ?>'" >
                        <i class="fas fa-search"></i>
                        <p>Consultar usuarios</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#forms" onclick="window.location.href='<?php echo getUrl('Usuario', 'Funcionario', 'getBotonesFuncionario'); ?>'" >
                        <i class="	fas fa-folder-open"></i>
                        <p>Consultar solicitudes</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#forms" onclick="window.location.href='<?php echo getUrl('Solicitud', 'ReporteAccidente', 'getConsulAccidente'); ?>'" >
                        <i class="fas fa-motorcycle"></i>
                        <p>Consultar accidentes</p>
                    </a>
                </li>
                
                <?php
                    }
                ?>

                <?php
                if($_SESSION['rolcod']===3){
                ?>

                <li class="nav-item">
                    <a href="#forms" onclick="window.location.href='<?php echo getUrl('Usuario', 'Ciudadano', 'getBotonesCiudadano'); ?>'" >
                        <i class="	fas fa-folder-open"></i>
                        <p>Consultar mis solicitudes</p>
                    </a>
                </li>
                <?php
                    }
                ?>
                
                
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Componentes</h4>
                </li>   
                
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#forms" onclick="window.location.href='<?php echo getUrl('Solicitud', 'ReporteAccidente', 'getReporteAccidente'); ?>'">
                        <i class="fas fa-car-crash"></i>
                        <p>Reportar Accidente</p>
                    </a>
                </li>


                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#submenu">
                        <i class="fas fa-pen-square"></i>
                        <p>Solicitud</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="submenu">
                        <ul class="nav nav-collapse">
                            <li>
                                <a data-bs-toggle="collapse" href="#subnav1">
                                    <span class="sub-item">Nuevo</span>
                                    <span class="caret"></span>
                                </a>
                                <div class="collapse" id="subnav1">
                                    <ul class="nav nav-collapse subnav">
                                        <li>
                                            <a href="#" onclick="window.location.href='<?php echo getUrl('Solicitud', 'NuevaSenal', 'getNuevaSenal'); ?>'">
                                                <span class="sub-item">Nueva señalización vial</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" onclick="window.location.href='<?php echo getUrl('Solicitud', 'NuevoReductor', 'getNuevoReductor'); ?>'">
                                                <span class="sub-item">Nuevo reductor de velocidad</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a data-bs-toggle="collapse" href="#subnav2">
                                    <span class="sub-item">Reparacion</span>
                                    <span class="caret"></span>
                                </a>
                                <div class="collapse" id="subnav2">
                                    <ul class="nav nav-collapse subnav">
                                        <li>
                                            <a href="#" onclick="window.location.href='<?php echo getUrl('Solicitud', 'SenalVialMalEstado', 'getSenalVialMalEstado'); ?>'">
                                                <span class="sub-item">Señalizaciones viales en mal estado</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" onclick="window.location.href='<?php echo getUrl('Solicitud', 'ReductorMalEstado', 'getReductorMalEstado'); ?>'">
                                                <span class="sub-item">Reductores de velocidad en mal estado</span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="#" onclick="window.location.href='<?php echo getUrl('Solicitud', 'MallaVialMalEstado', 'getMallaVialMalEstado'); ?>'">
                                                <span class="sub-item">Vía pública en mal estado</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
               
           
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#forms" onclick="window.location.href='<?php echo getUrl('Solicitud', 'Pqrsf', 'getPqrsf'); ?>'">
                        <i class="fas fa-envelope"></i>
                        <p>PQRSF</p>
                    </a>
                </li>
            
                <li class="nav-item">
                    <a href="#forms" onclick="window.location.href='<?php echo getUrl('Reportes', 'Reportes', 'getReportes'); ?>'" >
                        <i class="fas fa-file"></i>
                        <p>Reportes</p>
                    </a>
                </li>

                <li class="nav-item">
                <a data-bs-toggle="collapse" href="#forms" onclick="window.location.href='<?php echo getUrl('Manuales', 'Manuales', 'getDescargas'); ?>'">                        <i class="fas fa-book"></i>
                        <p>Manuales</p>
                    </a>
                </li>
                
            </ul>
        </div>
    </div>
</div>