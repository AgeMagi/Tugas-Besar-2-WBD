<?php
    function addReviewRoutes($router, $reviewUsecase){
        $router->add("/api/review/reviews/:book_id/", "GET", array($reviewUsecase,'getReviews'), new AuthMiddleware());
        $router->add("/review/", "GET", array($reviewUsecase, "getReviewBookDetail"), new AuthMiddleware());
        $router->add("/api/review/", "POST", array($reviewUsecase, 'addReview'), new AuthMiddleware());

        return $router;
    }
?>