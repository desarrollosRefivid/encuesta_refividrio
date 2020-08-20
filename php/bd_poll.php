<?php

require_once "postgres.php"; 
$received_data = json_decode(file_get_contents("php://input"));
$data = array(); 

if ($received_data->action == 'fetchall') {
    $query = "SELECT * FROM encuesta ORDER BY id_encuesta DESC";
    $statement = $connect->prepare($query);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    echo json_encode($data);
}



if ($received_data->action == 'insert') {
    $data = array( 
        ':poll_name' => $received_data->poll_name,
        ':poll_help' => $received_data->poll_help,
        ':poll_validfrom' => $received_data->poll_validfrom,
        ':poll_validUntil' => $received_data->poll_validUntil,
        ':checked' => $received_data->checked
        
    ); 
    $query = "INSERT INTO encuesta ( fecha_creado
                                    ,nombre
                                    ,observaciones
                                    ,activo
                                    ,validodesde
                                    ,validohasta
                                    ,fecha_actualizado) 
            VALUES ( 
                     CURRENT_TIMESTAMP
                    ,:poll_name
                    ,:poll_help
                    ,:checked
                    ,:poll_validfrom
                    ,:poll_validUntil
                    ,CURRENT_TIMESTAMP)";

    $statement = $connect->prepare($query); 
    $statement->execute($data); 
    $output = array(
        'message' => 'Data Inserted'
    ); 
    echo json_encode($output);
}

if ($received_data->action == 'fetchSingle') {
    $query = "SELECT * FROM encuesta WHERE id_encuesta = '" . $received_data->id . "' ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        $data['id'] = $row['id_encuesta'];
        $data['poll_name'] = $row['nombre'];
        $data['poll_help'] = $row['observaciones'];
        $data['checked'] = $row['activo'];
        $data['poll_validfrom'] = $row['validodesde'];
        $data['poll_validUntil'] = $row['validohasta'];
    }
    echo json_encode($data);
}

session_start();
if ($received_data->action == 'copy') {
    $query = "";
    try {
        $query = "SELECT refividrio.copy_poll('" . $received_data->name . "' , " . $received_data->id_encuesta . " , " . $_SESSION['id_empleado'] .
        ",'" . $received_data->validfrom . "' , '" . $received_data->validUntil . "'  ) as results";
    
       $statement = $connect->prepare($query);
       $statement->execute();
       $result = $statement->fetchAll();
       foreach ($result as $row) {
           $data['results'] = $row['results']; 
       }
       echo json_encode($data);
    } catch (\Throwable $th) {
        //throw $th;
        echo  $th . "  "  ;
    }
   
}
  

if ($received_data->action == 'update') {
    try {
        $data = array(
            ':poll_name' => $received_data->poll_name,
            ':observaciones' => $received_data->poll_help, 
            ':checked' => $received_data->checked, 
            ':validohasta'   => $received_data->poll_validUntil,
            ':validodesde'   => $received_data->poll_validfrom,
            ':id'   => $received_data->hiddenId 
        );
        $query = " UPDATE encuesta SET nombre = :poll_name, observaciones = :observaciones ,fecha_actualizado = CURRENT_TIMESTAMP 
        ,activo = :checked,validohasta = :validohasta, validodesde = :validodesde
        WHERE id_encuesta= :id";
        $statement = $connect->prepare($query);
        $statement->execute($data);
        $output = array(
            'message' => 'Data Updated'
        ); 
        echo json_encode($output); 
    } catch (PDOException $e) {
        echo json_encode($e);
    } 
}

if ($received_data->action == 'delete') {

    try {
        $query = "DELETE FROM encuesta WHERE id_encuesta = '" . $received_data->id . "' ";
        $statement = $connect->prepare($query);
        $statement->execute();
        $output = array(
            'message' => 'Data Deleted'
        );
        echo json_encode($output);
    } catch (Exception $th) {
        echo json_encode($th->errorInfo);
    } 
} 
// if ($received_data->action == 'generatequestion') {

//     $query = "SELECT *  FROM generate_question('" . $received_data->id . "')";

//     $statement = $connect->prepare($query);

//     $statement->execute();

//     $output = array(
//         'message' => 'Data Generate Question'
//     );

//     echo json_encode($output);
// }
// Filter Report 
if ($received_data->action == 'fetchByType') {
    $query = "SELECT  * FROM encuesta
    WHERE  
	CASE WHEN " . $received_data->typePoolSelected . "= 2 THEN 
		  (   activo = true 
			  AND now()::date >= validodesde 
              AND now()::date <= validohasta  )
	WHEN " . $received_data->typePoolSelected . "= 0 THEN
		true
	ELSE 
      	(  now()::date > validohasta )
	END";
    $statement = $connect->prepare($query);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    echo json_encode($data);
}

?>