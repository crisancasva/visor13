<?php
     include_once '../model/Solicitud/ReductorMalEstadoModel.php';
     include_once '../model/Acceso/AutenticacionModel.php';
    
    class ReductorMalEstadoController{

        public function getReductorMalEstado(){
            $objeto= new AutenticacionModel();
            $objeto->acceso();
            $obj = new ReductorMalEstadoModel();
            $sql = "SELECT * FROM tbltipodano";
            $tipoDano = $obj->select($sql);

            $sql = "SELECT * FROM tblreductor";
            $reductor = $obj->select($sql);

            include_once '../view/Solicitud/ReductorMalEstado.php';

        }

        public function postReductorMalEstado(){
            $obj = new ReductorMalEstadoModel();
            $objeto= new AutenticacionModel();
            $objeto->acceso();
            $descripcion = $_POST['rmedescripcion'];
            $direccion = $_POST['rmedireccion'];
            $imagen = $_FILES['rmeimagen']['name'];
            $ruta = "../web/assets/img/$imagen";
            move_uploaded_file($_FILES['rmeimagen']['tmp_name'],$ruta);
            $dano = $_POST['tdanocod'];
            $usuId = $_SESSION['usuid'];
            $redu = $_POST['reducod'];
            $map_pt[0] =$_POST['x'];
            $map_pt[1] =$_POST['y'];
            $geom = "ST_SetSRID(ST_GeomFromText('POINT({$map_pt[0]} {$map_pt[1]})'), 4326)";



            if(empty($descripcion) || empty($ruta) || empty($direccion) || empty($usuId) || empty($dano) || empty($redu)){
                echo json_encode(array(
                    "success" => false,
                    "message" => "Todos los campos marcados con asterisco (*) son obligatorios"
                ));
                exit();
            }
            $extension= strtolower(pathinfo($_FILES['rmeimagen']['name'], PATHINFO_EXTENSION));
            $permitidos = array("jpg", "jpeg", "png");
            $tamanoMaximo = 5 * 1024 * 1024;

            if (!in_array($extension, $permitidos)) {
                 echo json_encode(array(
                    "success" => false,
                    "message" => "Formato de imagen no permitido. Solo JPG, JPEG y PNG."
                    
                ));
                exit();
            }
            if ($_FILES['rmeimagen']['size'] > $tamanoMaximo) {
                echo json_encode(array(
                    "success" => false,
                    "message" => "El tamaño de la imagen supera el límite de 5MB."
                    
                ));
                exit();

            }

            $sql = "INSERT INTO tblreductoresmalestado VALUES (DEFAULT,'$descripcion','$ruta', '$direccion', DEFAULT, null, 3, $usuId, $dano, $redu,$geom)";

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

        public function getCategoriaReductor(){
            $obj = new ReductorMalEstadoModel();
            $objeto= new AutenticacionModel();
            $objeto->acceso();
            $crcod = $_POST['crcod'];
            $sql = "SELECT cr.crcod , cr.crdescripcion FROM tblReductor r INNER JOIN tblCategoriaReductor cr ON r.crcod = cr.crcod WHERE r.reducod = $crcod";
            $categoria=$obj->select($sql);
            
            foreach($categoria as $cate){
                echo "<option value='".$cate['crcod']."'>".$cate['crdescripcion']."</option>";
            }
        }


        public function getConsulReduMalEstado(){
            $obj = new ReductorMalEstadoModel();
            $objeto= new AutenticacionModel();
            $objeto->acceso();
            if($_SESSION['rolcod']===3){
                $usuid=$_SESSION['usuid'];
                $sql= "SELECT rm.*, e.estdescripcion, tu.usuid, td.tdanodescripcion, r.redudescripcion, c.crdescripcion FROM tblreductoresmalestado rm JOIN tblestado e ON rm.estcod = e.estcod JOIN tblusuario tu ON rm.usuid = tu.usuid JOIN tbltipodano td ON rm.tdanocod = td.tdanocod JOIN tblreductor r ON rm.reducod = r.reducod JOIN tblcategoriareductor c ON r.crcod = c.crcod WHERE rm.usuid = $usuid ORDER BY rmecod ASC";
                $redumal=$obj->select($sql);
            }
            if($_SESSION['rolcod']===2 || $_SESSION['rolcod']===1){

                $sql= "SELECT rm.*, e.estdescripcion, CONCAT(tu.usuprimernombre, ' ', tu.usuprimerapellido) AS usunombrecompleto, td.tdanodescripcion, r.redudescripcion, c.crdescripcion FROM tblreductoresmalestado rm JOIN tblestado e ON rm.estcod = e.estcod JOIN tblusuario tu ON rm.usuid = tu.usuid JOIN tbltipodano td ON rm.tdanocod = td.tdanocod JOIN tblreductor r ON rm.reducod = r.reducod JOIN tblcategoriareductor c ON r.crcod = c.crcod ORDER BY rmecod ASC";
                $redumal=$obj->select($sql);
            }

            include_once '../view/Solicitud/reductorMalEstadoConsul.php';

        }
        public function getUpdateReduMalEstado(){
            $obj = new ReductorMalEstadoModel();
            $objeto= new AutenticacionModel();
            $objeto->acceso();
            $objeto->verificarRolAdminFunci();
            
            $rmecod = $_GET['rmecod'];
            $mapContent = file_get_contents('../web/assets/js/visor/mapaUpdateMalReductor.map');
            $mapContent = str_replace('%rmecod%', $rmecod, $mapContent);
            file_put_contents('../web/assets/js/visor/mapaUpdateMalReductornuevo.map', $mapContent);
        
            $sql = "SELECT rme.*,ST_X(rmecoordenadas) AS coord_x, ST_Y(rmecoordenadas) AS coord_y, tr.redudescripcion, tc.crdescripcion, tc.crcod, td.tdanocod, td.tdanodescripcion 
            FROM tblreductoresmalestado rme
            JOIN tblreductor tr ON rme.reducod = tr.reducod
            JOIN tblcategoriareductor tc ON tr.crcod = tc.crcod
            JOIN tbltipodano td ON rme.tdanocod = td.tdanocod 
            WHERE rme.rmecod = $rmecod";
            $redumal=$obj->select($sql);
            $sql = "SELECT * FROM tblestado WHERE estcod NOT IN (1,2)";
            $estado=$obj->select($sql);
            $sql="SELECT * FROM tblreductor";
            $reductor = $obj->select($sql);
            $sql = "SELECT * FROM tbltipodano";
            $tipoDano = $obj->select($sql);

            include_once '../view/Solicitud/reductorMalEstadoUpdate.php';
            
        }
        public function postUpdateReduMalEstado(){
            $obj = new ReductorMalEstadoModel();
            $objeto= new AutenticacionModel();
            $objeto->acceso();
            $objeto->verificarRolAdminFunci();
            $rmecod = $_POST['rmecod'];
            $estado = $_POST['estcod'];
            $observacion = $_POST['rmeobservacion'];

            
            if(empty($observacion) && !empty($estado)){
                $sql= "UPDATE tblreductoresmalestado SET rmeobservacion = NULL, estcod = '$estado' WHERE rmecod = $rmecod";
            }else if(empty($estado)){
                echo json_encode(array(
                    "success" => false,
                    "message" => "El campo de estado no puede estar vacío."    
                ));
                exit();
            }else{
                $sql= "UPDATE tblreductoresmalestado SET estcod = '$estado', rmeobservacion = '$observacion' WHERE rmecod = $rmecod";
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