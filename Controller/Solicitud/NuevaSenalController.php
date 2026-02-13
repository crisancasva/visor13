<?php
     include_once '../model/Solicitud/NuevaSenalModel.php';
     include_once '../model/Acceso/AutenticacionModel.php';
    
    class NuevaSenalController{
        public function getNuevaSenal(){
            $objeto= new AutenticacionModel();
            $objeto->acceso();
            $obj = new NuevaSenalModel();
            $sql = "SELECT * FROM tblOrientacion";
            $orientacion = $obj->select($sql);

           include_once '../view/Solicitud/NuevaSenal.php';
        }

        public function postNuevaSenal(){
            $obj = new NuevaSenalModel();
            $objeto= new AutenticacionModel();
            $objeto->acceso();
            $descripcion = $_POST['nsdescripcion'];
            $imagen = $_FILES['nsimagen']['name'];
            $ruta = "../web/assets/img/$imagen";
            move_uploaded_file($_FILES['nsimagen']['tmp_name'],$ruta);
            $direccion = $_POST['nsdireccion'];
            $orientacion= $_POST['orientcod'];
            $usuId =  $_SESSION['usuid'];
            $senal = $_POST['sencod'];
            $map_pt[0] =$_POST['x'];
            $map_pt[1] =$_POST['y'];
            $geom = "ST_SetSRID(ST_GeomFromText('POINT({$map_pt[0]} {$map_pt[1]})'), 4326)";
            

            
            if(empty($descripcion) || empty($imagen) || empty($ruta) || empty($direccion) || empty($usuId) || empty($senal) || empty($orientacion) || empty($geom)){
                echo json_encode(array(
                    "success" => false,
                    "message" => "Todos los campos marcados con asterisco (*) son obligatorios"
                ));
                exit();
            }

            $extension= strtolower(pathinfo($_FILES['nsimagen']['name'], PATHINFO_EXTENSION));
            $permitidos = array("jpg", "jpeg", "png");
            $tamanoMaximo = 5 * 1024 * 1024;

            if (!in_array($extension, $permitidos)) {
                 echo json_encode(array(
                    "success" => false,
                    "message" => "Formato de imagen no permitido. Solo JPG, JPEG y PNG."
                    
                ));
                exit();
            }
            if ($_FILES['nsimagen']['size'] > $tamanoMaximo) {
                echo json_encode(array(
                    "success" => false,
                    "message" => "El tamaño de la imagen supera el límite de 5MB."
                    
                ));
                exit();

            }
            $sql = "INSERT INTO tblnuevasenalizacion VALUES (DEFAULT, '$descripcion' ,'$ruta' ,'$direccion' ,DEFAULT, null , 3, $usuId  , $senal,$orientacion, $geom)";

        
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
            $obj = new NuevaSenalModel();
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
            $obj = new NuevaSenalModel();
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



        public function getConsulNuevaSenal(){
            $obj = new NuevaSenalModel();
            $objeto= new AutenticacionModel();
            $objeto->acceso();
            if($_SESSION['rolcod']===3){
                $usuid=$_SESSION['usuid'];
                $sql = $sql = "SELECT tns.*,tu.usuid, te.estdescripcion, ts.sendescripcion , tbo.orientcod, tbo.orientdescripcion FROM tblnuevasenalizacion tns 
                INNER JOIN tblestado te ON tns.estcod = te.estcod
                INNER JOIN tblusuario tu ON tns.usuid = tu.usuid
                INNER JOIN tblsenal ts ON tns.sencod = ts.sencod
                INNER JOIN tblorientacion tbo ON tns.orientcod = tbo.orientcod
                WHERE tns.usuid = $usuid
                ORDER BY tns.nscod ASC";
                $senalizacion=$obj->select($sql);
            }

            if($_SESSION['rolcod']===2 || $_SESSION['rolcod']===1){
                $sql = "SELECT tns.*, te.estdescripcion, CONCAT(tu.usuprimernombre, ' ', tu.usuprimerapellido) AS usunombrecompleto, ts.sendescripcion , tbo.orientcod, tbo.orientdescripcion FROM tblnuevasenalizacion tns 
                INNER JOIN tblestado te ON tns.estcod = te.estcod
                INNER JOIN tblusuario tu ON tns.usuid = tu.usuid
                INNER JOIN tblsenal ts ON tns.sencod = ts.sencod
                INNER JOIN tblorientacion tbo ON tns.orientcod = tbo.orientcod
                ORDER BY tns.nscod ASC";
                $senalizacion=$obj->select($sql);
            }

            include_once '../view/Solicitud/nuevaSenalConsul.php';

        }

        
        public function getUpdateNuevaSenal(){
            $obj = new NuevaSenalModel();
            $objeto= new AutenticacionModel();
            $objeto->acceso();
            $objeto->verificarRolAdminFunci();
            
            $nscod = $_GET['nscod'];
            $mapContent = file_get_contents('../web/assets/js/visor/mapaUpdateNuevaSenal.map');
            $mapContent = str_replace('%nscod%', $nscod, $mapContent);
            file_put_contents('../web/assets/js/visor/mapaUpdateNuevaSenalnuevo.map', $mapContent);
        
            $sql= "SELECT *, ST_X(nscoordenadas) AS coord_x, ST_Y(nscoordenadas) AS coord_y FROM tblnuevasenalizacion WHERE nscod = $nscod";
            $senalizacion =$obj->select($sql);
            $sql = "SELECT * FROM tblsenal";
            $senal = $obj->select($sql);
            $sql = "SELECT * FROM tblorientacion";
            $orientacion= $obj->select($sql);
            $sql = "SELECT * FROM tblcatesenal";
            $categoria=$obj->select($sql);
            $sql = "SELECT * FROM tblestado WHERE estcod NOT IN (1,2)";
            $estado=$obj->select($sql);
            include_once '../view/Solicitud/nuevaSenalUpdate.php';
            
        }
        


        public function postUpdateNuevaSenal(){
            $obj = new NuevaSenalModel();
            $objeto= new AutenticacionModel();
            $objeto->acceso();
            $objeto->verificarRolAdminFunci();
            $nscod = $_POST['nscod'];
            $estado = $_POST['estcod'];
            $observacion = $_POST['nsobservacion'];

            
            if(empty($observacion) && !empty($estado)){
                $sql= "UPDATE tblnuevasenalizacion SET nsobservacion = NULL, estcod = '$estado' WHERE nscod = $nscod";
            }else if(empty($estado)){
                echo json_encode(array(
                    "success" => false,
                    "message" => "El campo de estado no puede estar vacío."    
                ));
                exit();
            }else{
                $sql= "UPDATE tblnuevasenalizacion SET estcod = '$estado', nsobservacion = '$observacion' WHERE nscod = $nscod";
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