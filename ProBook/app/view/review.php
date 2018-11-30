<?php
    render('header.php');

    $result = getUserDetail();

    $user_id = $result["user_id"];
?>
<title>Review</title>
<link rel="stylesheet" href="/static/css/base.css">
<link rel="stylesheet" href="/static/css/review.css">

<?php
    $author = $book->authors[0];
?>

<div class="review-container content">
    <div class="row justify-content-between"> 
        <div class="review-title">
            <div class="title">
                    <h1 id="review-title">
                        <?php
                            echo($book->title)
                        ?>
                    </h1>
            </div>
            <h2 id="review-author">
                <?php
                    echo($author)
                ?>
            </h2>
        </div>
        <div id="gambar">
            <div id="image-box" class="justify-content-center">
                <img 
                    class="book-img"
                    src=<?= $book->imgPath?>
                >
            </div>
        </div>
    </div>
    <div class="review-header">
        <h1>Add Rating</h1>
        <div class="row justify-content-center review-rating">
            <img 
                id=star-0
                key=0
                src="/static/img/full_star.png"
            />
            <img 
                id=star-1
                key=1
                src="/static/img/empty_star.png"
            />
            <img 
                id=star-2
                key=2
                src="/static/img/empty_star.png"
            />
            <img 
                id=star-3
                key=3
                src="/static/img/empty_star.png"
            />
            <img 
                id=star-4
                key=4
                src="/static/img/empty_star.png"
            />
        </div>
    </div>
    <div class="review-header">
        <h1>Add Comment</h1>
    </div>
    <form action="/api/review/" method="POST">
        <textarea
            name="content"
            rows="10"
            class="review-comment"
            required
        ></textarea>
        <input 
            type="hidden"
            name="rating"
            id="rating"
        />
        <?php
            echo("
                <input 
                    type=\"hidden\"
                    name=\"user_id\"
                    value=$user_id
                />
            ")
        ?>
        <?php
            $book_id = $book->id;
            echo("
                <input 
                    type=\"hidden\"
                    name=\"book_id\"
                    value=$book_id
                />
            ")
        ?>
        <?php
            $order_id = (int)$_GET["order_id"];

            echo("
                <input
                    type=\"hidden\"
                    name=\"order_id\"
                    value=$order_id
                />
            ")
        ?>
        <div class="justify-content-between">
            <div class='review-back'>
                <a href="/history/">
                        <span>Back</span>
                </a>
            </div>
            <button
                class='review-submit'
                id='review-submit'
            >
                <span>Submit</span>
            </button>
        </div>
    </form>
    
</div>

<script src='/static/js/review.js'></script>

<?php
    include __STATIC__.'/html/footer.html';
?>