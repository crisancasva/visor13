<?php
include_once '../Model/Reportes/ReportesModel.php';

class ReportesController{

    public function getReportes(){
      include_once '../View/Reportes/reportes.php';  

    }
    public function generarReporteRSV() {
        $obj = new ReportesModel();
        
        require_once '../web/assets/PHPExcel/PHPExcel.php';
        $sql = "SELECT sme.smedescripcion as Descripcion, 
                       sme.smedireccion as Ubicacion, 
                       sme.smeobservacion as Observaciones, 
                       e.estdescripcion as Estado_solicitud, 
                       s.sendescripcion as Senal, 
                       td.tdanodescripcion as Dano
                FROM tblsenalizacionesmalestado sme
                INNER JOIN tblestado e ON sme.estcod = e.estcod
                INNER JOIN tblsenal s ON sme.sencod = s.sencod
                INNER JOIN tbltipodano td ON sme.tdanocod = td.tdanocod
                ORDER BY Descripcion";
        
        $resultado = $obj->select($sql);
        
        // Crear una instancia de PHPExcel
        $objPHPExcel = new PHPExcel();
    
        // Configurar propiedades del documento
        $objPHPExcel->getProperties()->setCreator("Geovisor13")
                                     ->setTitle("Senalizacion_vial_mal_estado");
    
        // Añadir encabezados con estilos
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'Descripción')
                    ->setCellValue('B1', 'Ubicación')
                    ->setCellValue('C1', 'Observaciones')
                    ->setCellValue('D1', 'Estado de Solicitud')
                    ->setCellValue('E1', 'Señal')
                    ->setCellValue('F1', 'Daño');
    
        // Aplicar estilos al encabezado
        $styleHeader = array(
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => 'FFFFFF')
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '4E74A6')
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )
        );
        
        $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->applyFromArray($styleHeader);
        
        // Añadir datos
        $i = 2; // Comenzar en la segunda fila
        foreach ($resultado as $result) {
            $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A'.$i, $result['descripcion'])
                        ->setCellValue('B'.$i, $result['ubicacion'])
                        ->setCellValue('C'.$i, $result['observaciones'])
                        ->setCellValue('D'.$i, $result['estado_solicitud'])
                        ->setCellValue('E'.$i, $result['senal'])
                        ->setCellValue('F'.$i, $result['dano']);
            $i++;
        }
    
        // Ajustar el ancho de las columnas automáticamente
        foreach (range('A', 'F') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }
    
        // Añadir bordes a las celdas con contenido
        $styleBorders = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                )
            )
        );
        
        $objPHPExcel->getActiveSheet()->getStyle('A1:F'.($i-1))->applyFromArray($styleBorders);
    
        // Renombrar la hoja
        $objPHPExcel->getActiveSheet()->setTitle('Reporte');
    
        // Guardar el archivo Excel en el servidor
        $tituloArchivo = $objPHPExcel->getProperties()->getTitle();
        $rutaArchivo = "../Web/assets/Archivos_excel/$tituloArchivo.xlsx"; // Cambia la ruta según sea necesario
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    
        try {
            $objWriter->save($rutaArchivo);
            echo json_encode(array(
                "success" => true,
                "message" => "Excel generado",
                "redirectUrl" => $rutaArchivo
            ));
            exit();
        } catch (Exception $e) {
            echo json_encode(array(
                "success" => false,
                "message" => "Error al generar el archivo: " . $e->getMessage()
            ));
            exit();
        }

    }
    
    public function generarReporteRR() {
        require_once '../web/assets/PHPExcel/PHPExcel.php';
        $obj = new ReportesModel();
    
        $sql = "SELECT rms.rmedescripcion as descripcion, 
                       rms.rmedireccion as ubicacion, 
                       rms.rmeobservacion as observaciones, 
                       e.estdescripcion as estado_solicitud, 
                       td.tdanodescripcion as dano, 
                       r.redudescripcion as tipo_reductor
                FROM tblreductoresmalestado rms
                INNER JOIN tblestado e ON rms.estcod = e.estcod
                INNER JOIN tbltipodano td ON rms.tdanocod = td.tdanocod
                INNER JOIN tblreductor r ON rms.reducod = r.reducod
                ORDER BY descripcion";
        $resultado = $obj->select($sql);
    
        // Crear una instancia de PHPExcel
        $objPHPExcel = new PHPExcel();
    
        // Configurar propiedades del documento
        $objPHPExcel->getProperties()->setCreator("Geovisor13")
                                     ->setTitle("Reductor_mal_estado");
    
        // Añadir encabezados con estilos
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'Descripción')
                    ->setCellValue('B1', 'Ubicación')
                    ->setCellValue('C1', 'Observaciones')
                    ->setCellValue('D1', 'Estado de Solicitud')
                    ->setCellValue('E1', 'Daño')
                    ->setCellValue('F1', 'Tipo Reductor');
    
        // Aplicar estilos al encabezado
        $styleHeader = array(
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => 'FFFFFF')
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '4E74A6') // Fondo azul intenso
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )
        );
        $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->applyFromArray($styleHeader);
    
        // Añadir datos al Excel
        $i = 2; // Comienza desde la fila 2
        foreach ($resultado as $result) {
            $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A'.$i, $result['descripcion'])
                        ->setCellValue('B'.$i, $result['ubicacion'])
                        ->setCellValue('C'.$i, $result['observaciones'])
                        ->setCellValue('D'.$i, $result['estado_solicitud'])
                        ->setCellValue('E'.$i, $result['dano'])
                        ->setCellValue('F'.$i, $result['tipo_reductor']);
            $i++;
        }
    
        // Ajustar automáticamente el ancho de las columnas
        foreach (range('A', 'F') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }
    
        // Añadir bordes a las celdas con contenido
        $styleBorders = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                )
            )
        );
        $objPHPExcel->getActiveSheet()->getStyle('A1:F'.($i-1))->applyFromArray($styleBorders);
    
        // Renombrar hoja
        $objPHPExcel->getActiveSheet()->setTitle('Reporte');
    
        // Guardar el archivo Excel en el servidor
        $tituloArchivo = $objPHPExcel->getProperties()->getTitle();
        $rutaArchivo = "../Web/assets/Archivos_excel/$tituloArchivo.xlsx"; // Cambia la ruta según sea necesario
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    
        // Guardar el archivo y verificar errores
        try {
            $objWriter->save($rutaArchivo);
            echo json_encode(array(
                "success" => true,
                "message" => "Excel generado correctamente",
                "redirectUrl" => $rutaArchivo
            ));
            exit();
        } catch (Exception $e) {
            echo json_encode(array(
                "success" => false,
                "message" => "Error al generar el archivo: " . $e->getMessage()
            ));
            exit();
        }
    }
    
    public function generarReporteRMV(){
        require_once '../web/assets/PHPExcel/PHPExcel.php';
        $obj=new ReportesModel();

        $sql="SELECT vme.vmedescripcion as Descripcion, vme.vmedireccion as Ubicacion, vme.vmeobservacion as Observaciones, e.estdescripcion as Estado_solicitud,td.tdanodescripcion as Dano
        FROM tblviamalestado vme, tblestado e, tbltipodano td
        WHERE vme.estcod=e.estcod AND vme.tdanocod=td.tdanocod
        order by Descripcion";
        $resultado = $obj->select($sql);
        // Crear una instancia de PHPExcel
        $objPHPExcel = new PHPExcel();

        // Configurar propiedades del documento
        $objPHPExcel->getProperties()->setCreator("Geovisor13")
                                     ->setTitle("Malla_vial_mal_estado");

                // Añadir datos a una hoja
                $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Descripcion')
                ->setCellValue('B1', 'Ubicacion')
                ->setCellValue('C1', 'Observaciones')
                ->setCellValue('D1', 'Estado_solicitud')
                ->setCellValue('E1', 'Dano');
                 // Aplicar estilos al encabezado
        $styleHeader = array(
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => 'FFFFFF')
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '4E74A6') // Fondo azul intenso
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )
        );
        $objPHPExcel->getActiveSheet()->getStyle('A1:e1')->applyFromArray($styleHeader);
    
        // Añadir datos al Excel
    $i=2;
        foreach($resultado as $result){
            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, $result['descripcion'])
            ->setCellValue('B'.$i, $result['ubicacion'])
            ->setCellValue('C'.$i, $result['observaciones'])
            ->setCellValue('D'.$i, $result['estado_solicitud'])
            ->setCellValue('E'.$i, $result['dano']);
            $i++;
        }
         // Ajustar automáticamente el ancho de las columnas
         foreach (range('A', 'E') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }
    
        // Añadir bordes a las celdas con contenido
        $styleBorders = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                )
            )
        );
        $objPHPExcel->getActiveSheet()->getStyle('A1:E'.($i-1))->applyFromArray($styleBorders);
    
        // Renombrar hoja
        $objPHPExcel->getActiveSheet()->setTitle('Hoja1');

        // Guardar el archivo Excel en el servidor
        $tituloArchivo = $objPHPExcel->getProperties()->getTitle();
        $rutaArchivo = "../Web/assets/Archivos_excel/$tituloArchivo.xlsx"; // Cambia la ruta según sea necesario
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

            // Guardar el archivo y verificar errores
        try {
            $objWriter->save($rutaArchivo);
            echo json_encode(array(
                "success" => true,
                "message" => "Excel generado",
                "redirectUrl" => $rutaArchivo
            ));
            exit();
        } catch (Exception $e) {
            echo json_encode(array(
                "success" => false,
                "message" => "Error al generar el archivo: " . $e->getMessage()
            ));
            exit();
        }


    }
    public function generarReporteRAT() {
        $obj = new ReportesModel();
        
        require_once '../web/assets/PHPExcel/PHPExcel.php';
        $sql = "SELECT  ta.accifecha as Fecha, 
                        ta.accilesionados as Cantidad_Lesionados, 
                        ta.acciobservaciones as Detalle_Accidente,
		                STRING_AGG(ttv.tvehidescripcion,' | ') as Vehiculos_involucrados, 
                        ta.accidireccion as Direccion, 
                        tts.tsinidescripcion as Tipo_siniestro, 
                        ta.acciotro as Otro_tipo_siniestro
                        FROM tblaccidente ta
                        INNER JOIN tbltiposiniestro tts ON ta.tsinicod = tts.tsinicod
		                INNER JOIN tblaccivehi tav ON tav.accicod = ta.accicod
                        INNER JOIN tbltipovehiculo ttv ON ttv.tvehicod = tav.tvehicod
		                GROUP BY 
                        ta.accifecha,
                        ta.accilesionados,
                        ta.acciobservaciones,
                        ta.accidireccion,
                        tts.tsinidescripcion,
                        ta.acciotro
                        ORDER BY ta.accifecha;";
        
        $resultado = $obj->select($sql);
        
        // Crear una instancia de PHPExcel
        $objPHPExcel = new PHPExcel();
    
        // Configurar propiedades del documento
        $objPHPExcel->getProperties()->setCreator("Visor13")
                                     ->setTitle("Accidentes_Transito");
    
        // Añadir encabezados con estilos
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'Fecha')
                    ->setCellValue('B1', 'Cantidad_Lesionados')
                    ->setCellValue('C1', 'Detalle_Accidente')
                    ->setCellValue('D1', 'Vehiculos_involucrados')
                    ->setCellValue('E1', 'Direccion')
                    ->setCellValue('F1', 'Tipo_siniestro')
                    ->setCellValue('G1', 'Otro_tipo_siniestro');
    
        // Aplicar estilos al encabezado
        $styleHeader = array(
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => 'FFFFFF')
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '4E74A6')
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )
        );
        
        $objPHPExcel->getActiveSheet()->getStyle('A1:G1')->applyFromArray($styleHeader);
        
        // Añadir datos
        $i = 2; // Comenzar en la segunda fila
        foreach ($resultado as $result) {
            $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A'.$i, $result['fecha'])
                        ->setCellValue('B'.$i, $result['cantidad_lesionados'])
                        ->setCellValue('C'.$i, $result['detalle_accidente'])
                        ->setCellValue('D'.$i, $result['vehiculos_involucrados'])
                        ->setCellValue('E'.$i, $result['direccion'])
                        ->setCellValue('F'.$i, $result['tipo_siniestro'])
                        ->setCellValue('G'.$i, $result['otro_tipo_siniestro']);
            $i++;
        }
        
        // Ajustar el ancho de las columnas automáticamente
         foreach (range('A', 'G') as $columnID) {
             $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
         }
    
         // Añadir bordes a las celdas con contenido
         $styleBorders = array(
             'borders' => array(
                 'allborders' => array(
                     'style' => PHPExcel_Style_Border::BORDER_THIN,
                     'color' => array('rgb' => '000000')
                 )
             )
         );
        
         $objPHPExcel->getActiveSheet()->getStyle('A1:G'.($i-1))->applyFromArray($styleBorders);
    
        // Renombrar la hoja
        $objPHPExcel->getActiveSheet()->setTitle('Reporte');
    
        // Guardar el archivo Excel en el servidor
        $tituloArchivo = $objPHPExcel->getProperties()->getTitle();
        $rutaArchivo = "../Web/assets/Archivos_excel/$tituloArchivo.xlsx"; // Cambia la ruta según sea necesario
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    
        try {
            $objWriter->save($rutaArchivo);
            echo json_encode(array(
                "success" => true,
                "message" => "Excel generado",
                "redirectUrl" => $rutaArchivo
            ));
            exit();
        } catch (Exception $e) {
            echo json_encode(array(
                "success" => false,
                "message" => "Error al generar el archivo: " . $e->getMessage()
            ));
            exit();
        }

    }
}
?>