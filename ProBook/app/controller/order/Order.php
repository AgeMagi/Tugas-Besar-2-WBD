<?php
	class Order{
		public $order_book_id;
		public $user_id;
		public $book_id;
		public $ordered_count;
		public $date;
		public $has_review;
		public $book_title;
		public $book_img_path;

		function __construct($order_book_id, $user_id, $book_id, $ordered_count, $date, $has_review = false, $book_title = null, $book_img_path = null) {
			$this->order_book_id = $order_book_id;
			$this->user_id = $user_id;
			$this->book_id = $book_id;
			$this->ordered_count = $ordered_count;
			$this->date = $date;
			$this->has_review = $has_review;
			$this->book_title = $book_title;
			$this->book_img_path = $book_img_path;
		}

		function getOrderBookId() {
			return $this->order_book_id;
		}

		function getUserId() {
			return $this->user_id;
		}

		function getBookId() {
			return $this->book_id;
		}

		function getOrderedCount() {
			return $this->ordered_count;
		}

		function getDate() {
			return $this->date;
		}

		function setOrderBookId($order_book_id) {
			$this->order_book_id = $order_book_id;
		}

		function setUserId($user_id) {
			$this->user_id = $user_id;
		}

		function setBookId($book_id) {
			$this->book_id = $book_id;
		}

		function setOrderedCount($ordered_count) {
			$this->ordered_count = $ordered_count;
		}

		function setDate($date) {
			$this->date = $date;
		}
	}
?>