<?php

$chatStatus = "status.txt";
$current = file_get_contents($chatStatus);
if($parameterOne == "enable"){
	file_put_contents($chatStatus,"enable");
	//Safe-proofing
	$make = "Chat was enabled by ".$name;
	$sql = "INSERT INTO `$db`.`$table` (`id`,`time`,`postedBy`,`message`,`ip`) VALUES (NULL, '$time', ?, ?, 'SERVER')";
	$query = $handler->prepare($sql);
	$query->execute(array($createServer,$make));
}else if($parameterOne == "disable"){
	file_put_contents($chatStatus,"disable");
	$make = "Chat was disabled by ".$name;
	$sql = "INSERT INTO `$db`.`$table` (`id`,`time`,`postedBy`,`message`,`ip`) VALUES (NULL, '$time', ?, ?, 'SERVER')";
	$query = $handler->prepare($sql);
	$query->execute(array($createServer,$make));
}
			
?>