<?php
	render('header.php');
?>

<link rel="stylesheet" href="/static/css/base.css">
<link rel="stylesheet" href="/static/css/book_detail.css">
<link rel="stylesheet" href="/static/css/search_result.css">

<input
	type="hidden"
	id="user_id"
	value=<?=getUserDetail()["user_id"]?>
>

<input
	type="hidden"
	id="book_id"
	value=<?=$book->id?>
>


<div id="book-detail" class="content">
	<div class="book">
		<div class="kiri">
			<div id="book-title">
				<?php
					echo($book->title);
				?>
			</div>
			<div id="author">
				<?php
					echo($book->author)
				?>	
			</div><br>
			<div id="book-description">
				<?php
					echo($book->description)
				?>
			</div>
		</div>
		<div class="kanan justify-content-center">
			<div class="justify-content-center" id="img-box">
				<img src=<?=$book->imgPath?> class="book-image">	
			</div>
			<div class="rating-detail justify-content-center">
				<div class="star-rating">
					<?php
						$rating = $book->rating;

						for ($i = 0; $i < 5; $i++) {
							if ($rating > 0) {
								echo("<img src=\"/static/img/full_star.png\" class=\"book-rating\">");
								$rating--;
							} else {
								echo("<img src=\"/static/img/starhole.png\" class=\"book-rating\">");
							}
						}
					?>
				</div>				
				<?php
					$rating = $book->rating;
					echo("
						<div class=\"rating-number\">
							<h1>
								$rating/5.0
							</h1>
						</div>")
				?>	
			</div>
			
		</div>
	</div>

	<h2 id="subtitle">Kategori:</h2>
	<?php
		if (sizeOf($book->categories) <= 1) {
			echo("<ul>");
			echo("
				<li>$book->categories</li>
			");
			echo("</ul>");
		} else {
			echo("<ul>");
			for($i = 0; $i < sizeof($book->categories); $i++) {
				$category = $book->categories[$i];
				echo("
					<li>$category</li>
				");
			}
			echo("</ul>");
		}
	?>

	<?php
		if ($book->price != 0) {
			echo("<h2 id=\"subtitle\">Order</h2>");
			echo("<select id=\"banyak-jumlah\">");
			for ($i = 1; $i < 101; $i++) {
				echo("<option value=$i>$i</option>");
			}
			echo("</select>");

			echo("<button class=submit-button id=submit-button>Order</button>");

			echo(`
				<div class="submit-order" id="submit-order">
					<div class="modal-content">
						<span class="close">&times;</span>
						<img src="/static/img/checklist.png" id="checklist" alt="photo">
						<div id="tulisan">
							<p id="berhasil">Pemesanan berhasil!</p>
							<p id="no-transaksi"></p>
						</div>
					</div>
				</div><br>
				<h2 id="subtitle">Reviews</h2>
				
				<div class="token-order" id="token-order">
					<div class="modal-content">
						<span class="close">&times;</span>
						<input type="text" name="token" id="token"/>
						<button class="submit-token-button" id="submit-token-button")">Submit Token</button>
					</div>
				</div>
			`);
		} else {
			echo("<h2 id=\"subtitle\">Not For Sale</h2>");
		}
		
	?>

	<div class="submit-order" id="submit-order">
		<div class="modal-content">
			<span class="close">&times;</span>
			<img src="/static/img/checklist.png" id="checklist" alt="photo">
			<div id="tulisan">
				<p id="berhasil">Pemesanan berhasil!</p>
				<p id="no-transaksi"></p>
			</div>
		</div>
	</div><br>
	<h2 id="subtitle">Reviews</h2>
	
	<div class="token-order" id="token-order">
		<div class="modal-content">
			<span class="close">&times;</span>
			<input type="text" name="token" id="token"/>
			<button class="submit-token-button" id="submit-token-button")">Submit Token</button>
		</div>
	</div>

	<?php
		foreach($reviews as $review) {
			echo("
				<div class=\"review-container\" >
					<div class=\"review\">
						<img src=\"$review->user_img\" class=\"img-review-user\">
						<div class=\"username\">@$review->username</div>
						<div class=\"review-desc\">
							$review->content
						</div>
					</div>
					<div class=\"rate\">
						<img src=\"/static/img/starfull.png\" class=\"starfull\">
						<div class=\"rating\">$review->rating / 5.0</div>
					</div>
				</div>
			");
		}
	?>

	<h2 id="subtitle">Recommendation</h2>
	<?php
		$author = $recommendation->authors[0];
		echo("
		<div class=\"result row justify-content-between\">
			<div class=\"result-img\">
				<img 
					src=$recommendation->imgPath
					src=\"/static/img/contoh_buku.png\"
				/>
			</div>
			<div class=\"result-content\">
				<h1 class=\"result-title\">$recommendation->title</h1>
				<h2 class=\"result-author\">$author - $recommendation->rating/5.0 ($recommendation->jumlah_review votes)</h2>
				<p class=\"result-description\">
					$recommendation->description
				</p>
				<div class=\"justify-content-end\">
					<a href=\"/book/?book_id=$recommendation->id\">
						<button type=\"submit\"><span>Detail</span></button>
					</a>
				</div>
			</div>
		</div>
		")
	?>
</div>

<script src="/static/js/book_detail.js"></script>

<?php
        include __STATIC__.'/html/footer.html';
?>