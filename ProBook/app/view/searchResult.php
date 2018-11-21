<?php
    render('header.php');
?>
<title>Search Result</title>
<link rel="stylesheet" href="/static/css/base.css">
<link rel="stylesheet" href="/static/css/search_result.css">
<div class="content search-result">
    <div class="search-result-title row">
        <h1 class="title">Search Result</h1>
        <h2 id="number_results">
            <?php
                $numberResult = sizeof($books);

                echo("Found <span>$numberResult</span> result(s)")
            ?>
        </h2>
    </div>
    <div id="results">
        <?php
            foreach($books as $book) {
                echo(
                    "
                        <div class=\"result row justify-content-between\">
                            <div class=\"result-img\">
                                <img 
                                    src=$book->img_path
                                    src=\"/static/img/contoh_buku.png\"
                                />
                            </div>
                            <div class=\"result-content\">
                                <h1 class=\"result-title\">$book->title</h1>
                                <h2 class=\"result-author\">$book->author - $book->rating/5.0 ($book->jumlah_review votes)</h2>
                                <p class=\"result-description\">
                                    $book->description
                                </p>
                                <div class=\"justify-content-end\">
                                    <a href=\"/book/$book->book_id/\">
                                        <button type=\"submit\"><span>Detail</span></button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    "
                );
            }
        ?>
    </div>
</div>

<?php

include __STATIC__.'/html/footer.html';
?>