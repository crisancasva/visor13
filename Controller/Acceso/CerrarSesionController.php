<?php

    class CerrarSesionController{

        public function postCerrarSesion(){

            if (isset($_SESSION)) {
                
                session_destroy();
                echo json_encode(array(
                    "success" => true,
                    "message" => "",
                    "redirectUrl" => 'index.php' 
                ));
                exit();
            } 
            
        }

    }
    
?>
    
