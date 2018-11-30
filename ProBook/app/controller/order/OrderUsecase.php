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
            $sender = $request->payload["sender"];
            $book_id = (int)$request->payload["bookid"];
            $order_count = (int)$request->payload["ordercount"];
            $date = $request->payload["date"];
            $categories = $request->queries["categories"];

            $orderSOAPClient = new SOAPClientUtility();
            $orderStatus = $orderSOAPClient->buyBook($book_id,$order,$sender);

            $order = new Order(null,$user_id,$book_id,$item_count,$date);
           if ($orderStatus["status"]== 0 ) {
            $order = $this->orderDb->createOrder($order);   
            writeResponse(200, "Success add order", $order);
            } 
            else {
                writeResponse(500, "Failed add order");
            }
        }

    }
