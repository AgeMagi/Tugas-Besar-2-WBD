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
            $user_id = (int)$request->payload["user_id"];
            $sender_card_number = $this->orderDb->getCardNumberOrder($user_id);
            $book_id = $request->payload["book_id"];
            $ordered_count = $request->payload["ordered_count"];
            $date = $request->payload["date"];
            $token = $request->payload["token"];

            $orderSOAPClient = new SOAPClientUtility();
            $orderStatus = $orderSOAPClient->buyBook($book_id, $ordered_count, $sender_card_number, $token);
   
            $order = new Order(null,$user_id,$book_id,$ordered_count,$date);
            if ($orderStatus->status == 0 ) {
                $order = $this->orderDb->createOrder($order);   
            } 
            $data = [
                "order" => $order,
                "order_status" => $orderStatus,
            ];
            writeResponse(200, "Success add order", $data);
        }

    }
