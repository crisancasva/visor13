<?php

    include_once '../model/Solicitud/PqrsfModel.php';
    include_once '../model/Acceso/AutenticacionModel.php';

    class PqrsfController{
        public function getPqrsf(){
            $obj= new PqrsfModel();
            $sql = "SELECT * FROM tbltipopqrsf";
            $pqrsf = $obj->select($sql);
            include_once '../view/Solicitud/pqrsf.php';


        }

        public function postPqrsf(){
            session_start();
        
            $obj= new PqrsfModel();
            $reseña=$_POST['reseña'];
            $tipopqrsf=$_POST['tipopqrsf'];
            $usuId=$_SESSION['usuid'];

            // Verificamos si marco el checkbox de anonimo
            $esAnonimo = isset($_POST['anonimo']) && $_POST['anonimo'] == "1";

            // Si no es anonimo y hay un usuario logueado, capturamos el ID
            $usuId = (!$esAnonimo && isset($_SESSION['usuid'])) ? $_SESSION['usuid'] : "NULL";


            if(empty($reseña) || empty($tipopqrsf)){
                echo json_encode(array(
                    "success" => false,
                    "message" => "Todos los campos marcados con asterisco (*) son obligatorios"
                ));
            }


            // Aqui usa el valor NULL si es anonimo, o el id real si está logueado
            $sql = "INSERT INTO tblpqrsf VALUES (DEFAULT, '$reseña', DEFAULT, $tipopqrsf, $usuId)";                
                
            $ejecutar=$obj->insert($sql);

            if($ejecutar){
                echo json_encode(array(
                    "success" => true,
                    "message" => ""
                ));
            }else{
                echo json_encode(array(
                    "success" => false,
                    "message" => "No se puedo enviar la solicitud."
                ));
            }
        }



        public function getPqrsfConsul(){
            $obj= new PqrsfModel();
            $objeto= new AutenticacionModel();
            $objeto->acceso();

            if($_SESSION['rolcod']===3){
                $usuid = $_SESSION['usuid'];
                $sql="SELECT p.*, t.tpqrsfDescripcion, u.usuid
                FROM tblPqrsf p
                JOIN tblTipoPqrsf t ON p.tPqrsfCod = t.tPqrsfCod
                LEFT JOIN tblUsuario u ON p.usuId = u.usuId
                WHERE p.usuid = $usuid
                ORDER BY p.pqrsfcod ASC";

                $pqrsf =$obj->select($sql);
            }
            if($_SESSION['rolcod']===2 || $_SESSION['rolcod']===1){

                $sql="SELECT p.*, t.tpqrsfDescripcion,
                CASE WHEN u.usuPrimerNombre IS NULL THEN 'Anónimo'
                ELSE CONCAT(u.usuPrimerNombre, ' ', u.usuSegundoNombre, ' ', u.usuPrimerApellido, ' ', u.usuSegundoApellido)
                END AS usunombrecompleto, u.usuCorreo, u.usuTelefono, r.rolNombre AS rol 
                FROM tblPqrsf p
                JOIN tblTipoPqrsf t ON p.tPqrsfCod = t.tPqrsfCod
                LEFT JOIN tblUsuario u ON p.usuId = u.usuId
                LEFT JOIN tblRol r ON u.rolCod = r.rolCod
                ORDER BY p.pqrsfcod ASC"; 
                $pqrsf =$obj->select($sql);
            }


            include_once '../View/Solicitud/pqrsfConsultar.php';


        }


    }
?>