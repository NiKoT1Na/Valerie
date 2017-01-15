<?php 
require 'ini.php';

require "header.php"; 

include("scripts/conex.php");

require "scripts/functions.php";

exit_if_user_not_loggedin();

$POSTID = "";

if (isset ($_GET['prod_id'])){
	$POSTID = $_GET['prod_id'];
}



?>


<div ID="wrapper"> 

				
		<div id="redes">
		<span class="titulero">Siguenos en <br> nuestras redes</span><br>
		<a href="https://www.facebook.com/Shine.JennifferJaimes/?fref=ts" target="_blank"><img class="imgsn" src="img/logo-facebook.png" alt=""></a><br>
		<a href="https://www.instagram.com/jenni862/" target="_blank"><img class="imgsn" src="img/logo-ins.png" alt=""></a><br>
		
		</div>

		<div id="ppal">
		

		<form class="formu" enctype="multipart/form-data" action="scripts/reviewscript.php" method="POST">
		<span>ESCRIBE TU RESEÑA</span><br><br>
		<textarea name="reviewtext" id="" cols="30" rows="10"></textarea><br><br>
		<input type="radio" name="RATING" value="1"> <label for="RATING">1</label>
		<input type="radio" name="RATING" value="2"> <label for="RATING">2</label>
		<input type="radio" name="RATING" value="3" checked> <label for="RATING">3</label>
		<input type="radio" name="RATING" value="4"> <label for="RATING">4</label>
		<input type="radio" name="RATING" value="5"> <label for="RATING">5</label>
		<input type="hidden" name="PRODID" value='<?= $POSTID ?>'>
		<input type="submit" value="Hecho"/>

			

		</form>


		</div>

</div>	

<?php require "footer.php" ?>