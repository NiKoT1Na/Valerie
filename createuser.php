<?php  
require 'ini.php';


require "header.php"; 

require("scripts/conex.php");

require "scripts/functions.php";

redirect_to_home_if_loggedin();

?>


<div ID="wrapper"> 

				
	<div id="redes">
		<span class="titulero">Siguenos en <br> nuestras redes</span><br>
		<a href="https://www.facebook.com/Shine.JennifferJaimes/?fref=ts" target="_blank"><img class="imgsn" src="img/logo-facebook.png" alt=""></a><br>
		<a href="https://www.instagram.com/jenni862/" target="_blank"><img class="imgsn" src="img/logo-ins.png" alt=""></a><br>
		
	</div>

	<div class="createuser" id="principal">
		
		<form class="formu" enctype="multipart/form-data" action="scripts/create.php" method="POST">
			Nombre de usuario <br>
			<input name="username" type="text"><br> <br>
			Contraseña <br>
			<input name="pswrd" type="password"><br> <br>
			Confirma la contraseña <br>
			<input name="confpswrd" type="password"><br> <br>
			E-mail <br>
			<input name="email" type="text"><br> <br>
			Confirma el E-mail <br>
			<input name="confemail" type="text"><br><br>
			Pregunta de seguridad <br>
			<div class="tiny"> en caso de olvidar tu contraseña <br> estas preguntas serviran para reestablecer tu cuenta</div><br>
			<span id="izquierda">Pregunta</span>
			<span id="derecha">Respuesta</span><br><br>
			<select name="pregunta" id="">
				<option value="Segundo apellido de la madre">	Segundo apellido de la madre	</option>
				<option value="Nombre de tu primera mascota">	Nombre de tu primera mascota	</option>
				<option value="Primer numero telefonico">		Primer numero telefonico		</option>
				<option value="Profesor favorito en la escuela">Profesor favorito en la escuela	</option>
			</select>
			<input name="answer" type="text"><br><br>
			<input type="submit" value="Crear Usuario">

				
		</form>


	</div>

	<div id="posts"> 
			
				<?php require "sidebar.php"; ?>

	</div>
	

<?php require "footer.php" ?>