<?php

$make =  $colour." went AFK";
$sql = "INSERT INTO `$db`.`$table` (`id`,`time`,`postedBy`,`message`,`ip`) VALUES (NULL, '$time', ?, ?, 'SERVER')";
$query = $handler->prepare($sql);
$query->execute(array($createServer,$make));

?>