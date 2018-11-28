<?php

    function addBookRoutes($router, $bookUsecase){
        $router->add("/search/", "GET", array($bookUsecase, 'searchBook'), null);
        $router->add("/book/", "GET", array($bookUsecase, 'getBookDetail'), new AuthMiddleware());
        $router->add("/recommendation/", "GET", array($bookUsecase, 'recommendationBook'), new AuthMiddleware());
        // $router->add("/", "GET", $homepage, $middlewareExample);
        // $router->add("/book/:book_id/user/:user_id/", "POST", $postCallbackExample, $middlewareExample);
        // $router->add("/book/:book_id/", "POST", $postCallbackExample, $middlewareExample);

        return $router;
    }

?>