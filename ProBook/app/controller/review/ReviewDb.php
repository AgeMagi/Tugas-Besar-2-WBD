<?php
    require_once __ROOT__."/util/Database.php";
    require_once __ROOT__."/app/controller/review/Review.php";
    require_once __ROOT__."/app/controller/book/BookDb.php";

    class ReviewDb extends Database {
        function __construct(PDO $conn) {
            parent::__construct($conn);
        }

        function getReviewsCount($book_id) {
            $banyak_review = 0;

            $sql = 'SELECT COUNT(*) AS banyak_review FROM review where book_id = ?';
            $stmt = $this->conn->prepare($sql);
            if ($stmt->execute([$book_id])) {
                $row = $stmt->fetch();
                $banyak_review = (int)$row["banyak_review"];
            };

            return $banyak_review;
        }

        function getReviewsByBookId($book_id) {
            $reviews = [];
            $sql = 'SELECT * FROM review WHERE book_id = ?';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$book_id]);

            while ($row = $stmt->fetch()) {
                $review_id = (int) $row["review_id"];
                $user_id = (int) $row["user_id"];
                $book_id = (int) $row["book_id"];
                $content = $row["content"];
                $rating = (float) $row["rating"];

                $review = new Review($review_id, $user_id, $book_id, $content, $rating);
                array_push($reviews, $review);
            }
            return $reviews;
        }

        function createReview($review) {
            $reviewRes = null;
            $sql = 'INSERT INTO review(user_id, book_id, content, rating, order_id) VALUES(?,?,?,?, ?)';
            $stmt = $this->conn->prepare($sql);
            if ($stmt->execute([$review->user_id, $review->book_id, $review->content, $review->rating, $review->order_id])) {
                $review_id = 0;
                $last_insert_id = $this->conn->query("SELECT LAST_INSERT_ID()");
                foreach($last_insert_id as $row) {
                    $review_id = $row["LAST_INSERT_ID()"];
                };
                $reviewRes = new Review($review_id, $review->user_id, $review->book_id, $review->content, $review->rating, $review->order_id);

                $banyak_review = $this->getReviewsCount($review->book_id);
                $bookDb = new BookDb($this->conn);
                $bookRes = $bookDb->updateRating($review->book_id, $review->rating, $banyak_review);
            }

            return $reviewRes;
        }

        function getBookById($id) {
            $books = [];
            $sql = 'SELECT * FROM book WHERE book_id = ?';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id]);

            while($row = $stmt->fetch()) {
                $book_id = (int) $row["book_id"];
                $title = $row["title"];
                $author = $row["author"];
                $description = $row["description"];
                $rating = $row["rating"];
                $img_path = $row["img_path"];

                $book = new Book($book_id, $title, $author, $description, $rating, $img_path);
                array_push($books, $book);
            }
            return $books;
        }
    }

?>