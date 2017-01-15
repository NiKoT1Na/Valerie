<?php 

session_start();

require "functions.php";

exit_if_user_not_loggedin();

include("conex.php");   

if (isset ($_GET['prod_id'])){
  $ID = $_GET['prod_id'];
}

$query = "SELECT * FROM almacenaje WHERE ID=$ID";
$query_result = mysqli_query($conectar, $query);
$query_result = mysqli_fetch_array($query_result);

$imgfile = $query_result[1];

if (unlink("../upl/$imgfile")) {

  $borrado_exitoso = mysqli_query($conectar, "DELETE FROM almacenaje WHERE ID=$ID");

  if ($borrado_exitoso) {
    header("Location: ../index.php?delete_successful=1");
  } else {
    header("Location: ../index.php?delete_fail=1");
  }
  
} else {
  header("Location: ../index.php?image_delete_fail=1");
}
