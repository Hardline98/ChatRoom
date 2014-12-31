<?php

header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

include("db_query.php");

$ip = $_SERVER['REMOTE_ADDR'];
$helpFile = "help.txt";
$currentHelp = file_get_contents($helpFile);
$eachCurrent = explode(",",$currentHelp);
$create = "(".$ip."|show)";

$start = "<br><b><u>Commands:</b></u>";
$need = htmlentities("<NEEDED>");
$end = "<br><b>[OPTIONAL] ".$need."</b>";


$away = "- /away -- Sets status to away";
$back = "- /back -- Sets status to back";
$ban = "- /ban <IP Address> -- Bans a given IP address";
$chat = "- /chat <disable / enable> -- Enables or disables the chat";
$clear = "- /clear [IP] -- IP Optional -- ";
$clearAdmin = "- /clear <*/IP> [IP]  -- '*' Clears with no notification, parameter 2 only works with '*'";
$helpCommand = "- /help <show / hide> -- Shows or hides the help menu";
$kick = "- /kick <IP Address> -- Kicks a player";
$motd = "- /motd -- Shows the server's message of the day";
$rank = "- /rank <give / take> <rank> <IP Address> -- Gives a player a rank defined <rank>";
$say = "- /say <message> -- Makes the server send a message";
$time = "- /time -- Sends the current server time to all connected users";
$unban = "- /unban <IP Address> -- Unbans a given IP Address";

//Convert to html values
$away = htmlentities($away);
$back = htmlentities($back);
$ban = htmlentities($ban);
$chat = htmlentities($chat);
$clear = htmlentities($clear);
$helpCommand = htmlentities($helpCommand);
$kick = htmlentities($kick);
$motd = htmlentities($motd);
$rank = htmlentities($rank);
$say = htmlentities($say);
$time = htmlentities($time);
$unban = htmlentities($unban);

if(!isset($_SESSION['mod']) && !isset($_SESSION['admin'])){
	$help = $start."<br>".$away."<br>".$back."<br>".$helpCommand."<br>".$end;
}

if(isset($_SESSION['mod'])){
	$help = $start."<br>".$away."<br>".$back."<br>".$ban."<br>".$chat."<br>".$clear."<br>".$helpCommand."<br>".$kick."<br>".$motd."<br>".$say."<br>".$time."<br>".$unban."<br>".$end;
}
if(isset($_SESSION['admin'])){
	$help = $start."<br>".$away."<br>".$back."<br>".$ban."<br>".$chat."<br>".$clearAdmin."<br>".$helpCommand."<br>".$kick."<br>".$motd."<br>".$rank."<br>".$say."<br>".$time."<br>".$unban."<br>".$end;
}

//Help menu
if(in_array($create,$eachCurrent)){
	$construct = $construct.$help;
}

echo "data: ".$construct."\n\n";

ob_flush();
flush();

?>