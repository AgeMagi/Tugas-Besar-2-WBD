<?php
	render('header.php');
?>

<link rel="stylesheet" href="/static/css/base.css">
<link rel="stylesheet" href="/static/css/book_detail.css">

<input
	type="hidden"
	id="user_id"
	value=<?=getJwtData($_COOKIE["Authorization"])->user_id?>
>

<input
	type="hidden"
	id="book_id"
	value=<?=$book->book_id?>
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

	<h2 id="subtitle">Order</h2>
	Jumlah:		
	<select id="banyak-jumlah">
		<?php 
			for ($i=1;$i<101;$i++){
				echo("<option value=$i>$i</option>");
			}
		?>
	</select>


	<button class="submit-button" id="submit-button")">Order</button>

	<div class="submit-order" id="submit-order">
		<div class="modal-content">
			<span class="close">&times;</span>
			<img src="/static/img/checklist.png" id="checklist" alt="photo">
			<div id="tulisan">
				<p id="berhasil">Pemesanan berhasil!</p>
				<p>Nomor Transaksi : <span id="no-transaksi"></span></p>
			</div>
		</div>
	</div><br>
	<h2 id="subtitle">Reviews</h2>
	
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
</div>

<script src="/static/js/book_detail.js"></script>

<?php
        include __STATIC__.'/html/footer.html';
?>