<?php

    function addBookRoutes($router, $bookUsecase){
        $router->add("/results/", "GET", array($bookUsecase, 'searchBook'), new AuthMiddleware());
        $router->add("/book/:book_id/", "GET", array($bookUsecase, 'getBookDetail'), new AuthMiddleware());
        // $router->add("/", "GET", $homepage, $middlewareExample);
        // $router->add("/book/:book_id/user/:user_id/", "POST", $postCallbackExample, $middlewareExample);
        // $router->add("/book/:book_id/", "POST", $postCallbackExample, $middlewareExample);

        return $router;
    }

?>