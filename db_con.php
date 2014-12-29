<?php

//Database information
$host = "localhost";
$user = "root";
$dbpass = "";
$db = "chat";

//Connecting
$con = mysql_connect($host,$user,$dbpass);
mysql_select_db($db);

?>