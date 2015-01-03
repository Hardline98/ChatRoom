<?php

if(count($exMessage) > 100){
	$message = "/lolno";
	$exMessage = str_split($message);
}
if(trim($message) == ''){
	$message = "/lolno";
	$exMessage = str_split($message);
}
if(trim($name) == '' && $exMessage[0] != "/"){
	$message = "/lolno";
	$exMessage = str_split($message);
}

$createServer = "<span style='color:magenta'><u><b>SERVER</b></u></span>";

$colour = strtolower($colour);
$colourArray = array("black","red","green","blue","purple","orange","cyan");
if(!in_array($colour,$colourArray)){
	$colour = "black";
}
$style = strtolower($style);
$styleArray = array("normal","<b>,</b>","<i>,</i>","<u>,</u>");
if(!in_array($style,$styleArray)){
	$style = "normal";
}
if($style == "normal"){
	$style = " ";
}

$getTags = explode(",",$style);

$name = htmlentities($name);
$name = htmlspecialchars($name);
$name = htmlspecialchars_decode($name);
$message = htmlentities($message);
$message = htmlspecialchars($message);
$message = htmlspecialchars_decode($message);

$able = "status.txt";
$current = file_get_contents($able);
if($current == "disable"){
	if($exMessage[0] != "/"){
		$message = "/".$message;
		$exMessage = str_split($message);
	}
}

$banList = "ban.txt";
$banCurrent = file_get_contents($banList);
$seperate = explode(",",$banCurrent);
if(in_array($ip,$seperate)){
	$message = "/".$message;
	$exMessage = str_split($message);
}

?>