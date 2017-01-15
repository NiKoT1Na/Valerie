<?php 

 session_start();

require "functions.php";

exit_if_user_not_loggedin();

include("conex.php");   


$texto = $_POST['textoart'];
$nombproduc = $_POST['elnombre'];
$precio = $_POST['price'];
$tipo = $_POST['tipode'];
$inventario = $_POST['inventario'];
$USERID = $_SESSION['USERID'];
$etiqueta = $_POST['ETIQUETAS'];

$array_etiqueta = explode(",", $etiqueta);

if (isset ($_GET['prod_id'])){
  $ID = $_GET['prod_id'];
}

if (empty($_SESSION['USERISADMIN'])){

 exit; 
}




if(!empty($_FILES['uploadedfile']['name'])) {
  $extension = pathinfo($_FILES['uploadedfile']['name'], PATHINFO_EXTENSION);
  $ubicacion = "../upl/";
  $nombre_archivo =  mt_rand() . time() .".". $extension;
  $ubicacion = $ubicacion . $nombre_archivo;

  move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $ubicacion);
} else {

  $nombre_archivo = $_POST['archivo'];
  // <input type="hidden" name="archivo" value="<?= $newitem[0] ">   

}


if(!empty($_POST['fecha'])){

  $fecha = $_POST['fecha'];
} else {

  $fecha = date('Y-m-d H:i:s');
}



if (isset ($ID)){
  $textomysql = "UPDATE almacenaje SET ARCHIVO=?, NOMBRE=?,TIPO=?,PRECIO=?,DESCR=?, FECHA_DE_SUBIDA=?, USERID=?, INVENTARIO=? WHERE ID='$ID' ";
} else {
  $textomysql = "INSERT INTO almacenaje (ARCHIVO,NOMBRE,TIPO,PRECIO,DESCR,FECHA_DE_SUBIDA, USERID, INVENTARIO) VALUES (?,?,?,?,?,?,?,?)";
}

$stmt = mysqli_prepare($conectar, $textomysql);

if (mysqli_stmt_error($stmt)) {
  echo mysqli_stmt_error($stmt);
}

mysqli_stmt_bind_param($stmt, "ssssssdd", $nombre_archivo, $nombproduc, $tipo, $precio, $texto, $fecha, $USERID, $inventario);

mysqli_stmt_execute($stmt);

mysqli_stmt_close($stmt);
if(!isset($ID)){ 

  $ID = mysqli_insert_id($conectar);

}



foreach ($array_etiqueta as $onetag){

    $onetag = trim($onetag);

    $onetag = strtolower($onetag);

    $onetag = ucfirst($onetag);

    $textomysql = "INSERT INTO TAGS (NOMBRE) VALUES (?)";

    $stmt = mysqli_prepare($conectar, $textomysql);

    if (mysqli_stmt_error($stmt)) {
        echo mysqli_stmt_error($stmt);
    }

    mysqli_stmt_bind_param($stmt, "s", $onetag);

    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    $query = "SELECT * FROM TAGS WHERE NOMBRE=?";

    $stmt_2 = mysqli_prepare($conectar, $query);

    if (mysqli_stmt_error($stmt_2)) {
        echo mysqli_stmt_error($stmt_2);
    }

    mysqli_stmt_bind_param($stmt_2, "s", $onetag);

    mysqli_stmt_execute($stmt_2);

    mysqli_stmt_bind_result($stmt_2, $tag_id, $tag_name);

    mysqli_stmt_fetch($stmt_2);

    mysqli_stmt_close($stmt_2);

    $query_select = "SELECT * FROM almacenaje_tags WHERE TAG_ID=$tag_id AND PROD_ID=$ID";
    $res = mysqli_query($conectar, $query_select);

    if (mysqli_num_rows($res) === 0) {

    $query_insert = "INSERT IGNORE INTO almacenaje_tags SET PROD_ID=$ID, TAG_ID=$tag_id";
    mysqli_query($conectar, $query_insert);
    }

}


   header("Location: ../index.php?upload_success=1");
    

  ?>