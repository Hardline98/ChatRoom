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
			if(!in_array($parameterOne,$adminFile)){
				$banFile = "ban.txt";
				$contents = file_get_contents($banFile);
				$update = $contents.",".$parameterOne;
				file_put_contents($banFile,$update);
			}
		}else if($command == "unban"){
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
		}else if($command == "clear"){
			if(isset($parameterOne)){
				if($parameterOne != "*"){
					if(!$con){
						die("Could not connect to database: ".mysql_error());
					}else{
						$sql = "DELETE FROM `chat`.`log` WHERE ip = '$parameterOne'";
						//MySQL Injection Safe-proofing
						$server = mysql_real_escape_string($createServer);
						$make = "Chat was cleared by ".$name;
						$make = mysql_real_escape_string($make);
						$update = "INSERT INTO `chat`.`log` (`id`,`time`,`postedBy`,`message`,`ip`)
						VALUES
						(NULL, '$time', '$server', '$make', 'SERVER')";
						file_put_contents("chat.txt","");
						mysql_query($sql,$con) or die(mysql_error());
						mysql_query($update,$con);
					}
				}else if(!isset($parameterTwo)){
					$sql = "TRUNCATE TABLE `chat`.`log`";
					file_put_contents("chat.txt","");
					mysql_query($sql,$con);
				}else{
					$sql = "DELETE FROM `chat`.`log` WHERE ip = '$parameterTwo'";
					file_put_contents("chat.txt","");
					mysql_query($sql,$con);
				}
			}else{
				if(!$con){
					die("Could not connect to database: ".mysql_error());
				}else{
					$sql = "TRUNCATE TABLE `chat`.`log`";
					//MySQL Injection Safe-proofing
					$server = mysql_real_escape_string($createServer);
					$make = "Chat was cleared by ".$name;
					$make = mysql_real_escape_string($make);
					$update = "INSERT INTO `chat`.`log` (`id`,`time`,`postedBy`,`message`,`ip`)
					VALUES
					(NULL, '$time', '$server', '$make', 'SERVER')";
					file_put_contents("chat.txt","");
					mysql_query($sql,$con);
					mysql_query($update,$con);
				}
			}
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
		}else if($command == "rank"){
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
		}else if($command == "say"){
			//Make multi word parameter
			unset($parameter[0]);
			$make =  implode(" ",$parameter);
			if(!$con){
				die("Could not connect to database: ".mysql_error());
			}else{
				//Safe-proofing
				$server = mysql_real_escape_string($createServer);
				$make = mysql_real_escape_string($make);
				$sql = "INSERT INTO `chat`.`log` (`id`,`time`,`postedBy`,`message`,`ip`)
				VALUES
				(NULL, '$time', '$server', '$make', 'SERVER')";
			}
			mysql_query($sql,$con) or die(mysql_error());
		}else if($command == "server"){
			//Make multi word parameter
			unset($parameter[0]);
			$make =  implode(" ",$parameter);
			if(!$con){
				die("Could not connect to database: ".mysql_error());
			}else{
				//Safe-proofing
				$server = mysql_real_escape_string($createServer);
				$make = mysql_real_escape_string($make);
				$sql = "INSERT INTO `chat`.`log` (`id`,`time`,`postedBy`,`message`,`ip`)
				VALUES
				(NULL, '$time', '$server', '$make', 'SERVER')";
			}
			mysql_query($sql,$con) or die(mysql_error());
		}else if($command == "chat"){
			$chatStatus = "status.txt";
			$current = file_get_contents($chatStatus);
			if($parameterOne == "enable"){
				file_put_contents($chatStatus,"enable");
				if(!$con){
					die("Could not connect to database: ".mysql_error());
				}else{
					//Safe-proofing
					$server = mysql_real_escape_string($createServer);
					$make = "Chat was enabled by ".$name;
					$sentence = mysql_real_escape_string($make);
					$sql = "INSERT INTO `chat`.`log` (`id`,`time`,`postedBy`,`message`,`ip`)
					VALUES
					(NULL, '$time', '$server', '$sentence', 'SERVER')";
				}
				mysql_query($sql,$con) or die(mysql_error());
			}else if($parameterOne == "disable"){
				file_put_contents($chatStatus,"disable");
				if(!$con){
					die("Could not connect to database: ".mysql_error());
				}else{
					//Safe-proofing
					$server = mysql_real_escape_string($createServer);
					$make = "Chat was disabled by ".$name;
					$make = mysql_real_escape_string($make);
					$sql = "INSERT INTO `chat`.`log` (`id`,`time`,`postedBy`,`message`,`ip`)
					VALUES
					(NULL, '$time', '$server', '$make', 'SERVER')";
				}
				mysql_query($sql,$con) or die(mysql_error());
			}
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
		$sql = "INSERT INTO `chat`.`log` (`id`,`time`,`postedBy`,`message`,`ip`)
		VALUES
		(NULL, '$time', '$name', '$message', '$ip')";
	}
	mysql_query($sql,$con);
}

?>