<?php
     include_once '../model/Solicitud/MallaVialMalEstadoModel.php';
     include_once '../model/Acceso/AutenticacionModel.php';

     class MallaVialMalEstadoController{
        public function getMallaVialMalEstado(){
            $objeto= new AutenticacionModel();
            $objeto->acceso();
            $obj = new MallaVialMalEstadoModel();
            $sql = "SELECT tdanocod, tdanodescripcion FROM tbltipodano WHERE tdanocod NOT IN (1, 2, 3)";
            $tipoDano = $obj->select($sql);

            include_once '../view/Solicitud/MallaVialMalEstado.php';
        }

        public function postMallaVialMalEstado(){
            $obj = new MallaVialMalEstadoModel();
            $objeto= new AutenticacionModel();
            $objeto->acceso();
            $descripcion = $_POST['vmedescripcion'];
            $direccion = $_POST['vmedireccion'];
            $imagen = $_FILES['vmeimagen']['name'];
            $ruta = "../web/assets/img/$imagen";
            move_uploaded_file($_FILES['vmeimagen']['tmp_name'],$ruta);
            $dano = $_POST['tdanocod'];
            $usuId = $_SESSION['usuid'];
            $map_pt[0] =$_POST['x'];
            $map_pt[1] =$_POST['y'];
            $geom = "ST_SetSRID(ST_GeomFromText('POINT({$map_pt[0]} {$map_pt[1]})'), 4326)";



            if(empty($descripcion) || empty($ruta) || empty($direccion) || empty($usuId) || empty($dano)){
                echo json_encode(array(
                    "success" => false,
                    "message" => "Todos los campos marcados con asterisco (*) son obligatorios"
                ));
                exit();
            }
            $extension= strtolower(pathinfo($_FILES['vmeimagen']['name'], PATHINFO_EXTENSION));
            $permitidos = array("jpg", "jpeg", "png");
            $tamanoMaximo = 5 * 1024 * 1024;

            if (!in_array($extension, $permitidos)) {
                 echo json_encode(array(
                    "success" => false,
                    "message" => "Formato de imagen no permitido. Solo JPG, JPEG y PNG."
                    
                ));
                exit();
            }
            if ($_FILES['vmeimagen']['size'] > $tamanoMaximo) {
                echo json_encode(array(
                    "success" => false,
                    "message" => "El tamaño de la imagen supera el límite de 5MB."
                    
                ));
                exit();

            }

            $sql = "INSERT INTO tblViaMalEstado VALUES (DEFAULT,'$descripcion','$ruta', '$direccion', DEFAULT, null, 3, $usuId, $dano, $geom)";

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


        public function getMallaVialMalEstadoConsul(){
            $obj = new MallaVialMalEstadoModel();
            $objeto= new AutenticacionModel();
            $objeto->acceso();
            if($_SESSION['rolcod']===3){
                $usuid = $_SESSION['usuid'];
                $sql = "SELECT vme.*,  te.estdescripcion, td.tdanodescripcion, tu.usuid FROM tblviamalestado vme 
                INNER JOIN tblestado te ON vme.estcod = te.estcod
                INNER JOIN tbltipodano td ON vme.tdanocod = td.tdanocod
                INNER JOIN tblusuario tu ON vme.usuid = tu.usuid
                WHERE vme.usuid = $usuid
                ORDER BY vmecod ASC ";
                $viamal = $obj->select($sql); 
            }
            if($_SESSION['rolcod']===2 || $_SESSION['rolcod']===1){
                $sql = "SELECT vme.*,  te.estdescripcion, td.tdanodescripcion, CONCAT(tu.usuprimernombre, ' ', tu.usuprimerapellido) AS usunombrecompleto FROM tblviamalestado vme 
                INNER JOIN tblestado te ON vme.estcod = te.estcod
                INNER JOIN tbltipodano td ON vme.tdanocod = td.tdanocod
                INNER JOIN tblusuario tu ON vme.usuid = tu.usuid
                ORDER BY vmecod ASC ";
                $viamal = $obj->select($sql);
            }

            include_once '../view/Solicitud/mallaVialMalEstadoConsul.php';
        }



        public function getMallaVialMalEstadoUpdate(){
            $obj = new MallaVialMalEstadoModel();
            $objeto= new AutenticacionModel();
            $objeto->acceso();
            $objeto->verificarRolAdminFunci();
            
            $vmecod = $_GET['vmecod'];
            $mapContent = file_get_contents('../web/assets/js/visor/mapaUpdateMalla.map');
            $mapContent = str_replace('%vmecod%', $vmecod, $mapContent);
            file_put_contents('../web/assets/js/visor/mapaUpdateMallanuevo.map', $mapContent);
        
            $sql= "SELECT *, ST_X(vmecoordenadas) AS coord_x, ST_Y(vmecoordenadas) AS coord_y FROM tblviamalestado WHERE vmecod = $vmecod";
            $viamal = $obj->select($sql);
            $sql = "SELECT * FROM tbltipodano";
            $tipoDano = $obj->select($sql);
            $sql = "SELECT * FROM tblestado WHERE estcod NOT IN (1,2)";
            $estado = $obj->select($sql);
           // $mapserver_url = "localhost:9000/cgi-bin/mapserv.exe?map=/ms4w/Apache/htdocs/geovisor2/Web/assets/js/Visor/mapaUpdate.map&mode=map&vmecod=" . $vmecod;
            include_once '../view/Solicitud/mallaVialMalEstadoUpdate.php';
            
        }
        public function postMallaVialMalEstadoUpdate(){
            $obj= new MallaVialMalEstadoModel();
            $objeto= new AutenticacionModel();
            $objeto->acceso();
            $objeto->verificarRolAdminFunci();
            $vmecod = $_POST['vmecod'];
            $estado = $_POST['estcod'];
            $observacion = $_POST['vmeobservacion'];

            
            if(empty($observacion) && !empty($estado)){
                $sql= "UPDATE tblviamalestado SET vmeobservacion = NULL, estcod = '$estado' WHERE vmecod = $vmecod";
            }else if(empty($estado)){
                echo json_encode(array(
                    "success" => false,
                    "message" => "El campo de estado no puede estar vacío."    
                ));
                exit();
            }else{
                $sql= "UPDATE tblviamalestado SET estcod = '$estado', vmeobservacion = '$observacion' WHERE vmecod = $vmecod";
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