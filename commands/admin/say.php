<?php

unset($parameter[0]);
$make =  implode(" ",$parameter);
$sql = "INSERT INTO `$db`.`$table` (`id`,`time`,`postedBy`,`message`,`ip`) VALUES (NULL, '$time', ?, ?, 'SERVER')";
$query = $handler->prepare($sql);
$query->execute(array($createServer,$make));

?>