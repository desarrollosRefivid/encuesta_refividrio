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
        $id_empleado = (isset($_GET['id_empleado'])?$_GET['id_empleado']:0);
        $id_encuesta = (isset($_GET['id_encuesta'])?$_GET['id_encuesta']:0);  
        $params = array(
                'id_empleado' => $id_empleado,
                'id_encuesta' => $id_encuesta, 
            );
        $c = new Client("http://67.205.162.138:51541/jasperserver", "DesarrolloAdmin", "Dev_JasperSoft#20");
        $report = $c->reportService()->runReport('/reports/Encuestas/resultadoEncuesta', 'pdf', null, null, $params);
        header('Content-Type: application/pdf'); 
        echo $report;
    }
}