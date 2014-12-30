<?php

//sendMessage.php?user=USER&message=MESSAGE&colour=BLACK&style=NORMAL

session_start();
require("db_con.php");
$name = $_GET['user'];
$message = $_GET['message'];
$colour = $_GET['colour'];
$style = $_GET['style'];
$time = date('h:i:s A');
$ip = $_SERVER['REMOTE_ADDR'];

$exMessage = str_split($message);

require("enforce.php");

//$message = preg_replace('!(www|http://[^ ]+)!i', '<a href="\1">\1</a>', $message);

$message = "<span style='color:".$colour.";'>".$getTags[0]."".$message."".$getTags[1]."</span>";

$adminFile = "admin.txt";
$adminFile = file_get_contents($adminFile);

$adminFile = explode(",",$adminFile);

if(in_array($ip,$adminFile)){
	$_SESSION['admin'] = "true";
}else{
	session_destroy();
}
if(isset($_SESSION['admin'])){
	$name = "<span style='color:red;'>".$name."</span>";
}
if($exMessage[0] == "/"){
	if(isset($_SESSION['admin'])){
		unset($exMessage[0]);
		$toString = implode($exMessage);
		$parameter = explode(" ",$toString);
		$command = $parameter[0];
		$command = strtolower($command);
		$parameterOne = $parameter[1];
		$parameterTwo = $parameter[2];
		if($command == "ban"){
			include("commands/ban.php");
		}else if($command == "unban"){
			include("commands/unban.php");
		}else if($command == "clear"){
			include("commands/clear.php");
		}else if($command == "admin"){
			include("commands/admin.php");
		}else if($command == "rank"){
			include("commands/admin.php");
		}else if($command == "say"){
			include("commands/say.php");
		}else if($command == "server"){
			include("commands/say.php");
		}else if($command == "chat"){
			include("commands/chat.php");
		}else if($command == "help"){
			include("commands/help.php");
		}
	}
}else{
	$current = file_get_contents("chat.txt");
	$constructTime = $time.": ";
	$update = $current.$constructTime.$name." said ".$message."\n";
	file_put_contents("chat.txt",$update);
	if(!$con){
		die("Could not connect to database: ".mysql_error());
	}else{
		//MySQL Injection Safe-proofing
		$name = mysql_real_escape_string($name);
		$message = mysql_real_escape_string($message);
		$sql = "INSERT INTO `$db`.`$table` (`id`,`time`,`postedBy`,`message`,`ip`)
		VALUES
		(NULL, '$time', '$name', '$message', '$ip')";
	}
	mysql_query($sql,$con);
}

?>