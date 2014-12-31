<?php

//Database information
$host = "localhost";
$user = "root";
$dbpass = "";
$db = "chat";
$table = "log";

try{
	$handler = new PDO('mysql:host='.$host.';dbname='.$db,$user,$dbpass);
	$handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
	die($e->getMessage());
}

?>