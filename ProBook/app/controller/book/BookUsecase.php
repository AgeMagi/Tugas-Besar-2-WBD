<?php
    require_once __ROOT__.'/app/controller/book/BookDb.php';
    require_once __ROOT__.'/util/SOAPClient.php';

    class BookUsecase {
        private $bookDb;

        function __construct(BookDb $bookDb){
            $this->bookDb = $bookDb;
        }
        
        function getBookDetail(Request $request) {
            $book_id = $request->queries["book_id"];

            $bookSOAPClient = new SOAPClientUtility();
            $book = $bookSOAPClient->bookDetail($book_id);
            $recommendation = $bookSOAPClient->recommendationBook([$book->category]);

            $data = [
                "book" => $book,
                "recommendation" => $recommendation,
            ];

            render('bookDetail.php', $data);
        }

        function searchBook(Request $request) {
            $query = $request->queries["query"];

            $bookSOAPClient = new SOAPClientUtility();
            $books = $bookSOAPClient->searchBook($query);
            
            foreach($books as $book) {
                $rating = $this->bookDb->getReviewsCount($book-id);
                $book->rating = $rating;
            }

            writeResponse(200, "sucess search book", $books);
        }      
        
        function recommendationBook(Request $request) {
            $categories = $request->queries["categories"];

            $bookSOAPClient = new SOAPClientUtility();
            $book = $bookSOAPClient->recommendationBook($categories);

            writeResponse(200, "success get recommendation book", $book);
        }
    }
?>