<?php
    require_once __ROOT__."/util/Database.php";
    require_once __ROOT__."/app/controller/book/Book.php";

    class BookDb extends Database{
        function __construct(PDO $conn) {
            parent::__construct($conn);
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

        function getBookByTitle($title) {
            $books = [];
            $sql = "SELECT * FROM book WHERE title LIKE ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["%$title%"]);

            while($row = $stmt->fetch()) {
                $book_id = (int) $row["book_id"];
                $title = $row["title"];
                $author = $row["author"];
                $description = $row["description"];
                $rating = $row["rating"];
                $img_path = $row["img_path"];

                $sqlReview = "SELECT COUNT(*) as jumlah_review FROM review WHERE book_id = ?";
                $stmtReview = $this->conn->prepare($sqlReview);
                $stmtReview->execute([$book_id]);
                $row = $stmtReview->fetch();
                $jumlah_review = (int) $row["jumlah_review"];


                $book = new Book($book_id, $title, $author, $description, $rating, $img_path, $jumlah_review);
                

                array_push($books, $book);
            }

            return $books;
        }

        function updateRating($book_id, $rating, $banyak_review) {
            $books = $this->getBookById($book_id);
            $now_rating = $books[0]->rating;
            $new_rating = ((float)($now_rating * $banyak_review + $rating) / (float)($banyak_review + 1));

            $book = null;
            $sql = "UPDATE book SET rating = ? where book_id = ?";
            $stmt = $this->conn->prepare($sql);
            if ($stmt->execute([$new_rating, $book_id])) {
                $book = new Book($book_id, null, null, null, $new_rating);
            }

            return $book;
        }

        function getReviewsDetailByBookId($book_id) {
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
                
                $sqlUser = 'SELECT username, img_path FROM user WHERE user_id = ?';
                $stmtUser = $this->conn->prepare($sqlUser);
                $stmtUser->execute([$user_id]);
                $rowUser = $stmtUser->fetch();
                $username = $rowUser['username'];
                $imgPath = $rowUser['img_path'];
                

                $review = new Review($review_id, $user_id, $book_id, $content, $rating, null, $username, $imgPath);
                array_push($reviews, $review);
            }
            return $reviews;
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

        function getBookRating($book_id) {
            $banyak_review = $this->getReviewsCount($book_id);
            if ($banyak_review == 0) {
                return 0;
            } else {
                $total_review = 0;
                $sql = 'SELECT SUM(rating) AS total_rating FROM review where book_id=?';
                $stmt = $this->conn->prepare($sql);
                if ($stmt->execute([$book_id])) {
                    $row = $stmt->fetch();
                    $total_review = (int)$row["total_rating"];
                };

            }
            return $total_review/$banyak_review;
        }
    }

?>