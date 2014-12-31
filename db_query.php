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
		if(isset($_SESSION['admin'])){
			$show = "(".$ip.")";
		}else{
			$show = "";
		}
		$construct .= $date."&nbsp;".$show."&nbsp;<b>".$username.":</b>  ".$message."<br>";
	}
}else{
	$construct = "";
}

?>