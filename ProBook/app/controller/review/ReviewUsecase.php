<?php
    require_once __ROOT__.'/app/controller/review/ReviewDb.php';
    require_once __ROOT__.'/util/SOAPClient.php';

    class ReviewUseCase {
        private $reviewDb;

        function __construct(ReviewDb $reviewDb){
            $this->reviewDb = $reviewDb;
        }

        function getReviews(Request $request) {
            $book_id = (int)$request->params["book_id"];
            $reviews = $this->reviewDb->getReviewsByBookId($book_id);
            writeResponse(200, "Success get reviews by book id : %".$book_id."%", $reviews);
        }

        function addReview(Request $request) {
            $user_id = (int)$request->payload["user_id"];
            $book_id = $request->payload["book_id"];
            $content = $request->payload["content"];
            $rating = (int)$request->payload["rating"];
            $order_book_id = (int)$request->payload["order_book_id"];

            $review = new Review(null, $user_id, $book_id, $content, $rating, $order_book_id);
            $review = $this->reviewDb->createReview($review);
            if ($review) {
                header('Location: /history/');
            } else {
                writeResponse(500, "Failed add review");
            }
            exit();
        }

        function getReviewBookDetail(Request $request) {
            $book_id = $request->queries["book_id"];

            $bookSOAPClient = new SOAPClientUtility();
            $book = $bookSOAPClient->bookDetail($book_id);

            $data = [
                "book" => $book,
            ];
            render("review.php", $data);
        }
    }
?>  