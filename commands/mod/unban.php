<?php

$banFile = "ban.txt";
$contents = file_get_contents($banFile);
$individual = explode(",",$contents);
print_r($individual);
if(in_array($parameterOne,$individual)){
	$loc = array_search($parameterOne,$individual);
	unset($individual[$loc]);
	$update = implode(",",$individual);
	file_put_contents($banFile,$update);
}

?>