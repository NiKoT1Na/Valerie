<?php 

require 'ini.php';

require "header.php";

include("scripts/conex.php");

require "scripts/functions.php";

$todos_los_productos = [];

// cargar los elementos de una busqueda por ajax al hacer click en buscar
// PHP: Paginacion 
// LIMIT 
// OFFSET
$LIMIT_NUMBER = 3;

$LIMIT_OFFSET = " LIMIT $LIMIT_NUMBER ";
$parameters = [];
$types = "";

if (isset($_GET['page'])) {
	$offset = ($_GET['page']-1)*$LIMIT_NUMBER;
	$LIMIT_OFFSET .= " OFFSET $offset ";
}

const ORDER_BY = ' ORDER BY almacenaje.FECHA_DE_SUBIDA DESC ';

// ORM
// Object relational mapping
// open-source (MIT, Apache2)
// Eloquent
// graphDB
// 0000000
// 0000010 // 2 unsigned
// 0000011 // 3 unsigned
// Cache Memory - Reddis
// HTML -> cached324234.html
// 0123456789abcdef

// $table = ORM::table('almacenaje');
// $query = table(['WHERE' => ['NOMBRE', 'LIKE', $_GET['search']]]);
// $count = $query->getCount();
// $arrayResult = $query->getResults();
// Cassandra


if(isset($_GET['search'])){
	$busqueda = "%".$_GET['search']."%";
	$prequery ="SELECT * ";
	$query = " FROM almacenaje WHERE NOMBRE LIKE ? OR DESCR LIKE ? " . ORDER_BY;
	$parameters = [$busqueda, $busqueda];
	$types = "ss";	
	
} elseif (isset($_GET['categoria']) && isset($_GET['tag'])) {
	$catego = $_GET['categoria'];
	$tag = $_GET['tag'];
	$prequery = "SELECT almacenaje.*, tags.ID AS ID_TAG, tags.NOMBRE AS NOMBRE_TAG ";
	$query = " FROM almacenaje 
					LEFT JOIN almacenaje_tags ON almacenaje.id = almacenaje_tags.PROD_ID
					LEFT JOIN tags ON almacenaje_tags.TAG_ID = tags.ID WHERE TAGS.NOMBRE=? AND almacenaje.TIPO=? " . ORDER_BY;
	$parameters = [$tag, $catego];
	$types = "ss";	

} elseif(isset($_GET['categoria'])){


	$categoria = $_GET['categoria'];
	$prequery = "SELECT * ";
	$query = " FROM almacenaje WHERE TIPO=? " . ORDER_BY;
	$parameters = [$categoria];	
	$types = "s";
	
} elseif (isset($_GET['tag'])) {
	
	$tag = $_GET['tag'];
	$prequery = "SELECT almacenaje.*, tags.ID AS ID_TAG, tags.NOMBRE AS NOMBRE_TAG ";
	$query = " FROM almacenaje 
					LEFT JOIN almacenaje_tags ON almacenaje.id = almacenaje_tags.PROD_ID
					LEFT JOIN tags ON almacenaje_tags.TAG_ID = tags.ID WHERE TAGS.NOMBRE=? " . ORDER_BY;

	$parameters = [$tag];
	$types = "s";

} else {
	$prequery ="SELECT * ";
	$query = " FROM almacenaje " . ORDER_BY;
	//$todos_los_productos = select($conectar, $query);

}
$count_query = "SELECT COUNT(*) ".$query;

$n_productos = (query_with_args($count_query, $parameters, $types));
$n_paginas = ceil(($n_productos / $LIMIT_NUMBER));

$todos_los_productos = query_with_args($prequery.$query.$LIMIT_OFFSET, $parameters, $types);

if(isset($_GET['user_created'])){
	echo "<script> aviso_creado() </script>";
}


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
		</span> 
	<script>

		// var x = 0;
		// var Y = 20;

		// $('button.feo').click(function () {
		// 	alert(x);
		// 	x++;
		// })

		// $(window).blur(function () {
		// 	x = 0;
		// });

		// setInterval(function () {
		// 	x = 0;
		// }, 5000);

		

	</script>
		
		<?php 
		if (empty($todos_los_productos) && !empty($_GET['search'] || (isset($_GET['categoria']) && isset($_GET['tag'] )))){
			$link_home = '<a href="../../../index.php">volver al inicio</a>';
			echo "Lo sentimos, no hay ningun producto que coincida con tu busqueda " . $link_home;
		} 

		else if (empty($todos_los_productos)){
			echo "Lo sentimos. Esta seccion aun no tiene productos asignados";
		}

		foreach ($todos_los_productos as $producto):
			$rating = [];
		?>
						
			<div class='product'>
				<div class='nombre'><?= $producto['NOMBRE'] ?>
					
				</div> 
				<?php 	if (isset ($_SESSION['USERISADMIN'])) { ?>
				

				<div class='deleting'> 

					<script language="Javascript">
						function preguntar(){
			  				var eliminar = confirm("¿Deseas eliminar este producto?");
			   				if (eliminar) {
			     				window.location.href = "scripts/deleter.php?prod_id=<?= $producto['ID']?>"; 
			   				} else {
			    				alert('No se ha podido eliminar el producto...');
							}
						}
					</script>


					<a href="Javascript:preguntar()">Borrar</a>

				</div>
				<div class='editing' > <a href="editar.php?prod_id=<?= $producto['ID']?>">  editar </a> 
				</div> <br>
				<?php 	} ?>
				<img class='prodimagen' src='upl/<?= $producto['ARCHIVO'] ?>' />
				<div class='precio'>Precio <?= $producto['PRECIO'] ?>
				</div><br>
				<div class='tipodea'><?= $producto['TIPO'] ?>
				</div><br>
				<div>
					tags <br>
					
					<?php 

					$prod_id = $producto['ID'];
				
					$query_tag = "SELECT almacenaje.NOMBRE, almacenaje.ID, tags.ID AS ID_TAG, tags.NOMBRE AS NOMBRE_TAG FROM almacenaje 
									LEFT JOIN almacenaje_tags ON almacenaje.id = almacenaje_tags.PROD_ID
									LEFT JOIN tags ON almacenaje_tags.TAG_ID = tags.ID WHERE almacenaje.ID = $prod_id";

					$all_tags_por_id = select($query_tag);


					$array_de_tags = [];
					foreach ($all_tags_por_id as $tagged){

						array_push($array_de_tags, $tagged['NOMBRE_TAG']);
					} 

					$tag_string = implode(", ", $array_de_tags);

					?>
				</div><br>
				<div> <?= $tag_string ?> </div><br>
				<div class='descripcion'><?= $producto['DESCR'] ?>
				</div><br>
				<div class='fecha'><?= $producto['FECHA_DE_SUBIDA'] ?>
				</div><br>
				<div class="inventario">inventario <?= $producto['INVENTARIO'] ?><br> 


				</div>


				<?php 	if (isset ($_SESSION['USERNAME'])) { ?>
				<div class="review">
					<a href="review.php?prod_id=<?= $producto['ID']?>">Insertar un comentario</a><br>
				</div>
				<?php } ?>

				<?php

				$id_post = $producto['ID'];

				$review_query = "SELECT reviews.*, users.USERNAME FROM reviews  LEFT JOIN users on reviews.USERID = users.ID WHERE reviews.POST_ID = $id_post AND reviews.APPROVED = 1";
				$review_query_result = mysqli_query($conectar, $review_query);
				$todas_las_review = [];

				
				while($row = mysqli_fetch_assoc($review_query_result)) { 
				array_push($todas_las_review, $row);
				}
				/*echo '<pre>';
				print_r($todas_las_review);*/

						
				foreach ($todas_las_review as $show_review):
						 
						array_push($rating, $show_review['RATING']);
						$suma = array_sum($rating);
						$total_num = count($rating);
						$promedio = $suma/$total_num;

						// $Query_user = "SELECT * FROM users WHERE ID='$show_review[5]'";
						// $User_query_result = mysqli_query($conectar, $Query_user);
						// $User_query_result = mysqli_fetch_array($User_query_result);

				 ?>
				<div class="caja">
					<div class='show_review'> <br><?= $show_review['COMMENT'] ?>
					</div><br>
					<div class='ratin'> <br><?= estrella($show_review['RATING']) ?>
					</div><br>
					<div class="elname">  <br>Creada por <br> <a href="profile.php?userid=<?= $show_review['USERID']?>"> <?= $show_review['USERNAME']?> </a> </div> 
					
					
				</div>
				<?php 
				endforeach; 
				
				if (count($todas_las_review) !== 0){
					$promedio_redondeado = redondear_un_decimal($promedio);
					?> 
					<div class='promedio'> <?= 'Rating '.$promedio_redondeado.'<br>'?>
						<?= estrella($promedio_redondeado);?> 
					</div>
					<?php

				} ?>
				
			</div>
			<?php endforeach; ?>
			<?php require "pagination.php" ?>
		</div>
		
		<?php require "sidebar.php"; ?>

	</div>

<?php require "footer.php" ?>