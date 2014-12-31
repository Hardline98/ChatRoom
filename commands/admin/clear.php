<?php

if(isset($parameterOne)){
	if($parameterOne != "*"){
		$sql = "DELETE FROM `$db`.`$table` WHERE ip = ?";
		$query = $handler->prepare($sql);
		$query->execute(array($parameterOne));
		$make = "Chat was cleared by ".$name;
		$sql = "INSERT INTO `$db`.`$table` (`id`,`time`,`postedBy`,`message`,`ip`) VALUES (NULL, '$time', ?, ?, 'SERVER')";
		$query = $handler->prepare($sql);
		$query->execute(array($createServer,$make));
		file_put_contents("chat.txt","");
	}else if(!isset($parameterTwo)){
		$sql = "TRUNCATE TABLE `$db`.`$table`";
		$handler->query($sql);
		file_put_contents("chat.txt","");		
	}else{
		$sql = "DELETE FROM `$db`.`$table` WHERE ip = ?";
		$query = $handler->prepare($sql);
		$query->execute(array($parameterTwo));
		file_put_contents("chat.txt","");
	}
}else{
	$sql = "TRUNCATE TABLE `$db`.`$table`";
	$handler->query($sql);
	$make = "Chat was cleared by ".$name;
	$sql = "INSERT INTO `$db`.`$table` (`id`,`time`,`postedBy`,`message`,`ip`) VALUES (NULL, '$time', ?, ?, 'SERVER')";
	$query = $handler->prepare($sql);
	$query->execute(array($createServer,$make));
	file_put_contents("chat.txt","");
}

?>