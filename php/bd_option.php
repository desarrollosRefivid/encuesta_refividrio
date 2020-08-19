<?php

require_once "postgres.php";

    $received_data = json_decode(file_get_contents("php://input"));
    $data = array();

    // if ($received_data->action == 'fetchall') {
    //     $query = "SELECT * FROM pregunta ORDER BY nombre_pregunta ASC";
    //     $statement = $connect->prepare($query);
    //     $statement->execute();
    //     while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
    //         $data[] = $row;
    //     }
    //     echo json_encode($data);
    // }



// if ($received_data->action == 'fetchSingle') {
//     $query = "SELECT * FROM pregunta WHERE id_pregunta = '" . $received_data->id . "' ";

//     $statement = $connect->prepare($query);

//     $statement->execute();

//     $result = $statement->fetchAll();

//     foreach ($result as $row) {
//         $data['id'] = $row['id_pregunta'];
//         $data['question_name'] = $row['nombre_pregunta'];
//         $data['checked'] = $row['activo'];
//     }

//     echo json_encode($data);
// }

// if ($received_data->action == 'update') {
//     $data = array(
//         ':question_name' => $received_data->question_name,
//         ':checked' => $received_data->checked,
//         ':id'   => $received_data->hiddenId
//     );

//     $query = " UPDATE pregunta SET 
//                 nombre_pregunta = :question_name
//                 ,fecha_actualizado = CURRENT_TIMESTAMP 
//                 ,activo = :checked 
//                 WHERE id_pregunta= :id";

//     $statement = $connect->prepare($query);

//     $statement->execute($data);

//     $output = array(
//         'message' => 'Data Updated'
//     );

//     echo json_encode($output);
// }


if ($received_data->action == 'fetchallOption') {
    $query = "
    SELECT  
    o.id_opcion,o.nombre As opcion
            ,o.activo As op_activo , o.id_pregunta, o.pocision ,'update' as action
    FROM refividrio.encuesta e
            INNER JOIN pregunta p ON p.id_encuesta = e.id_encuesta
            INNER JOIN opciones o ON o.id_pregunta = p.id_pregunta
            INNER JOIN tipo t ON t.id_tipo = p.id_tipo 
    WHERE p.id_pregunta =     " . $received_data->idQuestion . "

     
            ORDER BY  o.pocision ";
    $statement = $connect->prepare($query);
    $statement->execute();
    // echo $query;
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    echo json_encode($data);
}

if ($received_data->action == 'update') {
    $data = array(
        ':nombre' =>  $received_data->model->opcion,
        ':op_activo' => $received_data->model->op_activo,
        ':id_actualizadopor'   =>  $_SESSION['id_empleado'],
        ':pocision' => $received_data->model->pocision,
        ':id_opcion' => $received_data->model->id_opcion,
    ); 
    $query = "UPDATE refividrio.opciones
                SET nombre=:nombre, activo=:op_activo, id_actualizadopor=:id_actualizadopor, 
                fecha_actualizado=CURRENT_TIMESTAMP, pocision=:pocision
            WHERE id_opcion = :id_opcion  ";  
    $statement = $connect->prepare($query); 
    $statement->execute($data); 
    $output = array(
        'message' => 'Data Updated'
    ); 
    echo json_encode($output);
}

if ($received_data->action == 'delete') { 
    $id = $received_data->model->id_opcion;
    $query = "DELETE FROM opciones WHERE id_opcion = '" . $id . "' "; 
    $statement = $connect->prepare($query); 
    $statement->execute(); 
    $output = array(
        'message' => 'Data Deleted'
    ); 
    echo json_encode($output);
}

if ($received_data->action == 'insert') {
    $data = array(
        ':id_pregunta' => $received_data->model->id_pregunta,
        ':nombre' => $received_data->model->opcion,
        ':activo' => $received_data->model->op_activo,
        ':id_creado'   =>  $_SESSION['id_empleado'],
        ':id_actualizadopor'   =>  $_SESSION['id_empleado'],
        ':pocision' => $received_data->model->pocision, 
    ); 
    $query = "INSERT INTO opciones (id_pregunta, id_creado, fecha_creado, nombre, activo, id_actualizadopor, fecha_actualizado, pocision) 
    VALUES (:id_pregunta,:id_creado,CURRENT_TIMESTAMP, :nombre,:activo,:id_actualizadopor,CURRENT_TIMESTAMP,:pocision)";
    $statement = $connect->prepare($query);
    $statement->execute($data);
    $output = array(
        'message' => 'Data Inserted'
    ); 
    echo json_encode($output);
}
?>