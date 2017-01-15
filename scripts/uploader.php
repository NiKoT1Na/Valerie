<?php 

	

include("conex.php");		

$extension = pathinfo($_FILES['uploadedfile']['name'], PATHINFO_EXTENSION);
$ubicacion = "../upl/";
$nombre_archivo =  mt_rand() . time() .".". $extension;
$texto = $_POST['textoart'];
$nombproduc = $_POST['elnombre'];
$precio = $_POST['price'];
$tipo = $_POST['tipode'];
$USERID = $_SESSION['USERID'] ;



$ubicacion = $ubicacion . $nombre_archivo;

if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $ubicacion)) 
  { 
  //echo "El archivo ". basename( $_FILES['uploadedfile']['name']). " ha sido subido";
  	// '); DROP TABLE almacenaje; #
  	// # input escaping
  	$stmt = mysqli_prepare($conectar, "INSERT INTO almacenaje (ARCHIVO,NOMBRE,TIPO,PRECIO,DESCR,FECHA_DE_SUBIDA, USERID) VALUES (?,?,?,?,?,?,?)");
    $fecha = date('Y-m-d H:i:s');
  	mysqli_stmt_bind_param($stmt, "ssssss", $nombre_archivo, $nombproduc, $tipo, $precio, $texto, $fecha, $USERID);
  	//mysqli_stmt_bind_param($stmt, "s", $nombproduc);
  	///mysqli_stmt_bind_param($stmt, "s", $texto);
    // DELETE WHERE ID=1
    // UPDATE almacenaje (ARCHIVO,NOMBRE,TIPO,PRECIO,DESCR,FECHA_DE_SUBIDA) VALUES (?,?,?,?,?,?) WHERE ID=1
 	/* execute query */
    mysqli_stmt_execute($stmt);

    /* bind result variables */



    /* fetch value */
    //mysqli_stmt_fetch($stmt);
    //echo mysqli_stmt_error($stmt);
    mysqli_stmt_close($stmt);

  	 //mysqli_query($conectar, "INSERT INTO almacenaje (ARCHIVO,NOMBRE,DESCR) VALUES ('$nombre_archivo','$nombproduc','$texto')");
    header("Location: ../index.php?upload_success=1");
    
 
} 
else {
	header("Location: ../index.php?upload_fail=1");
}


 ?>

 
