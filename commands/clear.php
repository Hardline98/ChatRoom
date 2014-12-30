<?php

if(isset($parameterOne)){
	if($parameterOne != "*"){
		if(!$con){
			die("Could not connect to database: ".mysql_error());
		}else{
			$sql = "DELETE FROM `$db`.`$table` WHERE ip = '$parameterOne'";
			//MySQL Injection Safe-proofing
			$server = mysql_real_escape_string($createServer);
			$make = "Chat was cleared by ".$name;
			$make = mysql_real_escape_string($make);
			$update = "INSERT INTO `$db`.`$table` (`id`,`time`,`postedBy`,`message`,`ip`)
			VALUES
			(NULL, '$time', '$server', '$make', 'SERVER')";
			file_put_contents("chat.txt","");
			mysql_query($sql,$con) or die(mysql_error());
			mysql_query($update,$con);
		}
	}else if(!isset($parameterTwo)){
		$sql = "TRUNCATE TABLE `$db`.`$table`";
		file_put_contents("chat.txt","");
		mysql_query($sql,$con);
	}else{
		$sql = "DELETE FROM `$db`.`$table` WHERE ip = '$parameterTwo'";
		file_put_contents("chat.txt","");
		mysql_query($sql,$con);
	}
}else{
	if(!$con){
		die("Could not connect to database: ".mysql_error());
	}else{
		$sql = "TRUNCATE TABLE `$db`.`$table`";
		//MySQL Injection Safe-proofing
		$server = mysql_real_escape_string($createServer);
		$make = "Chat was cleared by ".$name;
		$make = mysql_real_escape_string($make);
		$update = "INSERT INTO `$db`.`$table` (`id`,`time`,`postedBy`,`message`,`ip`)
		VALUES
		(NULL, '$time', '$server', '$make', 'SERVER')";
		file_put_contents("chat.txt","");
		mysql_query($sql,$con);
		mysql_query($update,$con);
	}
}
			
?>