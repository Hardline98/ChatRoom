<?php

if(isset($parameterOne) && isset($parameterTwo) && isset($parameterThree)){
	//Create string of text
	unset($parameter[0]);
	unset($parameter[1]);
	unset($parameter[2]);
	$createString = implode(" ",$parameter);
	$sql = $handler->query("SELECT * FROM `$db`.`$table`");
	if($sql->rowCount()){
		$checkParameters = $handler->prepare("SELECT * FROM `$db`.`$table` WHERE time = ? AND ip = ? LIMIT 1");
		$checkParameters->execute(array($parameterOne,$parameterTwo));
		if($checkParameters->rowCount()){
			while($rows = $checkParameters->fetch(PDO::FETCH_OBJ)){
				$id = $rows->id;
				$updateData = $handler->prepare("UPDATE `$db`.`$table` SET message = ? WHERE id = $id");
				$updateData->execute(array($createString));
			}
		}
	}
}

?>