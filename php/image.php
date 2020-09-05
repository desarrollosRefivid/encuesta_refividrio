
<?php 
require_once "postgres.php";   
    $query = "SELECT encode(file, 'base64') AS file  FROM refividrio.file; ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $data = array();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {   
         $img = "<img src= 'data:image/jpeg;base64, " . $row["file"] . "' />";
          print($img);
    }   