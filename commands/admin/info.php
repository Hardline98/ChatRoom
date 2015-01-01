<?php

$parameterOne = strtolower($parameterOne);
if($parameterOne == "date"){
	$make =  "Server date is <u><b>".date('l jS \of F Y')."</u></b>";
	$sql = "INSERT INTO `$db`.`$table` (`id`,`time`,`postedBy`,`message`,`ip`) VALUES (NULL, ' ', ?, ?, 'SERVER')";
	$query = $handler->prepare($sql);
	$query->execute(array($createServer,$make));
}else if($parameterOne == "time"){
	$make =  "Server time is <u><b>".date('h:i:s A')."</u></b>";
	$sql = "INSERT INTO `$db`.`$table` (`id`,`time`,`postedBy`,`message`,`ip`) VALUES (NULL, ' ', ?, ?, 'SERVER')";
	$query = $handler->prepare($sql);
	$query->execute(array($createServer,$make));
}else if($parameterOne == "*"){
	$make =  "Server date is <u><b>".date('l jS \of F Y')."</u></b> and server time is <b><u>".date('h:i:s A')."</u></b>";
	$sql = "INSERT INTO `$db`.`$table` (`id`,`time`,`postedBy`,`message`,`ip`) VALUES (NULL, ' ', ?, ?, 'SERVER')";
	$query = $handler->prepare($sql);
	$query->execute(array($createServer,$make));
}

?>