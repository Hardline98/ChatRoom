<?php

session_start();
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

include("db_query.php");

echo "data: ".$construct."\n\n";

ob_flush();
flush();

?>