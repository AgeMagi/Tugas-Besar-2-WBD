<?php
	class Order{
		public $order_id;
		public $user_id;
		public $book_id;
		public $item_count;
		public $date;
		public $has_review;
		public $book_title;
		public $book_img_path;

		function __construct($order_id, $user_id, $book_id, $item_count, $date, $has_review = false, $book_title = null, $book_img_path = null) {
			$this->order_id = $order_id;
			$this->user_id = $user_id;
			$this->book_id = $book_id;
			$this->item_count = $item_count;
			$this->date = $date;
			$this->has_review = $has_review;
			$this->book_title = $book_title;
			$this->book_img_path = $book_img_path;
		}

		function getOrderId() {
			return $this->order_id;
		}

		function getUserId() {
			return $this->user_id;
		}

		function getBookId() {
			return $this->book_id;
		}

		function getItemCount() {
			return $this->item_count;
		}

		function getDate() {
			return $this->date;
		}

		function setOrderId($order_id) {
			$this->order_id = $order_id;
		}

		function setUserId($user_id) {
			$this->user_id = $user_id;
		}

		function setBookId($book_id) {
			$this->book_id = $book_id;
		}

		function setItemCount($item_count) {
			$this->item_count = $item_count;
		}

		function setDate($date) {
			$this->date = $date;
		}
	}
?>