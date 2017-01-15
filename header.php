<!DOCTYPE html>
<html>
<head>
<link href="https://fonts.googleapis.com/css?family=Indie+Flower" rel="stylesheet">
<link href="css/reset.css" rel="stylesheet" type="text/css">
<link href="css/estilo.css" rel="stylesheet" type="text/css">

<meta charset="UTF-8">
<title>Valerie Bisuteria </title>
<script
  src="https://code.jquery.com/jquery-3.1.1.min.js"
  integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
  crossorigin="anonymous"></script>
 <script>
 	function aviso_creado(){
 		alert('Usuario Creado con exito');
 	}

 	function ajax(query) {
 		$.get("index.php", query, function(data) {
 			var $newPrincipal = $(data).find('#principal');
 			$('#principal').replaceWith($newPrincipal);
 		});
 	}
 </script>
</head>

<body>
<div id="container">

	<header>
		<a href="index.php">
			<img id="titulo" src="img/Header.png" alt="logo">
		</a>
	</header>
	<div id="USERN">
	<?php

	if (isset ($_SESSION['USERNAME'])) {
		echo "Hola " . $_SESSION['USERNAME'] . " bienvenido"."<br>"; 
		echo "<a href='scripts/logout.php'>cerrar sesion</a>";
	} else {
		echo "<span> <a href='login.php'> LOGIN</a></span><br>";
		echo "No estas registrado aun<br>"."<span> <a href='createuser.php'> Crear usuario</a></span>";
	} 
	if (isset($_SESSION['USERISADMIN'])) {
		echo"<br><a href='dashboard.php'>Administrar</a>";
	}

	?>
	</div> 

	<div id="menu"><span> <a href="index.php">INDEX</a> </span> &nbsp; 
	 <?php if (isset ($_SESSION['USERNAME'])) { ?> 
	 <span> <a href="editar.php">SUBIDA </a> </span>&nbsp; 
	 <?php 	} ?> 
	<span>  &nbsp; y asi </span>
</div>
