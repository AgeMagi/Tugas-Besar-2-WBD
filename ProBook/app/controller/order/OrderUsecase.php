<?php
    require_once __ROOT__.'/app/controller/order/OrderDb.php';
    require_once __ROOT__.'/app/controller/order/Order.php';

    class OrderUsecase {
        private $orderDb;
        function __construct($orderDb){
            $this->orderDb = $orderDb;
        }

        function getOrder(Request $request){
            $user_id = getUserDetail()["user_id"];

            $orders = $this->orderDb->getOrder($user_id);

            $data = [
                "orders" => $orders,
            ];
            
            render('history.php', $data);
        }

        function addOrder(Request $request){
            $user_id = (int)$request->payload["userid"];
            $book_id = (int)$request->payload["bookid"];
            $item_count = (int)$request->payload["itemcount"];
            $date = $request->payload["date"];

            $order = new Order(null,$user_id,$book_id,$item_count,$date);
            $order = $this->orderDb->createOrder($order);
            if ($order) {
                writeResponse(200, "Success add order", $order);
            } else {
                writeResponse(500, "Failed add order");
            }
        }

    }
