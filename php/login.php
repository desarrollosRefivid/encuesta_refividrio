<?php 
 
$received_data = json_decode(file_get_contents("php://input")); 
$user = $received_data->user;
$password = $received_data->password; 
$rol =  $received_data->rol;
if ($rol != "0" ) {
    try {
        session_start();   
        $_SESSION['id_empleado'] = $rol->id_empleado;
        $_SESSION['nombre'] = $rol->nombre;
        $_SESSION['paterno'] = $rol->paterno;
        $_SESSION['rol'] = $rol->rol;
        echo 'succes';  
    } catch (\Throwable $th) {
        echo  $th; 
    }   
} else {
    if((!$user) || (!$password)){  
        echo "error";
    }else{   
            require_once "postgres.php"; 
            try {
                $query =  "
                SELECT 	
                    e.id_empleado,e.id_segmento, e.nombre, e.materno, e.paterno, e.genero,e.usuario,r.rol,r.id_rol
                FROM refividrio.empleado e
                INNER JOIN empleado_rol er ON er.id_empleado = e.id_empleado
                INNER JOIN rol r ON r.id_rol = er.id_rol
                WHERE usuario = '".$user."' AND password = md5('".$password."')   
                AND e.activo = true";

                $statement = $connect->prepare($query);
                $statement->execute(); 
                while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                    $data[] = $row;
                }  
                echo json_encode($data);   
            } catch (Exception $e) {
                echo "¡Error!" .  $e->getMessage(); 
            }
            
    }
}




?>