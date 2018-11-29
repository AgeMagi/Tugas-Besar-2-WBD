<?php
    $conn = Database::createDBConnection(APP_CONFIG["db"]["host"], 
                                    APP_CONFIG["db"]["user"], 
                                    APP_CONFIG["db"]["password"], 
                                    APP_CONFIG["db"]["db_name"]);
    $session_storage_id = $_COOKIE["Authorization"];
    $http_user_agent = $_SERVER["HTTP_USER_AGENT"];
    $ip_address = $_SERVER["REMOTE_ADDR"];

    $userDb = new UserDb($conn);
    $result = $userDb->getSessionStorage($session_storage_id, $http_user_agent,
                $ip_address);

    $username = $result["username"];
?>

<link rel="stylesheet" href="/static/css/base.css">
<link rel="stylesheet" href="/static/css/header.css">
<nav>
    <div id="header">
        <div id="logo">
            <span style="color:#FFEC5D;">Pro</span><span>-Book</span>
        </div>
        <div class="right-header">
            <a href="" id="header_username">Hi <?= $username ?> </a>
            <a href="/logout/"><img id="logout_img" src="/static/img/logout.png"></a>
        </div>
    </div>
    <div id="menu">
        <a href ="/browse/" class="menu-item" id="menu_browse"> BROWSE </a>
        <a href ="/history/" class="menu-item"  id="menu_history"> HISTORY </a>
        <a href ="/profile/" class="menu-item"  id="menu_profile"> PROFILE </a>
    </div>
</nav>

<script src="/static/js/header.js"></script>
