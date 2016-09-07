<?php

function __autoload($class_name) {
    require_once $class_name . '.php';
}

if(isset($_GET["messaggio"])) {
	$messaggio = $_GET["messaggio"];
	$messaggio = addslashes($messaggio);
	$parola1 = rand(1,108744);
	$parola2 = rand(1,108744);
	echo Database::inserisci_messaggio($parola1, $parola2, $messaggio);
}

if(isset($_POST["messaggio"])) {
	$messaggio = $_POST["messaggio"];
	$messaggio = addslashes($messaggio);
	$parola1 = rand(1,108744);
	$parola2 = rand(1,108744);
	echo Database::inserisci_messaggio($parola1, $parola2, $messaggio);
}

?>