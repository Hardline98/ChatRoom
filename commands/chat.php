<?php

$chatStatus = "status.txt";
$current = file_get_contents($chatStatus);
if($parameterOne == "enable"){
	file_put_contents($chatStatus,"enable");
	if(!$con){
		die("Could not connect to database: ".mysql_error());
	}else{
		//Safe-proofing
		$server = mysql_real_escape_string($createServer);
		$make = "Chat was enabled by ".$name;
		$sentence = mysql_real_escape_string($make);
		$sql = "INSERT INTO `$db`.`$table` (`id`,`time`,`postedBy`,`message`,`ip`)
		VALUES
		(NULL, '$time', '$server', '$sentence', 'SERVER')";
	}
	mysql_query($sql,$con) or die(mysql_error());
}else if($parameterOne == "disable"){
	file_put_contents($chatStatus,"disable");
	if(!$con){
		die("Could not connect to database: ".mysql_error());
	}else{
		//Safe-proofing
		$server = mysql_real_escape_string($createServer);
		$make = "Chat was disabled by ".$name;
		$make = mysql_real_escape_string($make);
		$sql = "INSERT INTO `$db`.`$table` (`id`,`time`,`postedBy`,`message`,`ip`)
		VALUES
		(NULL, '$time', '$server', '$make', 'SERVER')";
	}
	mysql_query($sql,$con) or die(mysql_error());
}
			
?>