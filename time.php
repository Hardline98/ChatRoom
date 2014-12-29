<?php

$time = date('h:i:s A');
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
echo "data: ".$time."\n\n";

ob_flush();
flush();

?>