<?php


class AutenticacionModel{

    public function acceso(){

        if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) {
            redirect("index.php?auth=false");
            exit;
        }
    }

    public function verificarRolAdmin(){
        if($_SESSION['rolcod'] != 1){
            redirect("index.php?auth=false");
            exit;
        }
    }
    public function verificarRolFunci(){
        if($_SESSION['rolcod'] != 2){
            redirect("index.php?auth=false");
            exit;
        }
    }

    public function verificarRolAdminFunci() {
        $rolPermitido = array(1,2);
        if(!in_array($_SESSION['rolcod'], $rolPermitido)){
            redirect("index.php?auth=false");
            exit;
        }
    }
}


?>