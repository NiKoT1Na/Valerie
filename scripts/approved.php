<?php 
session_start();

require "functions.php";

exit_if_user_not_loggedin();

require "conex.php";

if (!isset($_POST['APPROVED'])){

	echo "selecciona una opcion";
	exit;
}

$decision = $_POST['APPROVED'];
$reviewid = $_POST['REVIEWID'];
$postid = $_POST['POST_ID'];
$userid = $_POST['USERID'];

if ($decision == 1 ){

	$texto = "UPDATE reviews SET APPROVED=? WHERE ID='$reviewid'";

	query_with_args($texto, [$decision], "s");
	
	header("Location: ../dashboard.php?approved=1");
	    

	
} if ($decision == 0 ) {

$texto = "DELETE FROM reviews WHERE ID='$reviewid'";
mysqli_query($conectar, $texto);
header("Location: ../dashboard.php?denied=1");
	
}