<?php

$adminFile = "admin.txt";
$adminContents = file_get_contents($adminFile);
$adminSplit = explode(",",$adminContents);
$superUserFile = "super.txt";
$superContents = file_get_contents($superUserFile);
$superSplit = explode(",",$superContents);
if(strtolower($parameterOne) == "give" && !in_array($parameterTwo,$adminSplit)){
	$update = $adminContents.",".$parameterTwo;
	file_put_contents($adminFile,$update);
}else if(strtolower($parameterOne == "remove")){
	if(!in_array($parameterTwo,$superSplit)){
		$loc = array_search($parameterTwo,$adminSplit);
		unset($adminSplit[$loc]);
		$update = implode(",",$adminSplit);
		file_put_contents($adminFile,$update);
	}
}

?>