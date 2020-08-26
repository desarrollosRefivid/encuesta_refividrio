<?php

require_once "postgres.php";
    session_start();
    $received_data = json_decode(file_get_contents("php://input"));
    $data = array();

    if ($received_data->action == 'fetchallQuestion') {
        $query = "
        SELECT 
            e.id_encuesta,p.id_pregunta,p.nombre_pregunta
            ,p.activo,t.tipo, t.direct_data ,p.obligatoria
        FROM refividrio.encuesta e
            INNER JOIN pregunta p ON p.id_encuesta = e.id_encuesta 
            INNER JOIN tipo t ON t.id_tipo = p.id_tipo 
        WHERE p.id_encuesta =  " . $received_data->idEncuesta  . "
        AND p.activo = true
        ORDER BY p.numero_pregunta";
        $statement = $connect->prepare($query);
        $statement->execute();
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        echo json_encode($data);
    }
    if ($received_data->action == 'fetchallOption') {
        $query = "
        SELECT  
            o.id_opcion,o.nombre As opcion
            ,o.activo As op_activo , o.id_pregunta
            ,o.pocision ,'update' as action,respuesta_extra
        FROM refividrio.encuesta e
                INNER JOIN pregunta p ON p.id_encuesta = e.id_encuesta
                INNER JOIN opciones o ON o.id_pregunta = p.id_pregunta
                INNER JOIN tipo t ON t.id_tipo = p.id_tipo 
        WHERE p.id_pregunta =     " . $received_data->idQuestion . "

        AND o.activo = true
                ORDER BY  o.pocision ";
        $statement = $connect->prepare($query);
        $statement->execute();
        // echo $query;
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        echo json_encode($data);
    }
    
    
    if ($received_data->action == 'insert_answer_extra') {
        $data = array(
            ':id_option' => $received_data->answer_extra->id_option,
            ':value' => $received_data->answer_extra->value,
            ':id_empleado' =>  $_SESSION['id_empleado'], 
        ); 
        $query = "INSERT INTO refividrio.option_answer_free(id_option, value, id_empleado)
                  VALUES (:id_option,:value,:id_empleado)"; 
        $statement = $connect->prepare($query); 
        $statement->execute($data); 
        $output = array(
            'message' => 'Data Inserted'
        ); 
        echo json_encode($output);
    } 


    if ($received_data->action == 'insertAnswer') {
        $data = array(
            ':id_pregunta' => $received_data->respuesta->id_pregunta,
            ':id_empleado' =>  $_SESSION['id_empleado'],// $received_data->respuesta->id_empleado,
            ':id_opcion' => $received_data->respuesta->id_opcion,
            ':id_encuesta' => $received_data->respuesta->id_encuesta,  
            ':respuesta' => $received_data->respuesta->respuesta,
            ':directa' => $received_data->respuesta->directa,  
        ); 
        $query = "INSERT INTO refividrio.res_encuesta_empleado(id_pregunta, id_empleado, id_opcion, id_encuesta, respuesta, directa)
                  VALUES (:id_pregunta,:id_empleado,:id_opcion,:id_encuesta,:respuesta,:directa)"; 
        $statement = $connect->prepare($query); 
        $statement->execute($data); 
        $output = array(
            'message' => 'Data Inserted'
        ); 
        echo json_encode($output);
    } 
    if ($received_data->action == 'inserEncuesta_empleado') {
        $data = array(
            ':id_empleado' => $_SESSION['id_empleado'], 
            ':id_encuesta' => $received_data->id_encuesta, 
        ); 
        $query = "INSERT INTO refividrio.empleado_encuesta(
                         id_empleado, id_encuesta, fechafin, activo, termino, fecha_creado) 
                VALUES (:id_empleado,:id_encuesta,NOW(),true,true,NOW())"; 
        $statement = $connect->prepare($query); 
        $statement->execute($data); 
        $output = array(
            'message' => 'inserEncuesta_empleado Success'
        ); 
        echo json_encode($output);
    }  
    if ($received_data->action == 'validPoll') {
        $query = "
        SELECT  
            CASE WHEN  (CASE WHEN COUNT(*) > 0 THEN  true ELSE  false  END) = false THEN
                CASE WHEN (SELECT COUNT(*) FROM encuesta 
                                WHERE id_encuesta = ".$received_data->id_encuesta."  AND
                                now()::date >=  validodesde 
                                AND now()::date <=  validohasta
                                AND  activo = true 
                        ) > 0 THEN  false ELSE   true END    
            ELSE 
                true
            END  As encuesta_realizada
        FROM empleado_encuesta ee 
        WHERE ee.id_encuesta =".$received_data->id_encuesta." AND id_empleado = " .$_SESSION['id_empleado'] ;
        $statement = $connect->prepare($query);
        $statement->execute();
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        echo json_encode($data);
    }

?>