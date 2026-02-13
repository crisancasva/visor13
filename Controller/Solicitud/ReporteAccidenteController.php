<?php
include_once '../Model/Solicitud/ReporteAccidenteModel.php';
include_once '../model/Acceso/AutenticacionModel.php';

class ReporteAccidenteController{
    public function getReporteAccidente(){
        $objeto= new AutenticacionModel();
        $objeto->acceso();

        $obj=new ReporteAccidenteModel();
        $sql="SELECT * FROM tbltiposiniestro";
        $accidente=$obj->select($sql);


        include_once '../view/Solicitud/reporteAccidente.php';

    }
    public function postReporteAccidente(){
        $objeto= new AutenticacionModel();
        $objeto->acceso();
        $obj= new ReporteAccidenteModel();
        $numvehiculos=$_POST['numvehiculo'];
        $tiposiniestro=$_POST['tiposiniestro'];
        $numlesionados=$_POST['lesionados'];
        $observacion=$_POST['raObservacion'];
        $imagen = $_FILES['raImagen']['name'];
        $ruta = "../web/assets/img/$imagen";
        move_uploaded_file($_FILES['raImagen']['tmp_name'],$ruta);
        $map_pt[0] =$_POST['x'];
        $map_pt[1] =$_POST['y'];
        $direccion=$_POST['raDireccion'];
        $usuId =  $_SESSION['usuid'];


        if(empty($numvehiculos) || empty($tiposiniestro) || empty($observacion) || empty($imagen) || empty($ruta) || empty($direccion) || 
        empty($usuId) || empty($map_pt[0]) || empty($map_pt[1])){
            echo json_encode(array(
                "success" => false,
                "message" => "Todos los campos marcados con asterisco (*) son obligatorios"
            ));
        }else{
            if($tiposiniestro==5){
                if(empty($_POST['otrotiposiniestro'])){ 
                    echo json_encode(array(
                        "success" => false,
                        "message" => "escogio otro siniestro y no coloco el detalle",
                    ));
                }else{
                    $otrosiniestro=$_POST['otrotiposiniestro']; 
                    $sql="INSERT INTO tblaccidente VALUES(DEFAULT,DEFAULT,'$ruta',$numlesionados,'$observacion','$direccion',$tiposiniestro,$usuId,ST_SetSRID(ST_GeomFromText('POINT($map_pt[0] $map_pt[1])'),4326),'$otrosiniestro')
                    RETURNING accicod";
                    $resultado=$obj->insert($sql);
                    $idselect = $resultado->fetchColumn();
            
                    for($i=1;$i<=$numvehiculos;$i++){
                        if(empty($_POST["vehiselect".$i])){
                            echo json_encode(array(
                                "success" => false,
                                "message" => "Todos los campos marcados con asterisco (*) son obligatorios"
                            ));
                        }else{
                        $vehi=$_POST["vehiselect".$i];
                        $sql="INSERT INTO tblaccivehi VALUES (DEFAULT, $idselect,$vehi)";
                        $resultvehi=$obj->insert($sql);}
                    }
                    if($resultado){
                        echo json_encode(array(
                            "success" => true,
                            "message" => "",
                            "redirectUrl" => "index.php"
                        ));
                        exit();
                    }else{
                        echo json_encode(array(
                            "success" => false,
                            "message" => "No se pudo ingresar",
                        ));
                        exit();
                    }    
                }
            }else{
        
                $sql="INSERT INTO tblaccidente VALUES(DEFAULT,DEFAULT,'$ruta',$numlesionados,'$observacion','$direccion',$tiposiniestro,$usuId,ST_SetSRID(ST_GeomFromText('POINT($map_pt[0] $map_pt[1])'),4326),null)
                RETURNING accicod";
                $resultado=$obj->insert($sql);
                $idselect = $resultado->fetchColumn();

                for($i=1;$i<=$numvehiculos;$i++){
                    if(empty($_POST["vehiselect".$i])){
                        echo json_encode(array(
                            "success" => false,
                            "message" => "Todos los campos marcados con asterisco (*) son obligatorios"
                        ));
                    }else{
                    $vehi=$_POST["vehiselect".$i];
                    $sql="INSERT INTO tblaccivehi VALUES (DEFAULT, $idselect,$vehi)";
                    $resultvehi=$obj->insert($sql);}
                }

                if($resultado){
                    echo json_encode(array(
                        "success" => true,
                        "message" => "",
                        "redirectUrl" => "index.php"
                    ));
                    exit();
                }else{
                    echo json_encode(array(
                        "success" => false,
                        "message" => "No se pudo ingresar",
                    ));
                    exit();
                }
            }
        }
    }
    



    public function vehiSeleccionados(){

        $cantidad = $_POST['numvehiculo'];

        if (empty($cantidad)) {
            echo "no puede estar en cero";
    
        }else{

            $obj=new ReporteAccidenteModel();
            $sql="SELECT * FROM tbltipovehiculo";
            $vehiculo=$obj->select($sql);  
            for($i=1;$i<=$cantidad;$i++){
                echo "<label for=''>Seleccione vehiculo $i:</label>";
                echo "<select name='vehiselect".$i."' class='form-control' required>";
                echo "<option value=''>Seleccione...</option>";
                foreach($vehiculo as $vehi){
                echo "<option value='".$vehi['tvehicod']."'>".$vehi['tvehidescripcion']."</option>";
                }
                echo "</select><br><br>";
            }
        }
    }



    public function blocOtroTipo(){
        $idotrotipo=$_POST['tiposiniestro'];
       
        if(empty($idotrotipo)){
            echo "no vacio";
        }else{
            if($idotrotipo==="5"){
            echo "<textarea type='text' class='form-control' name='otrotiposiniestro' placeholder='Detalla el tipo de accidente' style='resize: none;'></textarea>";
            }
        }
    }



    public function getConsulAccidente(){
        $obj=new ReporteAccidenteModel();
        
        $sql= "SELECT ta.*, astext(ta.accicoordenadas), ts.tsinicod, ts.tsinidescripcion, CONCAT(tu.usuprimernombre, ' ', tu.usuprimerapellido) AS usunombrecompleto FROM tblaccidente ta INNER JOIN tbltiposiniestro ts ON ta.tsinicod = ts.tsinicod INNER JOIN tblusuario tu ON ta.usuid = tu.usuid ORDER BY ta.accicod ASC";

        $accidente= $obj->select($sql);
       include_once '../View/Solicitud/reporteAccidenteConsul.php';


    }
    public function verAccidente(){
        $obj=new ReporteAccidenteModel();
        $objeto= new AutenticacionModel();
        $objeto->acceso();
        $objeto->verificarRolAdminFunci();
        
        $accicod= $_GET['accicod'];
        $mapContent = file_get_contents('../web/assets/js/visor/mapaveraccidente.map');
        $mapContent = str_replace('%accicod%', $accicod, $mapContent);
        file_put_contents('../web/assets/js/visor/mapaveraccidentenuevo.map', $mapContent);
        
        $sql= "SELECT  CONCAT(tu.usuprimernombre, ' ', tu.usuprimerapellido) as nombre,ta.accifecha, ta.acciimagen, ta.accilesionados,ta.acciobservaciones,ta.accidireccion, tps.tsinidescripcion, astext(ta.accicoordenadas),
                ta.acciotro, tav.accivehicod from tblaccidente ta INNER JOIN tblaccivehi tav ON ta.accicod=tav.accicod INNER JOIN tbltiposiniestro tps ON ta.tsinicod=tps.tsinicod
                INNER JOIN tblusuario tu ON ta.usuid=tu.usuid WHERE ta.accicod=$accicod
                order by nombre";

        $reporteaccidente= $obj->select($sql);

        $filas = count($reporteaccidente);
        $sql="SELECT tv.tvehidescripcion from tbltipovehiculo tv, tblaccidente ta, tblaccivehi tav 
        where ta.accicod=tav.accicod AND tv.tvehicod=tav.tvehicod AND ta.accicod=$accicod";
        $accivehi=$obj->select($sql);

            foreach($accivehi as $vehi){
               $vehiculos.=$vehi['tvehidescripcion']."\n";
            }
        
        include_once '../View/Solicitud/reporteAccidenteVer.php';
    }
}








?>