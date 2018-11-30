<?php
    require_once __ROOT__."/util/Database.php";
    require_once __ROOT__."/app/controller/order/Order.php";
    require_once __ROOT__.'/util/SOAPClient.php';

    class OrderDb extends Database{

        function __construct(PDO $conn){
        	parent::__construct($conn);
        }

        function getOrderById($id) {
        	$order = null;
        	$sql = 'SELECT * FROM order_book WHERE order_book_id = ?';
        	$stmt = $this->conn->prepare($sql);
        	if ($stmt->execute([$id])) {
        		$row = $stmt->fetch();
        		$order_book_id = (int) $row["order_book_id"];
        		$user_id = (int) $row["user_id"];
        		$book_id = $row["book_id"];
        		$ordered_count = $row["ordered_count"];
        		$date = $row["order_date"];

        		$order = new Order($order_book_id, $user_id, $book_id, $ordered_count, $date);
        	};
        	return $order;
        }

        function getOrder($id) {
        	$orders = [];
        	$sql = 'SELECT * FROM order_book WHERE user_id = ? ORDER BY order_book_id DESC';
        	$stmt = $this->conn->prepare($sql);
        	$stmt->execute([$id]);

        	while($row = $stmt->fetch()){
        		$order_book_id = (int) $row["order_book_id"];
        		$user_id = (int) $row["user_id"];
        		$book_id = $row["book_id"];
        		$ordered_count = $row["ordered_count"];
        		$date = $row["order_date"];

				$sqlBook = 'SELECT * FROM review WHERE user_id = ? AND book_id = ? AND order_book_id = ?';
				$stmtBook = $this->conn->prepare($sqlBook);
				$stmtBook->execute([$user_id, $book_id, $order_book_id]);
				if ($stmtBook->fetch()) {
					$has_review = true;
				} else {
					$has_review = false;
				}

				$bookSOAPClient = new SOAPClientUtility();
            	$book = $bookSOAPClient->bookDetail($book_id);

				$order = new Order($order_book_id, $user_id, $book_id, $ordered_count, $date, $has_review, $book->title, $book->imgPath);
        		array_push($orders,$order);
			};
        	return $orders;
        }

        function createOrder($order) {
        	$orderRes = null;
        	$sql = 'INSERT INTO order_book(user_id,book_id,ordered_count,order_date) VALUES (?,?,?,?)';
        	$stmt = $this->conn->prepare($sql);

        	if ($stmt->execute([$order->user_id, $order->book_id, $order->ordered_count, $order->date])) {
        		$order_book_id = 0;
        		$last_insert_id = $this->conn->query("SELECT LAST_INSERT_ID()");
        		foreach($last_insert_id as $row){
        			$order_book_id = $row["LAST_INSERT_ID()"];
        		}
        		$orderRes = new Order($order_book_id,$order->user_id, $order->book_id, $order->ordered_count, $order->date);
        	}
        	return $orderRes;
        }

		function getCardNumberOrder($user_id) {
			$card_number = "";
			$sql = 'SELECT card_number FROM user where user_id=?';
			$stmt = $this->conn->prepare($sql);

			if ($stmt->execute([$user_id])) {
				$row = $stmt->fetch();
				$card_number = $row["card_number"];
			}

			return $card_number;
		}
    }

?>