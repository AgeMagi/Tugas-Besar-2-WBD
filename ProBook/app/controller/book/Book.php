<?php    
    class Book {
        public $book_id;
        public $title;
        public $author;
        public $description;
        public $rating; 
        public $img_path;
        public $jumlah_review;

        function __construct($book_id = "", $title = "", $author = "", $description = "", $rating = 0, $img_path = null, $jumlah_review = 0) {
            $this->book_id = $book_id;
            $this->title = $title;
            $this->author = $author;
            $this->description = $description;
            $this->rating = $rating;
            $this->img_path = $img_path;
            $this->jumlah_review = $jumlah_review;
        }
    
        function getBookId() {
            return $this->book_id;
        }
        function getTitle() {
            return $this->title;
        }   
        function getAuthor() {
            return $this->author;
        }
        function getDescription() {
            return $this->description;
        }
        function getRating() {
            return $this->$rating;
        }

        function setBookId($book_id) {
            $this->book_id = $book_id;
        }
        function setTitle($title) {
            $this->title = $title;
        }
        function setAuthor($author) {
            $this->author = $author;
        }
        function setDescription($description) {
            $this->description = $description;
        }
        function setRating($rating) {
            $this->rating = $rating;
        }
    }

?>