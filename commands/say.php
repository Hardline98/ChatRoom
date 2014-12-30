<?php

//Make multi word parameter
unset($parameter[0]);
$make =  implode(" ",$parameter);
if(!$con){
	die("Could not connect to database: ".mysql_error());
}else{
	//Safe-proofing
	$server = mysql_real_escape_string($createServer);
	$make = mysql_real_escape_string($make);
	$sql = "INSERT INTO `$db`.`$table` (`id`,`time`,`postedBy`,`message`,`ip`)
	VALUES
	(NULL, '$time', '$server', '$make', 'SERVER')";
}
mysql_query($sql,$con) or die(mysql_error());
			
?>