<?php

session_start();

$name = $_GET['user'];
$message = $_GET['message'];
$colour = $_GET['colour'];
$style = $_GET['style'];
$getTags = explode(",",$style);
$time = date('h:i:s A');
$ip = $_SERVER['REMOTE_ADDR'];
$exMessage = str_split($message);

$message = preg_replace('!(www|http://[^ ]+)!i', '<a href="\1">\1</a>', $message);

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
		$lower = strtolower($command);
		$parameterOne = $parameter[1];
		$parameterTwo = $parameter[2];
		if($lower == "ban"){
			if(!in_array($parameterOne,$adminFile)){
				$banFile = "ban.txt";
				$contents = file_get_contents($banFile);
				$update = $contents.",".$parameterOne;
				file_put_contents($banFile,$update);
			}
		}else if($lower == "unban"){
			$banFile = "ban.txt";
			$contents = file_get_contents($banFile);
			$individual = explode(",",$contents);
			print_r($individual);
			if(in_array($parameterOne,$individual)){
				$loc = array_search($parameterOne,$individual);
				unset($individual[$loc]);
				$update = implode(",",$individual);
				file_put_contents($banFile,$update);
			}
		}else if($lower == "clear"){
			require("db_con.php");
			if(!$con){
				die("Could not connect to database: ".mysql_error());
			}else{
				//MySQL Injection Safe-proofing
				$sql = "TRUNCATE TABLE `chat`.`log`";
				file_put_contents("chat.txt","");
			}
			mysql_query($sql,$con);
		}else if($command == "admin"){
			$adminFile = "admin.txt";
			$adminContents = file_get_contents($adminFile);
			$adminSplit = explode(",",$adminContents);
			$superUserFile = "super.txt";
			$superContents = file_get_contents($superUserFile);
			$superSplit = explode(",",$superContents);
			if(strtolower($parameterOne) == "give" && !in_array($parameterTwo,$adminSplit)){
				$update = $adminContents.",".$parameterTwo;
				file_put_contents($adminFile,$update);
			}else if(strtolower($parameterOne == "remove")){
				if(!in_array($parameterTwo,$superSplit)){
					$loc = array_search($parameterTwo,$adminSplit);
					unset($adminSplit[$loc]);
					$update = implode(",",$adminSplit);
					file_put_contents($adminFile,$update);
				}
			}
		}
	}
}else{
	$current = file_get_contents("chat.txt");
	$constructTime = $time.": ";
	$update = $current.$constructTime.$name." said ".$message."\n";
	file_put_contents("chat.txt",$update);
	require("db_con.php");
	if(!$con){
		die("Could not connect to database: ".mysql_error());
	}else{
		//MySQL Injection Safe-proofing
		$name = mysql_real_escape_string($name);
		$message = mysql_real_escape_string($message);
		$sql = "INSERT INTO `chat`.`log` (`id`,`time`,`postedBy`,`message`,`ip`)
		VALUES
		(NULL, '$time', '$name', '$message', '$ip')";
	}
	mysql_query($sql,$con);
}

?>