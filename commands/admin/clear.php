<?php

if(trim($name) == ""){
	$colour = "an <span style='color:red'>admin</span>";
}

if(isset($parameterOne)){
	if($parameterOne != "*"){
		$sql = "DELETE FROM `$db`.`$table` WHERE ip = ?";
		$query = $handler->prepare($sql);
		$query->execute(array($parameterOne));
		$make = "Chat was cleared by ".$colour;
		$sql = "INSERT INTO `$db`.`$table` (`id`,`time`,`postedBy`,`message`,`ip`) VALUES (NULL, '$time', ?, ?, 'SERVER')";
		$query = $handler->prepare($sql);
		$query->execute(array($createServer,$make));
	}else if(!isset($parameterTwo)){
		$sql = "TRUNCATE TABLE `$db`.`$table`";
		$handler->query($sql);
	}else{
		$sql = "DELETE FROM `$db`.`$table` WHERE ip = ?";
		$query = $handler->prepare($sql);
		$query->execute(array($parameterTwo));
	}
}else{
	$sql = "TRUNCATE TABLE `$db`.`$table`";
	$handler->query($sql);
	$make = "Chat was cleared by ".$colour;
	$sql = "INSERT INTO `$db`.`$table` (`id`,`time`,`postedBy`,`message`,`ip`) VALUES (NULL, '$time', ?, ?, 'SERVER')";
	$query = $handler->prepare($sql);
	$query->execute(array($createServer,$make));
}

?>