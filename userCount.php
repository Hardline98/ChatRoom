<?php

require("db_con.php");
$ip = $_SERVER['REMOTE_ADDR'];

$countTable = "users";
$sql = $handler->query("SELECT * FROM `$db`.`$countTable`");
$ipArray = array();
if($sql->rowCount()){
	while($rows = $sql->fetch(PDO::FETCH_OBJ)){
		array_push($ipArray,$rows->ip);
	}
}
if(isset($_GET['user']) && !in_array($ip,$ipArray)){
	$sql = "INSERT INTO `$db`.`$countTable` (`ip`) VALUES (?)";
	$query = $handler->prepare($sql);
	$query->execute(array($ip));
}


?>