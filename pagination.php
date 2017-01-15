<?php
//$url = preg_replace('/[?&]pag=\d+/', '', $_SERVER['REQUEST_URI']);
//

$url = '?';

foreach ($_GET as $key => $value) {
	if ($key !== 'page') {
		$url .= "$key=$value&";
	}
}

for ($p = 1; $p <= $n_paginas; $p++) { 
	echo "<a href='{$url}page=$p'>$p</a>";
}
