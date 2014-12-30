<?php

header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

include("db_query.php");


$ip = $_SERVER['REMOTE_ADDR'];
$helpFile = "help.txt";
$currentHelp = file_get_contents($helpFile);
$eachCurrent = explode(",",$currentHelp);
$create = "(".$ip."|show)";

$start = "<b><u>Commands:</b></u>";
$ban = "- /ban <IP Address>";
$unban = "- /unban <IP Address>";
$clear = "- /clear <* / IP> <IP>  -- '*' Clears with no notification, parameter 2 only works with '*'";
$rank = "- /rank <give / take> <IP Address>";
$say = "- /say <message>";
$chat = "- /chat <disable / enable>";
$help = "- /help <show / hide>";

//Convert to html values
$ban = htmlentities($ban);
$unban = htmlentities($unban);
$clear = htmlentities($clear);
$rank = htmlentities($rank);
$say = htmlentities($say);
$chat = htmlentities($chat);
$help = htmlentities($help);

$help = $start."<br>".$ban."<br>".$unban."<br>".$clear."<br>".$rank."<br>".$say."<br>".$chat."<br>".$help."<br>";
//Help menu
if(in_array($create,$eachCurrent)){
	$construct = $construct.$help;
}

echo "data: ".$construct."\n\n";

ob_flush();
flush();

?>