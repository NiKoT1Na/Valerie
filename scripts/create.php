<?php 

session_start();

require "functions.php";

require "conex.php";

$username = $_POST['username'];
$pswrd = $_POST['pswrd'];
$confpswrd = $_POST['confpswrd'];
$email = $_POST['email'];
$confemail = $_POST['confemail'];
$pregunta = $_POST['pregunta'];
$answer = $_POST['answer'];
$fecha = date('Y-m-d H:i:s');
$errores = [];

if (empty($pswrd)){
	array_push($errores, "Contraseña vacia!");
}
if (empty($username)){
	array_push($errores, "Username vacio!");
}
if ($pswrd !== $confpswrd){
	array_push($errores, "Password no coincide con verificacion!");
}
if ($email !== $confemail){
	array_push($errores, "Email no coincide con verificacion!");
}

if (empty($errores)) {

	$textomysql = "INSERT INTO users (USERNAME, PASSWORD, EMAIL, DATE_TIME, QUESTION, ANSWER) VALUES (?,?,?,?,?,?)";

	$stmt = mysqli_prepare($conectar, $textomysql);

	mysqli_stmt_bind_param($stmt, "ssssss", $username, $pswrd, $email, $fecha, $pregunta, $answer);


	mysqli_stmt_execute($stmt);

	mysqli_stmt_close($stmt);

	header("Location: ../index.php?user_created=1");

} else {
	echo implode(', ', $errores);
}