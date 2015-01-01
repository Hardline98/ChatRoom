<?php

$adminFile = ".txt";
$file = strtolower($parameterTwo).$adminFile;
$fileContents = file_get_contents($file);
$fileSplit = explode(",",$fileContents);
$superUserFile = "super.txt";
$superContents = file_get_contents($superUserFile);
$superSplit = explode(",",$superContents);
if(file_exists($file)){
	if(strtolower($parameterOne) == "give" && !in_array($parameterThree,$fileSplit)){
		$update = $fileContents.",".$parameterThree;
		file_put_contents($file,$update);
	}else if(strtolower($parameterOne == "remove")){
		if(!in_array($parameterThree,$superSplit)){
			$loc = array_search($parameterThree,$fileSplit);
			unset($fileSplit[$loc]);
			$update = implode(",",$fileSplit);
			file_put_contents($file,$update);
		}
	}
}


?>