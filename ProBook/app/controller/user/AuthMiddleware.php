<?php
    require_once __ROOT__."/util/Routing/IMiddleware.php";
    require_once __ROOT__."/util/Routing/Request.php";
    require_once __ROOT__."/util/Routing/Renderer.php";

    class AuthMiddleware implements IMiddleware {
        function run($next, $nextRequest) {
            if ($_COOKIE["Authorization"]){

                $user_id = verifyJWT($_COOKIE["Authorization"]);
                if ($user_id){
                    $next($nextRequest);
                    exit;
                } else {
                    $url = APP_CONFIG["base_url"]."login/";
                    header('Location: '.$url);
                    exit;
                }
            }  else {
                $url = APP_CONFIG["base_url"]."login/";
                header('Location: '.$url);
                exit;
            }
        }
    }
    
?>