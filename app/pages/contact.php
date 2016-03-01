lalala
<?php
	$request = str_replace("/envato/pretty/php/", "", $_SERVER['REQUEST_URI']);
 
	$params = explode("/", $request);
	var_dump($params);
	exit;
?>