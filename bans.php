<?php

session_start();
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

$ip = $_SERVER['REMOTE_ADDR'];
$banFile = "ban.txt";
$contents = file_get_contents($banFile);

$explode = explode(",",$contents);
if(in_array($ip,$explode)){
	$disabled = "disabled";
}else{
	$disabled = "";
}

echo "retry: 100\n
data: ".$disabled."\n\n";

ob_flush();
flush();

?>