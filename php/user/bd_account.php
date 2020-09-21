<?php

require_once "../postgres.php";
    session_start();
    $received_data = json_decode(file_get_contents("php://input"));
    $data = array();

    if ($received_data->action == 'fetchAccount') {
        $query = " SELECT e.id_empleado, e.id_segmento, e.id_creadopor, e.fecha_creado, 
                        e.nombre, e.paterno, e.materno, e.activo, e.celular, 
                        e.correo, e.enviar_encuesta, e.genero, e.id_actualizadopor, 
                        e.fecha_actualizado, e.usuario, e.password, e.fecha_nacimiento,
                        s.nombre AS segmento,empresa.empresa_nombre,empresa.id_empresa
                    FROM refividrio.empleado e
                    INNER JOIN refividrio.segmento s ON s.id_segmento = e.id_segmento
                    INNER JOIN refividrio.empresa empresa ON empresa.id_empresa = s.id_empresa 
                    WHERE  id_empleado =".$_SESSION['id_empleado'];
        $statement = $connect->prepare($query);
        $statement->execute();
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        echo json_encode($data);
    } 
    if ($received_data->action == 'update') {
        $data = array(
            ':fecha_nacimiento' => $received_data->data->fecha_nacimiento,
            ':celular'=> $received_data->data->celular,
            ':correo'=> $received_data->data->correo, 
            ':id_actualizadopor' =>  $_SESSION['id_empleado'],  
        ); 
        $query = "UPDATE refividrio.empleado SET 
                                     celular = :celular
                                     ,correo = :correo 
                                     ,fecha_actualizado = CURRENT_TIMESTAMP
                                     ,fecha_nacimiento = :fecha_nacimiento 
                                     ,id_actualizadopor = :id_actualizadopor
                 WHERE id_empleado =".$_SESSION['id_empleado']; 
        $statement = $connect->prepare($query);
        $statement->execute($data);
    
        $output = array(
            'message' => 'data update'
        );
    
        echo json_encode($output);
    }