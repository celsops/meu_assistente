<?php

function criarConecxao(){
	$dbhost = "localhost";
	$dbuser = "id11271857_programador";
	$dbpass = "programador";
	$db = "id11271857_meuassistente";
	$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $db) or  die("Connection failed");
	// $connection = new mysqli($dbhost, $dbuser, $dbpass, $db) or  die("Connection failed");

	//echo "Connected!<br><br>";
	return $connection;
}

?>
