<?php

    if ($_COOKIE["Authorization"]){
        unset($_COOKIE["Authorization"]);
        setcookie("Authorization",null,time()-3600,"/");
    }
    $url = APP_CONFIG["base_url"]."/login/";
    header('Location: '.$url);
    die();
?>