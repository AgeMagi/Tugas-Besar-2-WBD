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
            $result = $bookSOAPClient->bookDetail($book_id);

            $data = [
                "book" => $result,
            ];

            render('bookDetail.php', $data);
        }

        function searchBook(Request $request) {
            $query = $request->queries["query"];

            $bookSOAPClient = new SOAPClientUtility();
            $result = $bookSOAPClient->searchBook($query);

            writeResponse(200, "sucess search book", $result);
        }      
        
        function recommendationBook(Request $request) {
            $categories = $request->queries["categories"];

            $bookSOAPClient = new SOAPClientUtility();
            $result = $bookSOAPClient->recommendationBook($categories);

            writeResponse(200, "success get recommendation book", $result);
        }
    }
?>