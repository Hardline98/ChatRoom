<?php

if(isset($_GET['empty'])){
	$file = "test.txt";
	$contents = file_get_contents($file);
	$update = $contents-1;
	$new = file_put_contents($file,$update);
}


?>