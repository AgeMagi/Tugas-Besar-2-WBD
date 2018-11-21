<?php
    require_once __ROOT__.'/app/controller/book/BookDb.php';

    class BookUsecase {
        private $bookDb;

        function __construct(BookDb $bookDb){
            $this->bookDb = $bookDb;
        }
        
        function getBookDetail(Request $request) {
            $id = (int)$request->params["book_id"];
            $books = $this->bookDb->getBookById($id);
            $reviews = $this->bookDb->getReviewsDetailByBookId($id);
            if ($books) {
                $data = [
                    "books" => $books,
                    "reviews" => $reviews,
                ];
                
                render('bookDetail.php', $data);
            } else {
                writeResponse(500, 'Failed get book detail');
            }
        }

        function searchBook(Request $request) {
            $title = $request->queries["title"];
            $books = $this->bookDb->getBookByTitle($title);

            $data = [
                "books" => $books,
            ];
            render('searchResult.php', $data);
        }
    }

?>