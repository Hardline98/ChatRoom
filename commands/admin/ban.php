<?php

if(!in_array($parameterOne,$adminFile)){
	$banFile = "ban.txt";
	$contents = file_get_contents($banFile);
	$update = $contents.",".$parameterOne;
	file_put_contents($banFile,$update);
}

?>