<?php

    function redirect($url){
        echo "<script>".
                "window.location.href = '$url';".
            "</script>";

    } 
    function dd($var){
        echo "<pre>";
        die(print_r($var));
    }
    
    function getUrl($modulo,$controlador,$funcion,$parametros=false,$pagina=false){
        if($pagina === false){
           $pagina = "index"; 
        }

        $url = "$pagina.php?modulo=$modulo&controlador=$controlador&funcion=$funcion";

        if($parametros){
            foreach($parametros as $key => $value){
                $url .= "&$key=$value";
            }
        }

        return $url;
    }

    function resolve(){
        $modulo = ucwords($_GET['modulo']);
        $controlador = ucwords($_GET['controlador']);
        $funcion = $_GET['funcion'];

        if(is_dir("../controller/".$modulo)){
            if(is_file("../controller/".$modulo."/".$controlador."Controller.php")){

                require_once("../controller/".$modulo."/".$controlador."Controller.php");

                $controlador = $controlador."Controller";
                

                $objClase = new $controlador();

                if(method_exists($objClase,$funcion)){
                    $objClase->$funcion();
                }else{
                    echo "La funcion especificada no existe";
                }
            }else{
                echo "El controlador especificado no existe";
            }
        }else{
            echo "El modulo especificado no existe";
        }


    }


    function generarContrasena($longitud) {
        $mayusculas = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $minusculas = 'abcdefghijklmnopqrstuvwxyz';
        $numeros = '0123456789';
        $especiales = '!@#$%^&*()-_=+[]{};:,.<>?';
    
        $todosCaracteres = $mayusculas . $minusculas . $numeros . $especiales;
    
        // Asegurarnos de que la contraseña contiene al menos un carácter de cada grupo
        $contraseña = $mayusculas[rand(0, strlen($mayusculas) - 1)];
        $contraseña .= $minusculas[rand(0, strlen($minusculas) - 1)];
        $contraseña .= $numeros[rand(0, strlen($numeros) - 1)];
        $contraseña .= $especiales[rand(0, strlen($especiales) - 1)];
    
        // Completar el resto de la contraseña con caracteres aleatorios
        for ($i = 4; $i < $longitud; $i++) {
            $contraseña .= $todosCaracteres[rand(0, strlen($todosCaracteres) - 1)];
        }
    
        // Mezclar los caracteres para que no sigan un patrón fijo
        return str_shuffle($contraseña);
    }

?>