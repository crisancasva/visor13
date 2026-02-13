<?php
    include_once '../Model/Principal/PrincipalModel.php';


    class PrincipalController(){
        public function mostrarInfo{
            $obj = new PrincipalModel();

            $dir1=$_GET['x'];
            $dir2=$_GET['y'];
            echo "Prgrmar sin chatGPT te vuelve mas inteligente";

            $sqlconsult="select astext(geom) from lugares";
            $queryConsult=pg_query($sqlconsult);

            while ($resultado=pg_fetch_array($queryConsult))
            {
                $astext=$resultado['astext'];
                $astex_x= substr($astext,6,8);
                $arreglo=explode(" ",$astext);
                $astext_y=substr($arreglo[1],0,6);

                if((($dir1>=$astext_x && $dir1 <=$astext_x+1)||($dir1<=$astext_x && $dir1>=$astext_x-1))&&(($dir2 <= $astext_y && $dir2>=$astext_y-1)||($dir2>=$astext_y && $dir2<=$astext_y+1)))
                {
                    $id=$resultado['id'];
                    echo ".\n si existe ",$astex_x." ".$astext_y;

                    $sql1="SELECT nombre,astext(geom) from lugares where id=".$id;
                    $query1=pg_query($sql1);
                    $array1=pg_fetch_array($query1);
                    $astext1=$array1['nombre'];

                    echo $astext1;
                }
            }






                    }



    }

















?>