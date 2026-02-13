<?php
     include_once '../model/Usuario/FuncionarioModel.php';
     include_once '../model/Acceso/AutenticacionModel.php';

     class FuncionarioController{

        public function getUpdateFuncionario(){
            $obj = new FuncionarioModel();
            $objeto= new AutenticacionModel();
            $objeto->acceso();
            $objeto->verificarRolFunci();

            $id = $_SESSION['usuid'];

            $sql = "SELECT * FROM tblusuario WHERE usuid= $id";
            $funcionario = $obj->select($sql);

            $sql = "SELECT * FROM tblTipoDoc";
            $tipoDoc = $obj->select($sql);
            
            include_once '../view/Usuario/funcionarioUpdate.php';
            
          
        }

        public function postUpdateFuncionario(){
            $obj = new FuncionarioModel();
            $objeto= new AutenticacionModel();
            $objeto->acceso();
            $objeto->verificarRolFunci();
            $id = $_SESSION['usuid'];
            $primerNombre = $_POST['usuPrimerNombre'];
            $segundoNombre = $_POST['usuSegundoNombre'];
            $primerApellido = $_POST['usuPrimerApellido'];
            $segundoApellido = $_POST['usuSegundoApellido'];
            $correo = $_POST['usuCorreo'];
            $telefono = $_POST['usuTelefono'];
            $direccion = $_POST['usuDireccion'];
            $clave = $_POST['usuClave'];
            $confiClave=$_POST['usuConfirmarClave'];

            

            if(empty($primerNombre) || empty($primerApellido) || empty($correo) || empty($telefono) ||empty($direccion)){
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


            // validar estructura correo
            if (!preg_match('/^[^\s@]+@[^\s@]+\.[^\s@]+$/', $correo)) {
                echo json_encode(array(
                    "success" => false,
                    "message" => "El correo debe tener la estructura ejemplo@gmail.com"
                ));
                exit();
            }


            if(empty($clave)){
                $sql= "UPDATE tblusuario SET usuPrimerNombre='$primerNombre', usuSegundoNombre='$segundoNombre', usuPrimerApellido='$primerApellido', usuSegundoApellido='$segundoApellido', usuCorreo='$correo', usuTelefono='$telefono', usuDireccion='$direccion' WHERE usuid= $id";
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
                $sql= "UPDATE tblusuario SET usuPrimerNombre='$primerNombre', usuSegundoNombre='$segundoNombre', usuPrimerApellido='$primerApellido', usuSegundoApellido='$segundoApellido', usuCorreo='$correo', usuTelefono='$telefono', usuDireccion='$direccion', usuClave='$hash' WHERE usuid= $id";
            }
            
            
            $ejecutar = $obj->update($sql);
            if($ejecutar){
                // ACTUALIZAR VARIABLES DE SESION
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

        public function getBotonesFuncionario(){
            $objeto= new AutenticacionModel();
            $objeto->acceso();
            $objeto->verificarRolFunci();
            include_once '../view/Usuario/botonesFuncionario.php';
        }


        public function getUsuarios(){
            $obj = new FuncionarioModel();
            $objeto= new AutenticacionModel();
            $objeto->acceso();
            $objeto->verificarRolFunci();
            $sql = "SELECT u.usuid, u.tdoccod, td.tdocdescripcion, u.usunumdoc, u.usuprimernombre,u.ususegundonombre, u.usuprimerapellido, u.ususegundoapellido, u.usucorreo, u.usudireccion, u.usutelefono, r.rolnombre
            FROM tblusuario u
            INNER JOIN tblTipoDoc td ON u.tdoccod = td.tdoccod
            INNER JOIN tblrol r ON u.rolcod = r.rolcod 
            ORDER BY u.usuid ASC";
            $usuarios =$obj->select($sql);
            $sql = "SELECT * FROM tblRol";
            $roles = $obj->select($sql);

            include_once '../view/Usuario/funcionarioConsultarUsu.php';

        }

    }
?>