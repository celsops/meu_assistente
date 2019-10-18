<?php

function createConnectionDB(){
	$dbhost = "localhost";
	$dbuser = "root";
	$dbpass = "";
	$db = "meuAssistente";
	$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $db) or  die("Connection failed");

	//echo "Connected!<br><br>";
	return $connection;
}

?>
