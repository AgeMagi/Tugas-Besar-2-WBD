<?php
    render('header.php');
?>
<title>History</title>
<link rel="stylesheet" href="/static/css/base.css">
<link rel="stylesheet" href="/static/css/history.css">

<div id="history" class="content">
	<h1 class="title">History</h1>

	<?php
		foreach($orders as $order) {
			$book_id = (int)$order->book_id;

			if ($order->has_review) {
				$status = 'Anda sudah memberikan review';
				$button = '';
			} else {
				$status = 'Belum direview';
				$button = "
					<div class=\"submit-review\">	
						<a href=\"/review/$book_id/?order_id=$order->order_id\">
							<button class=\"submit-button\">Review</button>
						</a>
					</div>
				";
			}

			echo(
				"<div class=\"book-container\">
					<div class=\"bc1\">
						<img src=$order->book_img_path class=\"imghistory\">
						<div class=\"booktitle\">$order->book_title</div>
						<div id=\"jumlah\">Jumlah :&nbsp</div>
						<div class=\"banyakjumlah\">$order->item_count</div>
						<div class=\"status\">$status</div>
					</div>
					<div class=\"bc2\">
						<div class=\"waktupesan\">$order->date</div><br>
						<div class=\"order\">$order->order_id</div>
						<div id=\"NoOrder\">Nomor Order : #</div>
						$button
					</div>
				</div>"
			);
		} 
	?>
</div>

<?php
	include __STATIC__.'/html/footer.html';
?>