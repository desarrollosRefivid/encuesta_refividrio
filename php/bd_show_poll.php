<?php

require_once "postgres.php";
session_start();
    $received_data = json_decode(file_get_contents("php://input"));
    $data = array();

    if ($received_data->action == 'getPooll' && $received_data->filter == 'pending') {
        $query = " SELECT 
                    e.*
                FROM refividrio.encuesta e  
                LEFT JOIN refividrio.empleado empl ON empl.id_empleado = " . $_SESSION['id_empleado'] ."
                INNER JOIN refividrio.segmento seg ON empl.id_segmento = seg.id_segmento
                WHERE 
                    e.id_encuesta NOT IN (SELECT id_encuesta FROM refividrio.empleado_encuesta WHERE id_empleado = empl.id_empleado )
                    AND seg.id_empresa IN (SELECT id_empresa FROM empresa_encuesta WHERE  e.id_encuesta = id_encuesta)
                    AND now() >= e.validodesde 
                    AND now() <=  e.validohasta
                    AND e.activo = true
                ORDER BY e.validodesde";
        $statement = $connect->prepare($query);
        $statement->execute();
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        echo json_encode($data);
    }  

    if ($received_data->action == 'seachPollComplete') {
        $query = "
        SELECT   *  FROM refividrio.encuesta e 
        WHERE   e.id_encuesta IN (SELECT id_encuesta FROM refividrio.empleado_encuesta WHERE id_empleado =" . $_SESSION['id_empleado'] ." ) 
        ORDER BY e.validodesde"; 
        $statement = $connect->prepare($query);
        $statement->execute();
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        echo json_encode($data);
    }  
?>