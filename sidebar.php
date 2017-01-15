<?php  

$all_categorias = select("SELECT * FROM categorias");
$all_tags = select("SELECT * FROM TAGS");




?>

<div id="sidebar">
	<div id="searchbarr">
		<form action="index.php" method="GET">
			Selecciona tu busqueda <br>
			<input type="text" name="search" id="busqueda" value="" ><br>
			<input type="submit" value="buscar">

			<script>

					$('#searchbarr form').submit(function () {	
						var textobusqueda = $("input#busqueda").val();
						if (textobusqueda !== "") {
							ajax({search: textobusqueda});
						}
						return false;
					});

			</script>

		</form>
	</div>
	<div id="posts"> 
		<span class="titulero">CATEGORIAS</span><br>

		<?php foreach($all_categorias as $catego): ?>

			<?php
				$link = 'index.php?categoria=' . $catego['NOMBRE'];
				if (isset($_GET['tag'])) {
					// Queremos mantener el tag cuando el usuario estaba filtrando por tag
					$link .= '&tag=' . $_GET['tag'];
				}
			?>
			<a href="<?= $link ?>"><?= $catego['NOMBRE'] ?></a><br>

		<?php endforeach; ?>

	</div>

	<div id="tags">
		<span class="titulero">Etiquetas</span><br>

		<?php foreach($all_tags as $tag): ?>

			<?php
				$link = 'index.php?tag=' . $tag['NOMBRE'];
				if (isset($_GET['categoria'])) {
					// Queremos mantener el categoria cuando el usuario estaba filtrando por categoria
					$link .= '&categoria=' . $_GET['categoria'];
				}
			?>
			<a href="<?= $link ?>"><?= $tag['NOMBRE'] ?></a><br>

		<?php endforeach; ?>

	</div>
</div>
<script>

$('#posts a').click(function () {
	ajax({categoria: $(this).html()});
	return false;
});

$('#tags a').click(function () {
	ajax({tag: $(this).html()});
	return false;
});

</script>