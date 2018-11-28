<?php
    define('__ROOT__', dirname(dirname(__FILE__)));

    define('APP_CONFIG', include(__ROOT__."/config/devel.php"));
    define('__CONTROLLER__', __ROOT__.'/app/controller');
    define('__VIEW__', __ROOT__.'/app/view');
    define('__STATIC__', __ROOT__.'/public/static');
    define('__UTIL__', __ROOT__.'/util');

    require_once __ROOT__.'/util/Routing/Router.php';
    require_once __ROOT__.'/util/Routing/Request.php';
    require_once __ROOT__.'/util/Database.php';
    // book
    require_once __CONTROLLER__.'/book/BookUsecase.php';
    require_once __CONTROLLER__.'/book/BookDb.php';
    //review
    require_once __CONTROLLER__.'/review/ReviewUsecase.php';
    require_once __CONTROLLER__.'/review/ReviewDb.php';
    // order
    require_once __CONTROLLER__.'/order/OrderUsecase.php';
    require_once __CONTROLLER__.'/order/OrderDb.php';
    // user
    require_once __CONTROLLER__.'/user/UserUsecase.php';
    require_once __CONTROLLER__.'/user/UserDb.php';
    require_once __CONTROLLER__.'/user/AuthMiddleware.php';
    // routes
    require_once __CONTROLLER__.'/book/routes.php';
    require_once __CONTROLLER__.'/order/routes.php';
    require_once __CONTROLLER__.'/user/routes.php';
    require_once __CONTROLLER__.'/review/routes.php';

    require_once __UTIL__.'/SOAPClient.php';

    $conn = Database::createDBConnection(APP_CONFIG["db"]["host"], 
                                        APP_CONFIG["db"]["user"], 
                                        APP_CONFIG["db"]["password"], 
                                        APP_CONFIG["db"]["db_name"]);
                                        
    $authMiddleware = new AuthMiddleware();
    $userDb = new UserDb($conn);
    $userUsecase = new UserUsecase($userDb);
    $bookDb = new BookDb($conn);
    $bookUsecase = new BookUsecase($bookDb);
    $reviewDb = new ReviewDb($conn);
    $reviewUsecase = new ReviewUsecase($reviewDb);
    $orderDb = new OrderDb($conn);
    $orderUsecase = new OrderUsecase($orderDb);

    $router = new Router();

    $router = addUserRoutes($router, $userUsecase);
    $router = addBookRoutes($router, $bookUsecase);
    $router = addOrderRoutes($router, $orderUsecase);
    $router = addReviewRoutes($router, $reviewUsecase);

    $router->add("/browse/", "GET", 'render', $authMiddleware, 'browse.php');
    $router->add("/book-detail/", "GET", 'render', null, 'book_detail.php');
    $router->add("/logout/", "GET", 'render', $authMiddleware, 'logout.php');

// TODO: Add Order Routes
    
    $errorCallback = function(){
        writeResponse(404, "Page not found.");
    };
    
    $uri = $_SERVER['PATH_INFO'];
    $method = $_SERVER['REQUEST_METHOD'];
    
    $router->route($uri, $method, $errorCallback);
?>
