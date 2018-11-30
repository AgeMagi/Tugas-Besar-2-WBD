<?php
    class Review {
        public $review_id;
        public $user_id;
        public $book_id;
        public $content;
        public $rating;
        public $username;
        public $order_book_id;
        public $user_img;

        function __construct($review_id, $user_id, $book_id, $content, $rating, $order_book_id, $username = null, $user_img = null) {
            $this->review_id = $review_id;
            $this->user_id = $user_id;
            $this->book_id = $book_id;
            $this->content = $content;
            $this->rating = $rating;
            $this->order_book_id = $order_book_id;
            $this->username = $username;
            $this->user_img = $user_img;
        }
    }
?>