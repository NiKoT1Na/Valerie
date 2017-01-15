<?php 
require 'ini.php';

require "header.php"; 

include("scripts/conex.php");

require "scripts/functions.php";

$review_query = "SELECT reviews.*, users.USERNAME FROM reviews  LEFT JOIN users on reviews.USERID = users.ID  WHERE reviews.APPROVED!=1";

$all_reviews = select($review_query);

?>
<div ID="wrapper"> 
		<div id="redes">
		<span class="titulero">Siguenos en <br> nuestras redes</span><br>
		<a href="https://www.facebook.com/Shine.JennifferJaimes/?fref=ts" target="_blank"><img class="imgsn" src="img/logo-facebook.png" alt=""></a><br>
		<a href="https://www.instagram.com/jenni862/" target="_blank"><img class="imgsn" src="img/logo-ins.png" alt=""></a><br>
		
		</div>
		
		<div id="principal"> <div class="titulero">RESEÑAS PARA APROVAR</div><br><br>
		<?php foreach ($all_review as $review): ?>
		
		<div class='show_review'> <br>
		<?= $review['COMMENT'] ?>
		<form class="formu" enctype="multipart/form-data" action="scripts/approved.php" method="POST">
			<span>Aprobar</span> <br>
			<input type="radio" name="APPROVED" value="1"> <label for="APPROVED">Sí</label>
			<input type="radio" name="APPROVED" value="0"> <label for="APPROVED">No</label><br>
			<div>Hecho por <?= $review['USERNAME']?> </div>
			<input type="hidden" name="REVIEWID" value="<?= $review['ID'] ?>">
			<input type="hidden" name="POSTID" value="<?= $review['POST_ID'] ?>">
			<input type="hidden" name="USERID" value="<?= $review['USERID'] ?>">

			<input type="submit" value="Aprobar">	
			
		</form> 
		* Al elegir No, el post se borrara automaticamente
		


		</div> <br>

		<?php endforeach; ?>



		







		</div>

		<?php require "sidebar.php"; ?>

</div>
	

<?php require "footer.php" ?>
