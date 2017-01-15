<?php 

require 'ini.php';


include("scripts/conex.php");



require "header.php"; 

require "scripts/functions.php";


if(isset($_GET['userid'])){

	$USERID = $_GET['userid'];
}

echo $userid;


$query = "SELECT * FROM users WHERE ID=$USERID";
$query_result = mysqli_query($conectar, $query);
$query_result = mysqli_fetch_array($query_result);

$user = $query_result[1];

$query_post = "SELECT * FROM reviews WHERE USERID=$USERID";
$query_post_result = mysqli_query($conectar, $query_post);
$todos_los_reviews = [];

while($row = mysqli_fetch_assoc($query_post_result)) { 
	array_push($todos_los_reviews, $row);
} 




?>




<div ID="wrapper"> 

				
		<div id="redes">
		<span class="titulero">Siguenos en <br> nuestras redes</span><br>
		<a href="https://www.facebook.com/Shine.JennifferJaimes/?fref=ts" target="_blank"><img class="imgsn" src="img/logo-facebook.png" alt=""></a><br>
		<a href="https://www.instagram.com/jenni862/" target="_blank"><img class="imgsn" src="img/logo-ins.png" alt=""></a><br>
		
		</div>

		<div id="principal">
			<span class="titlesito">Perfil de</span>
			<br><div class="titulero"> <?= $user; ?> </div><br>

			<?php foreach ($todos_los_reviews as $review): ?>
				
				<div class='show_review'><pre><?= print_r($review) ?>
					
				</div>
				
			<?php endforeach; ?>

		</div>
		<div id="posts"> 
			
			<span class="titulero">aca van <br> los posts</span><br>
			aca un link <br>
			aca otro <br>
			y otro <br>
			y asi <br>
			
		</div>


	</div>
	

<?php require "footer.php" ?>