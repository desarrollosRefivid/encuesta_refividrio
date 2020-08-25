<?php

/**
 * Controlador
 * Creado:  27/04/2020
 *
 * @author Marcos Moreno
 * 
 */

require_once '../lib/phpclient/autoload.php'; 

use Jaspersoft\Client\Client; 

$objReport = new generate_report();
$objReport -> showReport();

class generate_report
{ 
    public function showReport()
    {     
        $name_report = (isset($_GET['name_report'])?$_GET['name_report']:'');
        $id_empleado = (isset($_GET['id_empleado'])?$_GET['id_empleado']:0);
        $id_encuesta = (isset($_GET['id_encuesta'])?$_GET['id_encuesta']:0);
        $id_segmento = (isset($_GET['id_segmento'])?$_GET['id_segmento']:0);
        $id_empresa = (isset($_GET['id_empresa'])?$_GET['id_empresa']:0); 
        $realizadas = (isset($_GET['realizadas'])?$_GET['realizadas']:0);
        $nivel = (isset($_GET['nivel'])?$_GET['nivel']:0);
        $tipo_encuesta = (isset($_GET['tipo_encuesta'])?$_GET['tipo_encuesta']:0);//0 = Todos los tipos de encuestas; 1 : Concluidas; 2 : En captura;

        $params = array(
                'id_empleado' => $id_empleado,
                'id_encuesta' => $id_encuesta,  
                'id_segmento' => $id_segmento,
                'id_empresa' => $id_empresa, 
                'tipo_encuesta' => $tipo_encuesta ,
                'realizadas' => $realizadas, 
                'nivel' => $nivel 
            );

        $c = new Client("http://67.205.162.138:51541/jasperserver", "DesarrolloAdmin", "Dev_JasperSoft#20");
        $report = $c->reportService()->runReport('/reports/Encuestas/' . $name_report, 'pdf', null, null, $params);
        header('Content-Type: application/pdf'); 
        echo $report;
    }
}