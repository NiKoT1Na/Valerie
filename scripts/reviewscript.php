<?php 

error_reporting (E_ALL ^ E_NOTICE);
session_start();

require "functions.php";

exit_if_user_not_loggedin();

include("conex.php");   

$reviewtext = $_POST['reviewtext'];
$USER = $_SESSION['USERID'];
$PRODID = $_POST['PRODID'];
$FECHA = date('Y-m-d H:i:s');
$RATING = intval($_POST['RATING']);
if ($RATING === 0 || $RATING > 5) {
	exit;
}

// $textomysql = ;
// $stmt = mysqli_prepare($conectar, $textomysql);
// mysqli_stmt_bind_param($stmt, "ss", $USER, $PRODID);
// mysqli_stmt_store_result($stmt);
// $numero_de_reviews = mysqli_stmt_num_rows($stmt);

$dump = mysqli_query($conectar, "DELETE FROM reviews WHERE USERID = '$USER' AND POST_ID = $PRODID");
var_dump($dump);
var_dump($USER);
var_dump($PRODID);

// mysqli_stmt_close($stmt);


$textomysql ="INSERT INTO reviews (COMMENT,DATES,POST_ID,USERID,RATING) VALUES (?,?,?,?,?)";

$stmt = mysqli_prepare($conectar, $textomysql);

mysqli_stmt_bind_param($stmt, "ssssd", $reviewtext, $FECHA, $PRODID, $USER, $RATING);

mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

header("Location: ../index.php?review_successful=1");
