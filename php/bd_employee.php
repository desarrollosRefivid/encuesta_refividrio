<?php

require_once "postgres.php";
session_start();

    $received_data = json_decode(file_get_contents("php://input"));
    $data = array();

    if ($received_data->action == 'fetchall') {
        $query = "SELECT e.*, s.nombre As segmento FROM empleado e
                    INNER JOIN segmento s ON s.id_segmento =  e.id_segmento
                        ORDER BY id_empleado DESC";
        $statement = $connect->prepare($query);
        $statement->execute();
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        echo json_encode($data);
    }

    if ($received_data->action == 'insert') {

        try {

        $data = array(
            ':organization' => $received_data->organization,
            ':first_name' => $received_data->firstName,
            ':paternal_name' => $received_data->paternal_name,
            ':maternal_name' => $received_data->maternal_name,
            ':cellphone' => $received_data->cellphone,
            ':emp_email' => $received_data->emp_email,
            ':checked' => $received_data->checked,
            ':age' => $received_data->age,
            ':picked' => $received_data->picked,
            ':checked_poll' => $received_data->checked_poll,
            ':id_creadopor' =>  $_SESSION['id_empleado'],
            ':id_actualizadopor' =>  $_SESSION['id_empleado']
        );
    
        $user1 = strstr($received_data->firstName, ' ', true);
        $value = strstr($received_data->firstName, ' ', true) == '' ? $received_data->firstName : strstr($received_data->firstName, ' ', true);


        $user = $value   .".". $received_data->paternal_name;
        $password = "refividrio";
    
        $query = "INSERT INTO empleado (id_segmento,id_creadopor,fecha_creado,nombre,paterno,materno,activo,celular,correo,enviar_encuesta,genero,id_actualizadopor,fecha_actualizado,usuario,password,fecha_nacimiento) 
                  VALUES (:organization,:id_creadopor,CURRENT_TIMESTAMP,:first_name,:paternal_name,:maternal_name,:checked,:cellphone,:emp_email,:checked_poll,:picked,:id_actualizadopor,CURRENT_TIMESTAMP,LOWER('$user'),md5('$password'),:age)  RETURNING id_empleado";
    
        $statement = $connect->prepare($query);
    
        $statement->execute($data);
    
 
        $result = $statement->fetchAll();
    
        foreach ($result as $row) {
            //echo $row['id_empleado'];
    
            $datarol = array(
                ':idempleado' =>  $row['id_empleado']
            );
    
            $queryrol = "INSERT INTO empleado_rol (id_rol, id_empleado) VALUES (2, :idempleado)";
            $statementrol = $connect->prepare($queryrol);
            $statementrol->execute($datarol);
        }
        
        $output = array(
            'message' => 'Usuario Registrado'
        );
    
        echo json_encode($output); 
    
    } catch (\Throwable $th) {
        echo json_encode($th->errorInfo);
    }
    
    
    }

if ($received_data->action == 'fetchSingle') {
    $query = "SELECT * FROM empleado WHERE id_empleado = '" . $received_data->id . "' ";

    $statement = $connect->prepare($query);

    $statement->execute();

    $result = $statement->fetchAll();
    

    foreach ($result as $row) {
        $data['id'] = $row['id_empleado'];
        $data['organization'] = $row['id_segmento'];
        $data['first_name'] = $row['nombre'];
        $data['paternal_name'] = $row['paterno'];
        $data['maternal_name'] = $row['materno'];
        $data['cellphone'] = $row['celular'];
        $data['emp_email'] = $row['correo'];
        $data['checked'] = $row['activo'];
        $data['age'] = $row['fecha_nacimiento'];
        $data['picked'] = $row['genero'];
        $data['user'] = $row['usuario'];
        $data['checked_poll'] = $row['enviar_encuesta'];
    }

    echo json_encode($data);
}

if ($received_data->action == 'update') {
    $data = array(
        ':organization' => $received_data->organization,
        ':first_name' => $received_data->firstName,
        ':paternal_name' => $received_data->paternal_name,
        ':maternal_name' => $received_data->maternal_name,
        ':cellphone' => $received_data->cellphone,
        ':emp_email' => $received_data->emp_email,
        ':checked' => $received_data->checked,
        ':user' => $received_data->user,
        ':checked_poll' => $received_data->checked_poll,
        ':age' => $received_data->age,
        ':picked' => $received_data->picked,        
        ':id'   => $received_data->hiddenId
    );

    $query = " UPDATE empleado SET 
                id_segmento = :organization
                ,nombre = :first_name
                ,paterno = :paternal_name 
                ,materno = :maternal_name 
                ,celular = :cellphone 
                ,correo = :emp_email 
                ,fecha_actualizado = CURRENT_TIMESTAMP 
                ,activo = :checked 
                ,enviar_encuesta = :checked_poll
                ,fecha_nacimiento = :age
                ,genero = :picked
                ,usuario = :user
                WHERE id_empleado= :id";

    $statement = $connect->prepare($query);

    $statement->execute($data);

    $output = array(
        'message' => 'Usuario Actualizado'
    );

    echo json_encode($output);
}

if ($received_data->action == 'delete') {

    $query = "DELETE FROM empleado WHERE id_empleado = '" . $received_data->id . "' ";

    $statement = $connect->prepare($query);

    $statement->execute();

    $output = array(
        'message' => 'Usuario Eliminado'
    );

    echo json_encode($output);
}
 
// Employe Filter
if ($received_data->action == 'fetchByDepartament') {
    $query = "SELECT e.*,concat(nombre,' ',paterno,' ',materno)As nom_largo FROM empleado e 
                WHERE e.id_segmento = ". $received_data->id_segmento ."
                    ORDER BY nom_largo DESC";
    $statement = $connect->prepare($query);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    echo json_encode($data);
}
 

?>