<?php

//sendMessage.php?user=USER&message=MESSAGE&colour=BLACK&style=NORMAL

session_start();

require("db_con.php");
$name = $_GET['user'];
$message = $_GET['message'];
$colour = $_GET['colour'];
$style = $_GET['style'];
$time = date('h:i:s');
$ip = $_SERVER['REMOTE_ADDR'];

$exMessage = str_split($message);

require("enforce.php");

function emoji($string){
	//Character replacing
	$string = str_ireplace(":)","&#9786;",$string);
	$string = str_ireplace(":(","&#9785;",$string);
	$string = str_ireplace(":-)","&#9787;",$string);
	$string = str_replace("=3","&#9825;",$string);
	$string = str_replace("./","&#9834;",$string);
	$string = str_replace("//","&#9835;",$string);
	$string = str_replace("/=/","&#9836;",$string);
	$string = str_replace(">8","&#9988;",$string);
	return $string;
}

$message = emoji($message);

//$message = preg_replace('!(www|http://[^ ]+)!i', '<a href="\1">\1</a>', $message);

$message = "<span style='color:".$colour.";'> ".$getTags[0]."".$message."".$getTags[1]." </span>";

$modFile = "mod.txt";
$modFile = file_get_contents($modFile);
$modFile = explode(",",$modFile);
$adminFile = "admin.txt";
$adminFile = file_get_contents($adminFile);
$adminFile = explode(",",$adminFile);

$_SESSION['default'] = "true";
$i = 0;
while($i++ < 1){
	if(!in_array($ip,$modFile) && !in_array($ip,$adminFile)){
		unset($_SESSION['mod']);
		unset($_SESSION['admin']);
		$_SESSION['default'] = "true";
		break;
	}
	if(in_array($ip,$modFile)){
		unset($_SESSION['default']);
		unset($_SESSION['admin']);
		$_SESSION['mod'] = "true";
		break;
	}else if(!in_array($ip,$modFile) && !in_array($ip,$adminFile)){
		unset($_SESSION['mod']);
		$_SESSION['default'] = "true";
		break;
	}
	if(in_array($ip,$adminFile)){
		unset($_SESSION['default']);
		unset($_SESSION['mod']);
		$_SESSION['admin'] = "true";
		break;
	}else if(!in_array($ip,$adminFile)){
		unset($_SESSION['admin']);
		$_SESSION['default'] = "true";
		break;
	}
}

if(!isset($_SESSION['mod']) && !isset($_SESSION['admin'])){
	$colour = "<span style='color:black;'>".$name."</span>";
}
if(isset($_SESSION['mod'])){
	$colour = "<span style='color:blue;'>".$name."</span>";
}
if(isset($_SESSION['admin'])){
	$colour = "<span style='color:red;'>".$name."</span>";
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
		$parameterThree = $parameter[3];
		if($command == "ban"){
			include("commands/admin/ban.php");
		}else if($command == "unban"){
			include("commands/admin/unban.php");
		}else if($command == "clear"){
			include("commands/admin/clear.php");
		}else if($command == "admin"){
			include("commands/admin/rank.php");
		}else if($command == "rank"){
			include("commands/admin/rank.php");
		}else if($command == "say"){
			include("commands/admin/say.php");
		}else if($command == "server"){
			include("commands/admin/say.php");
		}else if($command == "chat"){
			include("commands/admin/chat.php");
		}else if($command == "help"){
			include("commands/admin/help.php");
		}else if($command == "away"){
			include("commands/admin/away.php");
		}else if($command == "back"){
			include("commands/admin/back.php");
		}else if($command == "info"){
			include("commands/admin/info.php");
		}else if($command == "change"){
			include("commands/admin/change.php");
		}
	}
	if(isset($_SESSION['mod'])){
		unset($exMessage[0]);
		$toString = implode($exMessage);
		$parameter = explode(" ",$toString);
		$command = $parameter[0];
		$command = strtolower($command);
		$parameterOne = $parameter[1];
		$parameterTwo = $parameter[2];
		$parameterThree = $parameter[3];
		if($command == "ban"){
			include("commands/mod/ban.php");
		}else if($command == "unban"){
			include("commands/mod/unban.php");
		}else if($command == "clear"){
			include("commands/mod/clear.php");
		}else if($command == "say"){
			include("commands/mod/say.php");
		}else if($command == "server"){
			include("commands/mod/say.php");
		}else if($command == "chat"){
			include("commands/mod/chat.php");
		}else if($command == "help"){
			include("commands/mod/help.php");
		}else if($command == "away"){
			include("commands/mod/away.php");
		}else if($command == "back"){
			include("commands/mod/back.php");
		}else if($command == "info"){
			include("commands/mod/info.php");
		}
	}
	if(!isset($_SESSION['mod']) && !isset($_SESSION['admin'])){
		unset($exMessage[0]);
		$toString = implode($exMessage);
		$parameter = explode(" ",$toString);
		$command = $parameter[0];
		$command = strtolower($command);
		$parameterOne = $parameter[1];
		$parameterTwo = $parameter[2];
		$parameterThree = $parameter[3];
		if($command == "away"){
			include("commands/default/away.php");
		}else if($command == "back"){
			include("commands/default/back.php");
		}else if($command == "help"){
			include("commands/default/help.php");
		}else if($command == "away"){
			include("commands/default/away.php");
		}else if($command == "back"){
			include("commands/default/back.php");
		}
	}
}else{
	$current = file_get_contents("chat.txt");
	$constructTime = $time.": ";
	$update = $current.$constructTime.$colour." said ".$message."\n";
	file_put_contents("chat.txt",$update);
	$sql = "INSERT INTO `$db`.`$table` (`time`,`postedBy`,`message`,`ip`) VALUES ('$time', ?, ?, '$ip')";
	$query = $handler->prepare($sql);
	$query->execute(array($colour,$message));
}

?>