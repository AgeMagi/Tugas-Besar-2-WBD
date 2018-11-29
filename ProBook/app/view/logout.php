<?php

    if ($_COOKIE["Authorization"]){
        $conn = Database::createDBConnection(APP_CONFIG["db"]["host"], 
                                        APP_CONFIG["db"]["user"], 
                                        APP_CONFIG["db"]["password"], 
                                        APP_CONFIG["db"]["db_name"]);
        $userDb = new UserDb($conn);
        $userDb->deleteSessionStorageById($_COOKIE["Authorization"]);
        unset($_COOKIE["Authorization"]);
        setcookie("Authorization",null,time()-3600,"/");
    }
    $url = APP_CONFIG["base_url"]."/login/";
    header('Location: '.$url);
    die();
?>