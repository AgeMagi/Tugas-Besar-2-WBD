<?php
    require_once __ROOT__."/util/Routing/IMiddleware.php";
    require_once __ROOT__."/util/Routing/Request.php";
    require_once __ROOT__."/util/Routing/Renderer.php";
    require_once __ROOT__.'/util/Database.php';
    require_once __ROOT__.'/app/controller/user/UserDb.php';

    class AuthMiddleware implements IMiddleware {
        function run($next, $nextRequest) {
            if ($_COOKIE["Authorization"]){
                $session_storage_id = $_COOKIE["Authorization"];
                $http_user_agent = $_SERVER["HTTP_USER_AGENT"];
                $ip_address = $_SERVER["REMOTE_ADDR"];

                $conn = Database::createDBConnection(APP_CONFIG["db"]["host"], 
                                        APP_CONFIG["db"]["user"], 
                                        APP_CONFIG["db"]["password"], 
                                        APP_CONFIG["db"]["db_name"]);

                $userDb = new UserDb($conn);
                $result = $userDb->getSessionStorage($session_storage_id, $http_user_agent,
                                    $ip_address);
                $deleteSession = $userDb->deleteExpiredSessionStorage();
                if ($result) {
                    setcookie("Authorization", $session_storage_id, time() + 300, '/');
                    if ($nextRequest == "register.php" || $nextRequest == "login.php") {
                        $url = APP_CONFIG["base_url"]."browse/";
                        header('Location: '.$url);
                        exit;
                    } else {
                        $next($nextRequest);
                        exit;
                    }                    
                } else {
                    unset($_COOKIE["Authorization"]);
                    setcookie("Authorization", null, -1, '/');
                    $url = APP_CONFIG["base_url"]."login/";
                    header('Location: '.$url);
                    exit;
                }
            }  else {
                $conn = Database::createDBConnection(APP_CONFIG["db"]["host"], 
                                        APP_CONFIG["db"]["user"], 
                                        APP_CONFIG["db"]["password"], 
                                        APP_CONFIG["db"]["db_name"]);
                $userDb = new UserDb($conn);
                $deleteSession = $userDb->deleteExpiredSessionStorage();

                if ($nextRequest == "login.php" || $nextRequest == "register.php") {
                    $next($nextRequest);
                } else {
                    $url = APP_CONFIG["base_url"]."login/";
                    header('Location: '.$url);
                    exit;
                }
               
            }
        }
    }
    
?>