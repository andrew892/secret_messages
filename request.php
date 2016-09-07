<?php

function __autoload($class_name) {
    require_once $class_name . '.php';
}

if(isset($_GET["parola1"]) && isset($_GET["parola2"])) {
	
	$parola1 = $_GET["parola1"];
	$parola1 = trim($parola1);
	$parola1 = addslashes($parola1);
	$parola1 = strtolower($parola1);
	
	$parola2 = $_GET["parola2"];
	$parola2 = trim($parola2);
	$parola2 = addslashes($parola2);
	$parola2 = strtolower($parola2);
	
	echo Database::leggi_messaggio($parola1,$parola2);
}

if(isset($_POST["parola1"]) && isset($_POST["parola2"])) {
	
	$parola1 = $_POST["parola1"];
	$parola1 = trim($parola1);
	$parola1 = addslashes($parola1);
	$parola1 = strtolower($parola1);
	
	$parola2 = $_POST["parola2"];
	$parola2 = trim($parola2);
	$parola2 = addslashes($parola2);
	$parola2 = strtolower($parola2);
	
	echo Database::leggi_messaggio($parola1,$parola2);
}
// $num = rand(1,233756);


?>
