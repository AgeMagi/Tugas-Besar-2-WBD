<?php
    function writeResponse($statusCode,$message,$data=null){
        if ($data){
            $response = array(
                "message" => $message,
                "data" => $data
            );
        } else {
            $response = array(
                "message" => $message,
            );
        }

        http_response_code($statusCode);
        header('Content-Type: application/json');

        echo json_encode($response);
        exit;
    }
?>