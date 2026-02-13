<?php
     include_once '../model/Usuario/CiudadanoModel.php';
     include_once '../model/Acceso/AutenticacionModel.php';
    class CiudadanoController{
        public function getRegistro(){
            $obj = new CiudadanoModel();
            $sql = "SELECT * FROM tblTipoDoc";
            $tipoDoc = $obj->select($sql); 
            include_once '../view/Usuario/registro.php';
        }

        public function postRegistro() {
            $obj = new CiudadanoModel();
        
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
            $hash = md5($clave);
            $confiClave=$_POST['usuConfirmarClave'];




            // Validar que los nombres y apellidos contengan solo letras y espacios
            $nombres = '/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/';

            if (!preg_match($nombres, $primerNombre) || 
                (!empty($segundoNombre) && !preg_match($nombres, $segundoNombre)) || 
                !preg_match($nombres, $primerApellido) || 
                (!empty($segundoApellido) && !preg_match($nombres, $segundoApellido))) {

                echo json_encode(array(
                    "success" => false,
                    "message" => "Los nombres y apellidos solo deben contener letras y espacios."
                ));
                exit();
            }

            if (empty($primerNombre) || empty($primerApellido) || empty($tipoDoc)|| empty($numDoc)|| empty($correo)|| empty($telefono)|| empty($direccion) || empty($clave) || empty($confiClave)){
                echo json_encode(array(
                    "success" => false,
                    "message" => "Todos los campos marcados con asterisco(*) son obligatorios."
                ));
                exit();
            }
        
            // Validar la contraseña con una expresión regular
            if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[#\$%&*\/])[A-Za-z\d#$%&*\/]{8,}$/', $clave)) {
                echo json_encode(array(
                    "success" => false,
                    "message" => "La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula, un número y un carácter especial."
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

            // vaidar estructura correo
            if (!preg_match('/^[^\s@]+@[^\s@]+\.[^\s@]+$/', $correo)) {
                echo json_encode(array(
                    "success" => false,
                    "message" => "El correo debe tener la estructura ejemplo@gmail.com"
                ));
                exit();
            }

            // Verificar si el correo ya existe
            $sql = "SELECT COUNT(*) AS total FROM tblusuario WHERE usuCorreo = '$correo'";
            $result = $obj->select($sql);
        
            if ($result[0]['total'] > 0) {
                echo json_encode(array(
                    "success" => false,
                    "message" => "El correo electrónico ingresado ya está registrado."
                ));
                exit();
            }

            
        
            // Verificar si el numero de documento ya existe
            $sql = "SELECT COUNT(*) AS total FROM tblusuario WHERE usunumdoc = '$numDoc'";
            $result = $obj->select($sql);
        
            if ($result[0]['total'] > 0) {
                echo json_encode(array(
                    "success" => false,
                    "message" => "El número de documento ingresado ya está registrado."
                ));
                exit();
            }
        
            // Insertar el nuevo usuario en la base de datos
            $sql = "INSERT INTO tblUsuario VALUES (DEFAULT, $numDoc, '$primerNombre', '$segundoNombre', '$primerApellido', '$segundoApellido', '$hash', '$correo','$direccion', $telefono, 2, $tipoDoc, 3)";
            $ejecutar = $obj->insert($sql);
        
            if ($ejecutar) {
                echo json_encode(array(
                    "success" => true,
                    "message" => "Usuario registrado correctamente.",
                    "redirectUrl" =>getUrl("Acceso","Acceso","getLogin")
                ));
                exit();
            } else {
                echo json_encode(array(
                    "success" => false,
                    "message" => "Hubo un problema al insertar el usuario."
                ));
                exit();
            }
        
            
        }

        
        public function getUpdateCiudadano(){
            $obj = new CiudadanoModel();
            $objeto= new AutenticacionModel();
            $objeto->acceso();
            $id = $_SESSION['usuid'];
            $sql = "SELECT * FROM tblUsuario WHERE usuid = $id";
            $ciudadano = $obj->select($sql);
            $sql = "SELECT * FROM tblTipoDoc";
            $tipoDoc = $obj->select($sql); 

            include_once '../view/Usuario/ciudadanoUpdate.php';

        }
        public function postUpdateCiudadano(){
            $obj = new CiudadanoModel();
            $objeto= new AutenticacionModel();
            $objeto->acceso();
            $id = $_SESSION['usuid'];
            $correo = $_POST['usuCorreo'];
            $clave =$_POST ['usuClave'];
            $direccion = $_POST['usuDireccion'];
            $telefono = $_POST['usuTelefono'];
            $confiClave=$_POST['usuConfirmarClave'];
            
            if($_SESSION['rolcod'] == 3){
                if(empty($correo) || empty($telefono) || empty($direccion)){
                    echo json_encode(array(
                        "success" => false,
                        "message" => "Los campos asteriscos (*) no pueden estar vacíos."
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
                // validar estructura correo
                if (!preg_match('/^[^\s@]+@[^\s@]+\.[^\s@]+$/', $correo)) {
                    echo json_encode(array(
                        "success" => false,
                        "message" => "El correo debe tener la estructura ejemplo@gmail.com"
                    ));
                    exit();
                }
                if(empty($clave)){
                    $sql = "UPDATE tblUsuario SET usuCorreo = '$correo', usuTelefono = '$telefono', usuDireccion ='$direccion' WHERE usuid = $id";
                }else{

                    if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[#\$%&*\/])[A-Za-z\d#$%&*\/]{8,}$/', $clave)) {
                        echo json_encode(array(
                            "success" => false,
                            "message" => "La contraseña debe cumplir con la seguridad minima"
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
                    $sql = "UPDATE tblUsuario SET usuCorreo = '$correo', usuTelefono = '$telefono', usuDireccion = '$direccion', usuClave ='$hash' WHERE usuid = $id";
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
            
            }else{
                echo json_encode(array(
                    "success" => false,
                    "message" => "Los datos no se pueden actualizar."
                ));
                exit();

            }
           
        }


        public function getBotonesCiudadano(){
            $objeto= new AutenticacionModel();
            $objeto->acceso();
            include_once '../View/Usuario/botonesCiudadano.php';
        }

        
     
    }


?>