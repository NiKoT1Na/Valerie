<?php 

include("scripts/conex.php");

$query = "SELECT * FROM almacenaje";
$query_result = mysqli_query($conectar, $query);
$todos_los_productos = [];

while($row = mysqli_fetch_row($query_result)) { 
	$time = strtotime($row[5]);
	$row[5] = date("Y-m-d", $time);
	array_push($todos_los_productos, $row);
}

require 'ini.php';


?>


<?php require "header.php" ?>

		<div id="menu"><span> <a href="index.php">INDEX</a> </span> &nbsp; <span> <a href="subida.php">SUBIDA</a> </span><span><pre> otrolink </pre></span><span><pre> y asi </pre></span></div>
	<div ID="wrapper"> 
		
		<div id="redes">
		<span class="titulero">Siguenos en <br> nuestras redes</span><br>
		<a href="https://www.facebook.com/Shine.JennifferJaimes/?fref=ts" target="_blank"><img class="imgsn" src="img/logo-facebook.png" alt=""></a><br>
		<a href="https://www.instagram.com/jenni862/" target="_blank"><img class="imgsn" src="img/logo-ins.png" alt=""></a><br>

		</div>

		<div id="principal">

		<span class="titulero"><pre>este esl el contendido principal
		</pre> 
		</span> <span class="titlesito">SUBE TU PRODUCTO A NUESTRA PAGINA PARA MAYOR PROMOCION Y PUBLICIDAD</span> <br> <br>
		
		<div id="subida"><pre>
SUBIR PRODUCTO
		</pre>
		<form id="formu" enctype="multipart/form-data" action="scripts/uploader.php" method="POST">
		<span>Nombre del producto*</span><br>
		<span id="peque">*no mayor a 30 caracteres</span><br>
		<input name="elnombre" type="text"> <br>
		<select name="tipode" >
			<option selected value="0">Seleccione el tipo de producto</option><br>
			<option value="Arete">Aretes</option>
			<option value="Anillo">Anillos</option>
			<option value="Collar">Collares</option>
			<option value="Pulcera">Pulceras</option>
			<option value="Otro">Otros</option>
		</select><br>
		<span>descripcion del producto</span><br>
		<textarea name="textoart" cols="30" rows="10"></textarea><br>
		<span>Precio</span><br>
		<input name="price" type="text"><br>
		<span>Seleccione la Imagen</span><br>
		<input name="uploadedfile" type="file" /><br>
		<input type="submit" value="Subir archivo" />
		</form>
		</div>
			
		</div>
		<?php require "sidebar.php"; ?>

	</div>
	

<?php require "footer.php" ?>