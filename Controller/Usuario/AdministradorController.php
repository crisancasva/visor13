<?php
     include_once '../model/Usuario/AdministradorModel.php';
     include_once '../model/Acceso/AutenticacionModel.php';
     class AdministradorController{
        

        public function getUpdateAdministrador(){
            $obj = new AdministradorModel();
            $objeto= new AutenticacionModel();
            $objeto->acceso();
            $objeto->verificarRolAdmin();
            $id = $_SESSION['usuid'];

            $sql = "SELECT * FROM tblusuario WHERE usuid= $id";
            $administrador = $obj->select($sql);

            $sql = "SELECT * FROM tblTipoDoc";
            $tipoDoc = $obj->select($sql);
            
            include_once '../view/Usuario/AdministradorUpdate.php';
            
        }

        public function postUpdateAdministrador(){
            $obj = new AdministradorModel();
            $objeto= new AutenticacionModel();
            $objeto->acceso();
            $objeto->verificarRolAdmin();
            $id = $_SESSION ['usuid'];
            $primerNombre = $_POST['usuPrimerNombre'];
            $segundoNombre = $_POST['usuSegundoNombre'];
            $primerApellido = $_POST['usuPrimerApellido'];
            $segundoApellido = $_POST['usuSegundoApellido'];
            $tipoDoc = $_POST['tDocCod'];
            $numDoc = $_POST['usuNumDoc'];
            $correo = $_POST['usuCorreo'];
            $telefono = $_POST['usuTelefono'];
            $direccion = $_POST['usuDireccion'];
            $clave = $_POST['usuClave'];
            $confiClave=$_POST['usuConfirmarClave'];


            
            if(empty($primerNombre) || empty($primerApellido) || empty($correo) || empty($telefono) ||empty($direccion) ||empty($tipoDoc) ||empty($numDoc)){
                echo json_encode(array(
                    "success" => false,
                    "message" => "Los campos con asteriscos (*) no pueden estar vacíos."
                ));
                exit();
            }

            // Verificar si el correo ya existe
            $sql = "SELECT COUNT(*) AS total FROM tblusuario WHERE usuCorreo = '$correo' AND usuid != $id";
            $result = $obj->select($sql);
        
            if ($result[0]['total'] > 0) {
                echo json_encode(array(
                    "success" => false,
                    "message" => "El correo electrónico ingresado ya está registrado."
                ));
                exit();
            }

                // Verificar si el número de documento ya existe
            $sql = "SELECT COUNT(*) AS total FROM tblusuario WHERE usunumdoc = '$numDoc' AND usuid !=$id";
            $result = $obj->select($sql);
        
            if ($result[0]['total'] > 0) {
                echo json_encode(array(
                    "success" => false,
                    "message" => "El número de documento ingresado ya está registrado."
                ));
                exit();
            }


            // validar estructura correo
            if (!preg_match('/^[^\s@]+@[^\s@]+\.[^\s@]+$/', $correo)) {
                echo json_encode(array(
                    "success" => false,
                    "message" => "El correo debe tener la estructura ejemplo@gmail.com"
                ));
                exit();
            }


            if(empty($clave)){
                $sql= "UPDATE tblusuario SET usuPrimerNombre='$primerNombre', usuSegundoNombre='$segundoNombre', usuPrimerApellido='$primerApellido', usuSegundoApellido='$segundoApellido', tDocCod='$tipoDoc', usuNumDoc='$numDoc',usuCorreo='$correo', usuTelefono='$telefono', usuDireccion='$direccion' WHERE usuid= $id";
            }else{
                if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[#\$%&*\/])[A-Za-z\d#$%&*\/]{8,}$/', $clave)) {
                    echo json_encode(array(
                        "success" => false,
                        "message" => "La contraseña no cumple con los requisitos de seguridad mínimos."
                    ));
                    exit();
                }

                if($clave!=$confiClave){
                    echo json_encode(array(
                        "success" => false,
                        "message" => "Ambas contraseñas deben ser iguales."
                    ));
                    exit();
    
                }
                
                $hash = md5($clave);
                $sql= "UPDATE tblusuario SET usuPrimerNombre='$primerNombre', usuSegundoNombre='$segundoNombre', usuPrimerApellido='$primerApellido', usuSegundoApellido='$segundoApellido', tDocCod='$tipoDoc', usuNumDoc='$numDoc',usuCorreo='$correo', usuTelefono='$telefono', usuDireccion='$direccion', usuClave= '$hash' WHERE usuid= $id";
            }
            
            $ejecutar = $obj->update($sql);
            if($ejecutar){
                // ACTUALIZAR VARIABLES DE SESIÓN
                $_SESSION['usunombre'] = $primerNombre;
                $_SESSION['usuapellido'] = $primerApellido;
                $_SESSION['usucorreo'] = $correo;
            
                echo json_encode(array(
                    "success" => true,
                    "message" => "Datos actualizados correctamente.",
                ));
                exit();
            }else {
                echo json_encode(array(
                    "success" => false,
                    "message" => "Los datos no se pudieron actualizar."
                ));
                exit();

            }
           
        }



        // CONSULTAR CUALQUIER USUARIO

        public function getAdministradorConsul(){

            $obj = new AdministradorModel();
            $objeto= new AutenticacionModel();
            $objeto->acceso();
            $objeto->verificarRolAdmin();
            $sql= "SELECT u.usuid , u.tdoccod, td.tdocdescripcion, u.usunumdoc, u.usuprimernombre, u.ususegundonombre,
                u.usuprimerapellido,
                u.ususegundoapellido,
                u.usucorreo,
                u.usudireccion,
                u.usutelefono,
                e.estdescripcion,
                r.rolnombre
            FROM tblusuario u
            INNER JOIN tblTipoDoc td ON u.tdoccod = td.tdoccod
            INNER JOIN tblestado e ON u.estcod = e.estcod
            INNER JOIN tblrol r ON u.rolcod = r.rolcod
            ORDER BY u.usuid ASC";
            $usuarios =$obj->select($sql);

            include_once '../view/Usuario/administradorConsultar.php';

        }


        // Editar usuario

        public function getAdminUpdateUsu(){
            $obj = new AdministradorModel();
            $objeto= new AutenticacionModel();
            $objeto->acceso();
            $objeto->verificarRolAdmin();
            $id = $_GET['usuid'];
            $sql = "SELECT * FROM tblusuario WHERE usuid= $id";
            $administrador = $obj->select($sql);

            $sql = "SELECT * FROM tblTipoDoc";
            $tipoDoc = $obj->select($sql);

            $sql = "SELECT * FROM tblrol";
            $roles = $obj->select($sql);

            $sql = "SELECT * FROM tblestado WHERE estcod IN (1, 2)";
            $estado = $obj->select($sql);
            
            include_once '../view/Usuario/AdminUpdateUsu.php';


        }

        public function postAdminUpdateUsu(){
            $obj = new AdministradorModel();
            $objeto= new AutenticacionModel();
            $objeto->acceso();
            $objeto->verificarRolAdmin();
            $usu_id = $_POST['usuid'];
            $primerNombre = $_POST['usuPrimerNombre'];
            $segundoNombre = $_POST['usuSegundoNombre'];
            $primerApellido = $_POST['usuPrimerApellido'];
            $segundoApellido = $_POST['usuSegundoApellido'];
            $tipoDoc = $_POST['tDocCod'];
            $numDoc = $_POST['usuNumDoc'];
            $correo = $_POST['usuCorreo'];
            $telefono = $_POST['usuTelefono'];
            $direccion = $_POST['usuDireccion'];
            $rol = $_POST['rolcod'];
            $estado=$_POST['estcod'];
            $clave = $_POST['usuClave'];
            $confiClave=$_POST['usuConfirmarClave'];

            if(empty($primerNombre) || empty($primerApellido) || empty($correo) || empty($telefono) ||empty($direccion) ||empty($tipoDoc) ||empty($numDoc) || empty($estado) || empty($rol)){
                echo json_encode(array(
                    "success" => false,
                    "message" => "Los campos con asteriscos (*) no pueden estar vacíos."
                ));
                exit();
            }

            // // Verificar si el correo ya existe
            $sql = "SELECT COUNT(*) AS total FROM tblusuario WHERE usuCorreo = '$correo' AND usuid != $usu_id";
            $result = $obj->select($sql);
        
            if ($result[0]['total'] > 0) {
                echo json_encode(array(
                    "success" => false,
                    "message" => "El correo electrónico ingresado ya está registrado."
                ));
                exit();
            }

            //  // Verificar si el numero de documento ya existe
            $sql = "SELECT COUNT(*) AS total FROM tblusuario WHERE usunumdoc = '$numDoc' AND usuid !=$usu_id";
            $result = $obj->select($sql);
        
            if ($result[0]['total'] > 0) {
                echo json_encode(array(
                    "success" => false,
                    "message" => "El número de documento ingresado ya está registrado."
                ));
                exit();
            }


            // validar estructura correo
            if (!preg_match('/^[^\s@]+@[^\s@]+\.[^\s@]+$/', $correo)) {
                echo json_encode(array(
                    "success" => false,
                    "message" => "El correo debe tener la estructura ejemplo@gmail.com"
                ));
                exit();
            }


            if(empty($clave)){
                $sql= "UPDATE tblusuario SET usuNumDoc='$numDoc', usuPrimerNombre='$primerNombre', usuSegundoNombre='$segundoNombre', usuPrimerApellido='$primerApellido', usuSegundoApellido='$segundoApellido', usuCorreo='$correo', usuDireccion='$direccion', usuTelefono='$telefono', estcod='$estado', tDocCod='$tipoDoc',  rolcod='$rol' WHERE usuid= $usu_id";

            }else{
                
                if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[#\$%&*\/])[A-Za-z\d#$%&*\/]{8,}$/', $clave)) {
                    echo json_encode(array(
                        "success" => false,
                        "message" => "La contraseña no cumple con los requisitos de seguridad mínimos."
                    ));
                    exit();
                }

                if($clave!=$confiClave){
                    echo json_encode(array(
                        "success" => false,
                        "message" => "Ambas contraseñas deben ser iguales."
                    ));
                    exit();
    
                }
                $hash = md5($clave);
                $sql= "UPDATE tblusuario SET  usuNumDoc='$numDoc', usuPrimerNombre='$primerNombre', usuSegundoNombre='$segundoNombre', usuPrimerApellido='$primerApellido', usuSegundoApellido='$segundoApellido', usuClave= '$hash', usuCorreo='$correo', usuDireccion='$direccion', usuTelefono='$telefono', estcod='$estado', tDocCod='$tipoDoc', rolcod='$rol' WHERE usuid= $usu_id";
            }
            
            $ejecutar = $obj->update($sql);
            if($ejecutar){
            
                echo json_encode(array(
                    "success" => true,
                    "message" => "Datos actualizados correctamente."
                ));
                exit();
            }else {
                echo json_encode(array(
                    "success" => false,
                    "message" => "Los datos no se pudieron actualizar."
                ));
                exit();

            }

        }


        public function getBotonesAdministrador(){
            $objeto= new AutenticacionModel();
            $objeto->acceso();
            $objeto->verificarRolAdmin();
            include_once '../view/Usuario/botonesAdministrador.php';
        }


     }
?>