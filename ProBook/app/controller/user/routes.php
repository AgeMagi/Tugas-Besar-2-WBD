<?php
    function addUserRoutes($router, $userUsecase){
        // $router->add("/api/user/", "POST", array($userUsecase,'registerUser'));
        // $router->add("/api/user/:user_id/", "DELETE", array($userUsecase,'removeUser'));
        // $router->add("/api/user/:user_id/", "PUT", array($userUsecase,'editProfile'));
        // Auth
        $router->add("/register/", "GET", 'render', new AuthMiddleware(), 'register.php');
        $router->add("/register/", "POST", array($userUsecase,'registerUser'));
        $router->add("/login/", "POST", array($userUsecase,'login'));
        $router->add("/login/", "GET", 'render', new AuthMiddleware(), 'login.php');
        $router->add("/profile/", "GET", array($userUsecase,'getProfile'), new AuthMiddleware());
        $router->add("/profile/edit/", "GET", array($userUsecase,'getEditProfile'), new AuthMiddleware());
        $router->add("/profile/edit/", "POST", array($userUsecase,'editProfile'), new AuthMiddleware());

        $router->add("/api/user/validateEmail/", "GET", array($userUsecase,'validateEmail'));
        $router->add("/api/user/validateUsername/", "GET", array($userUsecase,'validateUsername'));
        return $router;
    }
?>