<?php

try {
    $msg = $_POST['msg'];
    $para = $_POST['correo'];
    $title = $_POST['title'];

    if (isset($msg) && isset($para)) {
        $message = "<p>$msg</p>";
        $to_email = $para;
        $subject = $title;
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=UTF-8';
        $headers[] = 'From: Encuestas Refividrio.';

        mail($to_email, $subject, $message, implode("\r\n", $headers));
        echo "Sen email";
    }else{
        echo "Else email";
    }
   
} catch (\Throwable $th) {
   echo $th;
}


