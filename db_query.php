<?php

session_start();

//Connect to DB
require("db_con.php");
$sql = $handler->query("SELECT * FROM `$db`.`$table` ORDER BY id ASC");
$construct = "";
if($sql->rowCount()){
	while($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$date = $rows->time;
		$username = $rows->postedBy;
		$message = $rows->message;
		$ip = $rows->ip;
		if(isset($_SESSION['admin']) || isset($_SESSION['mod'])){
			$show = "(".$ip.")";
		}else{
			$show = "";
		}
		$construct .= $date."&nbsp;".$show."&nbsp;<b>".$username.":</b>  ".$message."<br>";
	}
}else{
	$construct = "";
}

/*$countTable = "users";
$sql = $handler->query("SELECT * FROM `$db`.`$countTable` ORDER BY id ASC");
if($sql->rowCount()){
	while($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$count = $rows-id;
	}
}else{
	$count = 0;
}

$userCountFile = "users.txt";
$userContents = file_get_contents($userCountFile);
if($userContents != $count){
	$sql = "TRUNCATE TABLE `$db`.`$countTable`";
	$handler->query($sql);
	file_put_contents($userCountFile,$count);
	$userCount = $count;
}else{
	$userCount = $userContents;
}*/

?>