<?php

header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

$timeFile = "time.txt";
$currentTime = file_get_contents($timeFile);

$time = date('h:i:s A');
echo "retry: 100\n
data: ".$time."\n\n";

ob_flush();
flush();

?>