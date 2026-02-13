<?php

include_once '../model/Acceso/AccesoModel.php';

class AccesoController{

    public function getLogin(){
        
        include_once '../view/Acceso/login.php';
    }
    public function postLogin(){
        $obj=new AccesoModel();
        $usuario=$_POST['usuario'];
        $clave=$_POST['usuClave'];
        if (empty($usuario) || empty($clave)) {
            echo json_encode(array(
                "success" => false,
                "message" => "Todos los campos son obligatorios."
            ));
            exit();
        }else{
            
            if (!preg_match('/^[a-zA-Z0-9_-]+@[a-zA-Z0-9]+\.[a-zA-Z]{2,}$/', $usuario)) {
                echo json_encode(array(
                    "success" => false,
                    "message" => "El correo debe tener la estructura ejemplo@gmail.com"
                ));
                exit();
            }

            $sql = "SELECT * FROM tblusuario WHERE usucorreo = '$usuario' AND estcod = 1";
            $estadoUsuario = $obj->select($sql);

            if (!empty($estadoUsuario)) {
                echo json_encode(array(
                    "success" => false,
                    "message" => "El usuario está bloqueado. Contacte al administrador."
                ));
                exit();
            }


            $sql = "SELECT usuintentos FROM tblusuario WHERE usucorreo='$usuario'";
            $resultado = $obj->select($sql);
    
            
            $intentos = $resultado[0]['usuintentos'];
            
            if ($intentos >= 3) {

                $sql = "UPDATE tblusuario SET estcod = 1, usuintentos = 0 WHERE usucorreo = '$usuario'";

                $obj->update($sql);

                echo json_encode(array(
                    "success" => false,
                    "message" => "El usuario ha sido bloqueado por intentos fallidos."
                ));
                exit();

                
            }else {
            
                $sql="SELECT * FROM tblusuario WHERE usucorreo='$usuario'";
                $usuarios =$obj->select($sql);
                session_start();
                if(!empty($usuarios)){
                    foreach($usuarios as $usu){
                        
                        if(md5($clave)===$usu['usuclave']){
                            $_SESSION['usuid']=$usu['usuid'];
                            $_SESSION['usunombre']=$usu['usuprimernombre'];
                            $_SESSION['usuapellido']=$usu['usuprimerapellido'];
                            $_SESSION['usucorreo']=$usu['usucorreo'];
                            $_SESSION['rolcod'] = $usu['rolcod'];
                            $_SESSION['autenticado']= true;
                            $sql = "UPDATE tblusuario SET usuintentos = 0 WHERE usucorreo='$usuario'";
                            $ejecutar=$obj->update($sql);


                            if($_SESSION['rolcod'] === 1){
                                echo json_encode(array(
                                    "success" => true,
                                    "message" => "BIENVENIDO A VISOR13",
                                    "redirectUrl" => "index.php"
                                ));
                                exit();

                            }else if($_SESSION['rolcod']=== 2){

                                echo json_encode(array(
                                    "success" => true,
                                    "message" => "BIENVENIDO A VISOR13",
                                    "redirectUrl" => "index.php"
                                ));
                                exit();

                            }else if($_SESSION['rolcod']=== 3){

                                echo json_encode(array(
                                    "success" => true,
                                    "message" => "BIENVENIDO A VISOR13",
                                    "redirectUrl" =>"index.php"
                                ));
                                exit();
                            }
                            
                        }else{
                                    
                            $sql = "UPDATE tblusuario SET usuintentos = usuintentos + 1 WHERE usucorreo='$usuario'";
                            $ejecutar=$obj->update($sql);

                            echo json_encode(array(
                                "success" => false,
                                "message" => "Contraseña Incorrecta."
                            ));
                            exit();
                        }
            
                    }
                }else{
                        
                    echo json_encode(array(
                        "success" => false,
                        "message" => "Usuario no registrado."
                    ));
                    exit();
                }
            }
        }
    }
}

?>