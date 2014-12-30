<?php

session_start();
//Connect to DB
require("db_con.php");
$sql = mysql_query("SELECT * FROM `$db`.`$table` ORDER BY id ASC") or trigger_error(mysql_error().$sql);;
$numrows = mysql_num_rows($sql);
$construct = "";
if($numrows != 0){
	while($rows = mysql_fetch_assoc($sql)){
		$date = $rows['time'];
		$username = $rows['postedBy'];
		$message = $rows['message'];
		$ip = $rows['ip'];
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