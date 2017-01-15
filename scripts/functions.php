<?php 	

function exit_if_user_not_loggedin(){
	if (!isset ($_SESSION['USERNAME'])){
		header("HTTP/1.1 401 Unauthorized");
	 	exit; 
	}
}

function redirect_to_home_if_loggedin(){
	if (isset ($_SESSION['USERNAME'])){
		header("HTTP/1.1 301 Moved Permanently"); 
		header("Location: index.php"); 
	 	exit;
	}
}

function redondear_un_decimal($valor) { 
   $float_redondeado=round($valor * 10) / 10; 
   return $float_redondeado; 
}

function estrella($promedio) {
	$num = floor($promedio * 2);
	$file_name = $num . 'est.png';
	return "<img id='estrellitas' src='img/$file_name' alt='Estrellas' >";
}

function select($query) {
	global $conectar;
	$rows = [];
	$query_result = mysqli_query($conectar, $query);
	while ($row = mysqli_fetch_assoc($query_result)) { 
		array_push($rows, $row);
	}
	return $rows;
}

function query_with_args($query, $argumentArray = [], $argtype = "") {
	global $conectar;
	$res = [];

	if (!empty($argumentArray) && !empty($argtype)) {
		$stmt = mysqli_prepare($conectar, $query);
		array_unshift($argumentArray, $argtype);
		array_unshift($argumentArray, $stmt);

		call_user_func_array("mysqli_stmt_bind_param", refValues($argumentArray));

		$ret = mysqli_stmt_execute($stmt);
		if (substr($query, 0, 6) === 'SELECT') {

			$result = mysqli_stmt_get_result($stmt);

			while($row = mysqli_fetch_assoc($result)) {
				array_push($res, $row);
			} 
			mysqli_stmt_close($stmt);
		} else {
			$res = $ret;	
		}
	
	} else { 
		$res = select($query);
	}
	if (is_array($res) && isset($res[0]['COUNT(*)'])){
		$res = $res[0]['COUNT(*)'];
	}

	return $res;
}

function refValues($arr){
    if (strnatcmp(phpversion(),'5.3') >= 0) //Reference is required for PHP 5.3+
    {
        $refs = array();
        foreach($arr as $key => $value)
            $refs[$key] = &$arr[$key];
        return $refs;
    }
    return $arr;
}
