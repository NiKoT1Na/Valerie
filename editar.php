<?php 

require 'ini.php';

require "header.php";

require "scripts/conex.php";

require "scripts/functions.php";

exit_if_user_not_loggedin();

$query_categorias = "SELECT * FROM categorias";
$all_categorias = select($query_categorias);


if (isset ($_GET['prod_id'])){
	$elid = $_GET['prod_id'];


	$query = "SELECT * FROM almacenaje";
	$query_result = mysqli_query($conectar, $query);
	$todos_los_productos = [];

	while($row = mysqli_fetch_row($query_result)) { 
		$time = strtotime($row[5]);
		$row[5] = date("Y-m-d", $time);
		array_push($todos_los_productos, $row);
	}


	foreach ($todos_los_productos as $item){
		if ($item[6] === $elid)
		{
			$newitem = $item;
		}
	}
}
if (!isset($elid)){
	$newitem = ["", "", "", "", "", "", ""];
}

if (isset($_GET['prod_id'])) {
	$form_url = 'scripts/editer.php?prod_id=' . $_GET['prod_id'];
} else {
  $form_url = 'scripts/editer.php';
}


$query_tag = "SELECT * FROM TAGS ";
$all_tags = select($query_tag);



?>




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
		
		<div id="subida">
    <h1>SUBIR PRODUCTO</h1>

    	<form class="formu" enctype="multipart/form-data" action="<?= $form_url ?>" method="POST">
		<span>Nombre del producto*</span><br>
		<span id="peque">*no mayor a 30 caracteres</span><br>
		<input name="elnombre" type="text" value="<?= $newitem[0]?>"> <br>


		<?php 

			$opciones = [];

			$opciones_plural = [];



			foreach ($all_categorias as $categoria){
					
					array_push($opciones, $categoria['NOMBRE']);
					array_push($opciones_plural, $categoria['PLURAL']);


			}

			$selected = "";
			 			
  function create_option($value, $texto, $selected){
    $sel = "";
    if ($selected) {
      $sel = "selected";
    }
    echo "<option $sel value='$value'>$texto</option>";
  }
		?>

		 
      <select name="tipode" >
		<option >Seleccione el tipo de producto</option><br>
			  
		<?php foreach ($opciones as $indice => $option):
			$plural = $opciones_plural[$indice];
			create_option($option, $plural, $newitem[4] === $option);
      ?>
    <?php endforeach; ?>
        
        
    </select>
		<br><span>descripcion del producto</span><br>
		<textarea name="textoart" cols="30" rows="10"><?= $newitem[2]?></textarea><br>
		<span>ETIQUETAS**</span><br>
		<span id="peque">**Separadas por comas ","</span><br>
		<?php 	

		$prod_id = $newitem[6];
		$tag_string = "";

		if (!empty($prod_id)) {

			$query_tag = "SELECT almacenaje.NOMBRE, almacenaje.ID, tags.ID AS ID_TAG, tags.NOMBRE AS NOMBRE_TAG FROM almacenaje 
							LEFT JOIN almacenaje_tags ON almacenaje.id = almacenaje_tags.PROD_ID
							LEFT JOIN tags ON almacenaje_tags.TAG_ID = tags.ID WHERE almacenaje.ID = $prod_id";

			$all_tags_por_id = select($query_tag);
			

			$array_de_tags = [];
			foreach ($all_tags_por_id as $tag){

				array_push($array_de_tags, $tag['NOMBRE_TAG']);
			} 

			$tag_string = implode(", ", $array_de_tags);
		}


		?>


		<input type="text" name="ETIQUETAS" value="<?= $tag_string ?>"><br>
		<span>Precio</span><br>
		<input name="price" type="text" value="<?= $newitem[3]?>"><br>
		<span>Inventario</span><br>
		<input name="inventario" type="text" value="<?= $newitem[8]?>"><br>

    <span>Seleccione la Imagen</span><br>
        
		<input name="uploadedfile" type="file" /><br> 
		<input type="submit" value="Hecho" />
      
    <input type="hidden" name="archivo" value="<?= $newitem[1] ?>">
    <input type="hidden" name="fecha" value="<?= $newitem[5] ?>">
      
		</form>
		</div>			
			</div>
				<?php require "sidebar.php"; ?>

	</div>
	

<?php require "footer.php" ?>