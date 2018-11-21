<?php

    function addOrderRoutes($router, $orderUsecase){
    	$router->add("/history/", "GET", array($orderUsecase,'getOrder'), new AuthMiddleware());
    	$router->add("/api/order/", "POST", array($orderUsecase, 'addOrder'), new AuthMiddleware());
        // $router->add("/", "GET", $homepage, $middlewareExample);
        // $router->add("/book/:book_id/user/:user_id/", "POST", $postCallbackExample, $middlewareExample);
        // $router->add("/book/:book_id/", "POST", $postCallbackExample, $middlewareExample);

        return $router;
    }

?>