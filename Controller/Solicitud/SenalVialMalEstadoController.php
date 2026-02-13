<?php
     include_once '../model/Solicitud/SenalVialMalEstadoModel.php';
     include_once '../model/Acceso/AutenticacionModel.php';
    
    class SenalVialMalEstadoController{
        public function getSenalVialMalEstado(){
            $objeto= new AutenticacionModel();
            $objeto->acceso();
            $obj = new SenalVialMalEstadoModel();
            $sql = "SELECT * FROM tblOrientacion";
            $orientacion = $obj->select($sql);
            $sql = "SELECT tdanocod, tdanodescripcion FROM tbltipodano WHERE tdanocod NOT IN (4, 5, 6)";
            $tipoDano = $obj->select($sql);


           include_once '../view/Solicitud/senalVialMalEstado.php';
        }

        public function postSenalVialMalEstado(){
            $obj = new SenalVialMalEstadoModel();
            $objeto= new AutenticacionModel();
            $objeto->acceso();
            $descripcion = $_POST['smeDescripcion'];
            $imagen = $_FILES['smeImagen']['name'];
            $ruta = "../web/assets/img/$imagen";
            move_uploaded_file($_FILES['smeImagen']['tmp_name'],$ruta);
            $direccion = $_POST['smeDireccion'];
            $usuId =  $_SESSION['usuid'];
            $senal = $_POST['sencod'];
            $dano = $_POST['tdanocod'];
            $orientacion = $_POST['orientcod'];
            $map_pt[0] =$_POST['x'];
            $map_pt[1] =$_POST['y'];
            $geom = "ST_SetSRID(ST_GeomFromText('POINT({$map_pt[0]} {$map_pt[1]})'), 4326)";

            
            
            if(empty($descripcion) || empty($imagen) || empty($ruta) || empty($direccion) || empty($usuId) || empty($senal) || empty($dano) || empty($orientacion) ){
                echo json_encode(array(
                    "success" => false,
                    "message" => "Todos los campos marcados con asterisco (*) son obligatorios"
                ));
            }
            $extension= strtolower(pathinfo($_FILES['smeImagen']['name'], PATHINFO_EXTENSION));
            $permitidos = array("jpg", "jpeg", "png");
            $tamanoMaximo = 5 * 1024 * 1024;

            if (!in_array($extension, $permitidos)) {
                 echo json_encode(array(
                    "success" => false,
                    "message" => "Formato de imagen no permitido. Solo JPG, JPEG y PNG."
                    
                ));
            }
            if ($_FILES['smeImagen']['size'] > $tamanoMaximo) {
                echo json_encode(array(
                    "success" => false,
                    "message" => "El tamaño de la imagen supera el límite de 5MB."
                    
                ));

            }
            $sql = "INSERT INTO tblSenalizacionesMalEstado VALUES (DEFAULT, '$descripcion' ,'$ruta' ,'$direccion' ,DEFAULT, null , $usuId , 3 , $senal , $dano, $orientacion, $geom)";

            $ejecutar=$obj->insert($sql);

            if($ejecutar){
                echo json_encode(array(
                    "success" => true,
                    "message" => "",
                    "redirectUrl" => "index.php"
                ));
                exit();
            }else{
                echo json_encode(array(
                    "success" => false,
                    "message" => "No se puedo enviar la solicitud."
                ));
                exit();
            }

        }
        public function getCategoria(){
            $obj = new SenalVialMalEstadoModel();
            $objeto= new AutenticacionModel();
            $objeto->acceso();
            $csencod = $_POST['csencod'];
            $sql = "SELECT c.csencod, c.cSenDescripcion FROM tblSenal s INNER JOIN tblCateSenal c ON s.cSenCod = c.cSenCod WHERE s.senCod = $csencod";
            $categoria=$obj->select($sql);
            
            foreach($categoria as $cate){
                echo "<option value='".$cate['csencod']."'>".$cate['csendescripcion']."</option>";
            }
        }
      
        public function getSenal(){
            $obj = new SenalVialMalEstadoModel();
            $objeto= new AutenticacionModel();
            $objeto->acceso();
            $orien = $_POST['orien'];
            $sql = "SELECT tbls.sencod, tbls.sendescripcion FROM tblorientsenal tblo INNER JOIN tblsenal tbls ON tblo.sencod=tbls.sencod WHERE orientcod=$orien";
            $senal=$obj->select($sql);

            echo "<option value=''>Seleccione...</option>";
            foreach($senal as $sen){
                echo "<option value='".$sen['sencod']."'>".$sen['sendescripcion']."</option>";
            }
        }



        public function getSenalMalEstadoConsul(){
            $obj = new SenalVialMalEstadoModel();
            $objeto= new AutenticacionModel();
            $objeto->acceso();
            if($_SESSION['rolcod']===3){
                $usuid=$_SESSION['usuid'];
                $sql = "SELECT sme.*, te.estdescripcion, tu.usuid, ts.sendescripcion, td.tdanocod, td.tdanodescripcion FROM tblsenalizacionesmalestado sme 
                INNER JOIN tblestado te ON sme.estcod = te.estcod
                INNER JOIN tblusuario tu ON sme.usuid = tu.usuid
                INNER JOIN tblsenal ts ON sme.sencod = ts.sencod
                INNER JOIN tbltipodano td ON sme.tdanocod = td.tdanocod
                WHERE sme.usuid = $usuid
                ORDER BY sme.smecod ASC";
                $senalMal=$obj->select($sql);  
            }
            if($_SESSION['rolcod']===2 || $_SESSION['rolcod']===1){

                $sql = "SELECT sme.*, te.estdescripcion, CONCAT(tu.usuprimernombre, ' ', tu.usuprimerapellido) AS usunombrecompleto, ts.sendescripcion, td.tdanocod, td.tdanodescripcion FROM tblsenalizacionesmalestado sme 
                INNER JOIN tblestado te ON sme.estcod = te.estcod
                INNER JOIN tblusuario tu ON sme.usuid = tu.usuid
                INNER JOIN tblsenal ts ON sme.sencod = ts.sencod
                INNER JOIN tbltipodano td ON sme.tdanocod = td.tdanocod
                ORDER BY sme.smecod ASC";
                $senalMal=$obj->select($sql);
            }

            include_once '../view/Solicitud/senalVialMalEstadoConsul.php';
        }


        public function getSenalMalEstadoUpdate(){
            $obj = new SenalVialMalEstadoModel();
            $objeto= new AutenticacionModel();
            $objeto->acceso();
            $objeto->verificarRolAdminFunci();
            
            $smecod = $_GET['smecod'];
            $mapContent = file_get_contents('../web/assets/js/visor/mapaUpdateMalSenal.map');
            $mapContent = str_replace('%smecod%', $smecod, $mapContent);
            file_put_contents('../web/assets/js/visor/mapaUpdateMalSenalnuevo.map', $mapContent);
        
            $sql= "SELECT *, ST_X(smecoordenadas) AS coord_x, ST_Y(smecoordenadas) AS coord_y FROM tblsenalizacionesmalestado WHERE smecod = $smecod";

            $senalMal = $obj->select($sql);
            $sql = "SELECT * FROM tbltipodano";
            $tipoDano = $obj->select($sql);
            $sql = "SELECT * FROM tblestado WHERE estcod NOT IN (1,2)";
            $estado=$obj->select($sql);
            $sql = "SELECT * FROM tblsenal";
            $senal =$obj->select($sql);
            $sql = "SELECT * FROM tblcatesenal";
            $categoria=$obj->select($sql);
            $sql = "SELECT * FROM tblorientacion";
            $orientacion = $obj->select($sql);

            include_once '../view/Solicitud/senalVialMalestadoUpdate.php';
            
        }

        
        public function postSenalMalEstadoUpdate(){
            $obj = new SenalVialMalEstadoModel();
            $objeto= new AutenticacionModel();
            $objeto->acceso();
            $objeto->verificarRolAdminFunci();
            $smecod = $_POST['smecod'];
            $estado = $_POST['estcod'];
            $observacion = $_POST['smeobservacion'];

            
            if(empty($observacion) && !empty($estado)){
                $sql= "UPDATE tblsenalizacionesmalestado SET smeobservacion = NULL, estcod = '$estado' WHERE smecod = $smecod";
            }else if(empty($estado)){
                echo json_encode(array(
                    "success" => false,
                    "message" => "El campo de estado no puede estar vacío."    
                ));
                exit();
            }else{
                $sql= "UPDATE tblsenalizacionesmalestado SET estcod = '$estado', smeobservacion = '$observacion' WHERE smecod = $smecod";
            }
            $ejecutar = $obj->update($sql);

            if($ejecutar){
                echo json_encode(array(
                    "success" => true,
                    "message" => ""    
                ));
                exit();
            }else{
                echo json_encode(array(
                    "success" => false,
                    "message" => "Error en actualizar la solicitud"    
                ));
                exit();
            }
            
        }  
    }


?>