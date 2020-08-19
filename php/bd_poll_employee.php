<?php

require_once "postgres.php";

    $received_data = json_decode(file_get_contents("php://input"));
    $data = array();

    if ($received_data->action == 'fetchall') {
        $query = "
        
        SELECT 
emp.nombre
,emp.paterno
,emp.materno
,emp_enc.id_Empleado_Encuesta
,emp_pre.id_Empleado_Pregunta	
,emp_opt.id_empleado_opcion
,enc.nombre AS Encuesta
,pre.nombre_pregunta AS Pregunta
,opt.nombre AS Opcion
,emp_opt.activo AS Respuesta

FROM Empleado AS emp
	INNER JOIN empleado_encuesta AS emp_enc
		ON emp_enc.id_Empleado =  emp.id_Empleado 
	INNER JOIN empleado_pregunta AS emp_pre
		ON emp_pre.id_Empleado_Encuesta = emp_enc.id_Empleado_Encuesta
	LEFT JOIN empleado_opcion AS emp_opt
		ON emp_opt.id_Empleado_Pregunta = emp_pre.id_Empleado_Pregunta
		
	LEFT JOIN encuesta AS enc
		ON enc.id_encuesta = emp_enc.id_encuesta
	LEFT JOIN pregunta AS pre
		ON pre.id_pregunta = emp_pre.id_pregunta
	LEFT JOIN opciones AS opt
		ON opt.id_opcion = emp_opt.id_opcion		

WHERE
emp.id_Empleado = 9
        ";
        $statement = $connect->prepare($query);
        $statement->execute();
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        echo json_encode($data);
    }

if ($received_data->action == 'insert') {
    $data = array(
        ':company' => $received_data->company,
        ':poll_name' => $received_data->poll_name,
        ':poll_help' => $received_data->poll_help,
        ':poll_validfrom' => $received_data->poll_validfrom,
        ':checked' => $received_data->checked
        
    );

    $query = "INSERT INTO encuesta (id_empresa
                                    ,fecha_creado
                                    ,nombre
                                    ,observaciones
                                    ,activo
                                    ,validodesde
                                    ,fecha_actualizado) 
            VALUES (:company
                    ,CURRENT_TIMESTAMP
                    ,:poll_name
                    ,:poll_help
                    ,:checked
                    ,:poll_validfrom
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
        $data['company'] = $row['id_empresa'];
        $data['poll_name'] = $row['nombre'];
        $data['poll_help'] = $row['observaciones'];
        $data['checked'] = $row['activo'];
        $data['poll_validfrom'] = $row['validodesde'];


    }

    echo json_encode($data);
}

if ($received_data->action == 'update') {
    $data = array(
        ':poll_name' => $received_data->poll_name,
        ':observaciones' => $received_data->poll_help,
        ':company' => $received_data->company,
        ':checked' => $received_data->checked,
        ':id'   => $received_data->hiddenId
    );

    $query = " UPDATE encuesta SET nombre = :poll_name, observaciones = :observaciones ,fecha_actualizado = CURRENT_TIMESTAMP ,activo = :checked ,id_empresa = :company WHERE id_encuesta= :id";

    $statement = $connect->prepare($query);

    $statement->execute($data);

    $output = array(
        'message' => 'Data Updated'
    );

    echo json_encode($output);
}

if ($received_data->action == 'delete') {

    $query = "DELETE FROM encuesta WHERE id_encuesta = '" . $received_data->id . "' ";

    $statement = $connect->prepare($query);

    $statement->execute();

    $output = array(
        'message' => 'Data Deleted'
    );

    echo json_encode($output);
}


if ($received_data->action == 'generatequestion') {

    $query = "SELECT *  FROM generate_question('" . $received_data->id . "')";

    $statement = $connect->prepare($query);

    $statement->execute();

    $output = array(
        'message' => 'Data Generate Question'
    );

    echo json_encode($output);
}

?>