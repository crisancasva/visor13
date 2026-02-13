<?php
     include_once '../Model/Solicitud/NuevoReductorModel.php';
     include_once '../model/Acceso/AutenticacionModel.php';
    
    class NuevoReductorController{

        public function getNuevoReductor(){
            $objeto= new AutenticacionModel();
            $objeto->acceso();
            $obj = new NuevoReductorModel();
            $sql = "SELECT * FROM tblreductor";
            $reductor = $obj->select($sql);
            

           include_once '../view/Solicitud/nuevoReductor.php';
        }

        public function postNuevoReductor(){
            $objeto= new AutenticacionModel();
            $objeto->acceso();
            $obj = new NuevoReductorModel();
            $descripcion = $_POST['nrDescripcion'];
            $imagen = $_FILES['nrImagen']['name'];
            $ruta = "../web/assets/img/$imagen";
            move_uploaded_file($_FILES['nrImagen']['tmp_name'],$ruta);
            $direccion = $_POST['nrDireccion'];
            $usuId =  $_SESSION['usuid'];
            $reducod= $_POST['reductor'];
            $map_pt[0] =$_POST['x'];
            $map_pt[1] =$_POST['y'];
            $geom = "ST_SetSRID(ST_GeomFromText('POINT({$map_pt[0]} {$map_pt[1]})'), 4326)";
        
      

                      
            if(empty($descripcion) || empty($imagen) || empty($ruta) || empty($direccion) || empty($usuId) || empty($reducod)){
                echo json_encode(array(
                    "success" => false,
                    "message" => "Todos los campos marcados con asterisco (*) son obligatorios"
                ));
                exit();
            }
            $extension= strtolower(pathinfo($_FILES['nrImagen']['name'], PATHINFO_EXTENSION));
            $permitidos = array("jpg", "jpeg", "png");
            $tamanoMaximo = 5 * 1024 * 1024;

            if (!in_array($extension, $permitidos)) {
                 echo json_encode(array(
                    "success" => false,
                    "message" => "Formato de imagen no permitido. Solo JPG, JPEG y PNG.",
                    
                ));
                exit();
            }
            if ($_FILES['nrImagen']['size'] > $tamanoMaximo) {
                echo json_encode(array(
                    "success" => false,
                    "message" => "El tamaño de la imagen supera el límite de 5MB."
                    
                ));
                exit();

            }

            $sql = "INSERT INTO tblnuevoreductor VALUES (DEFAULT,'$descripcion','$ruta','$direccion',null,DEFAULT,3,$usuId,$reducod, $geom)";

        
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
            $obj = new NuevoReductorModel();
            $objeto= new AutenticacionModel();
            $objeto->acceso();
            $crcod = $_POST['crcod'];
            $sql = "SELECT cr.crcod , cr.crdescripcion FROM tblReductor r INNER JOIN tblCategoriaReductor cr ON r.crcod = cr.crcod WHERE r.reducod = $crcod";
            $categoria=$obj->select($sql);
            
            foreach($categoria as $cate){
                echo "<option value='".$cate['crcod']."'>".$cate['crdescripcion']."</option>";
            }
            
        }


        public function getConsulNuevoRedu(){
            $obj = new NuevoReductorModel();
            $objeto= new AutenticacionModel();
            $objeto->acceso();
            if($_SESSION['rolcod']===3){
                $usuid=$_SESSION['usuid'];
                $sql = "SELECT tnr.*, te.estdescripcion, tu.usuid, tr.redudescripcion FROM tblnuevoreductor tnr
                INNER JOIN tblestado te ON tnr.estcod = te.estcod
                INNER JOIN tblusuario tu ON tnr.usuid = tu.usuid
                INNER JOIN tblreductor tr ON tnr.reducod = tr.reducod
                WHERE tnr.usuid = $usuid
                ORDER BY tnr.nrcod ASC";
                $nuevoredu=$obj->select($sql);
            }
            if($_SESSION['rolcod']===2 || $_SESSION['rolcod']===1){
                $sql = "SELECT tnr.*, te.estdescripcion, CONCAT(tu.usuprimernombre, ' ', tu.usuprimerapellido) AS usunombrecompleto, tr.redudescripcion FROM tblnuevoreductor tnr
                INNER JOIN tblestado te ON tnr.estcod = te.estcod
                INNER JOIN tblusuario tu ON tnr.usuid = tu.usuid
                INNER JOIN tblreductor tr ON tnr.reducod = tr.reducod
                ORDER BY tnr.nrcod ASC";
                $nuevoredu=$obj->select($sql);
            }
            include_once '../view/Solicitud/nuevoReductorConsul.php';
        }
        
        public function getNuevoReductorUpdate(){
            $obj = new NuevoReductorModel();
            $objeto= new AutenticacionModel();
            $objeto->acceso();
            $objeto->verificarRolAdminFunci();    
            $nrcod = $_GET['nrcod'];
            $mapContent = file_get_contents('../web/assets/js/visor/mapaUpdateNuevoReductor.map');
            $mapContent = str_replace('%nrcod%', $nrcod, $mapContent);
            file_put_contents('../web/assets/js/visor/mapaUpdateNuevoReductornuevo.map', $mapContent);
        
            $sql = "SELECT tnr.*, ST_X(nrcoordenadas) AS coord_x, ST_Y(nrcoordenadas) AS coord_y, tr.redudescripcion, tc.crdescripcion, tc.crcod
            FROM tblnuevoreductor tnr
            JOIN tblreductor tr ON tnr.reducod = tr.reducod
            JOIN tblcategoriareductor tc ON tr.crcod = tc.crcod
            WHERE tnr.nrcod = $nrcod";
            $nuevoredu=$obj->select($sql);
            $sql = "SELECT * FROM tblestado WHERE estcod NOT IN (1,2)";
            $estado=$obj->select($sql);
            $sql="SELECT * FROM tblreductor";
            $reductor = $obj->select($sql);

            include_once '../view/Solicitud/nuevoReductorUpdate.php';
            
        }
        
        public function postNuevoReductorUpdate(){
            $obj = new NuevoReductorModel();
            $objeto= new AutenticacionModel();
            $objeto->acceso();
            $objeto->verificarRolAdminFunci();
            $nrcod = $_POST['nrcod'];
            $estado = $_POST['estcod'];
            $observacion = $_POST['nrobservacion'];

            
            if(empty($observacion) && !empty($estado)){
                $sql= "UPDATE tblnuevoreductor SET nrobservacion = NULL, estcod = '$estado' WHERE nrcod = $nrcod";
            }else if(empty($estado)){
                echo json_encode(array(
                    "success" => false,
                    "message" => "El campo de estado no puede estar vacío."    
                ));
                exit();
            }else{
                $sql= "UPDATE tblnuevoreductor SET estcod = '$estado', nrobservacion = '$observacion' WHERE nrcod = $nrcod";
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