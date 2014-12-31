<?php

// /help show ip
//command p1  p2
$helpFile = "help.txt";
$currentHelp = file_get_contents($helpFile);
$eachCurrent = explode(",",$currentHelp);
if($parameterOne == "show"){
	if(!isset($parameterTwo)){
		$make = "(".$ip."|".$parameterOne.")";
		$check = "(".$ip."|hide)";
		if(!in_array($make,$eachCurrent)){
			if(in_array($check,$eachCurrent)){
				$loc = array_search($check,$eachCurrent);
				unset($eachCurrent[$loc]);
				$currentHelp = implode(",",$eachCurrent);
				$update = $currentHelp.",".$make;
				file_put_contents($helpFile,$update);
			}else{
				$update = $currentHelp.",".$make;
				file_put_contents($helpFile,$update);
			}
		}
	}else if(isset($parameterTwo)){
		$make = "(".$parameterTwo."|".$parameterOne.")";
		$check = "(".$parameterTwo."|hide)";
		if(!in_array($make,$eachCurrent)){
			if(in_array($check,$eachCurrent)){
				$loc = array_search($check,$eachCurrent);
				unset($eachCurrent[$loc]);
				$currentHelp = implode(",",$eachCurrent);
				$update = $currentHelp.",".$make;
				file_put_contents($helpFile,$update);
			}else{
				$update = $currentHelp.",".$make;
				file_put_contents($helpFile,$update);
			}
		}
	}
}else if($parameterOne == "hide"){
	if(!isset($parameterTwo)){
		$make = "(".$ip."|".$parameterOne.")";
		$check = "(".$ip."|show)";
		if(!in_array($make,$eachCurrent)){
			if(in_array($check,$eachCurrent)){
				$loc = array_search($check,$eachCurrent);
				unset($eachCurrent[$loc]);
				$currentHelp = implode(",",$eachCurrent);
				$update = $currentHelp.",".$make;
				file_put_contents($helpFile,$update);
			}else{
				$update = $currentHelp.",".$make;
				file_put_contents($helpFile,$update);
			}
		}
	}else if(isset($parameterTwo)){
		$make = "(".$parameterTwo."|".$parameterOne.")";
		$check = "(".$parameterTwo."|show)";
		if(!in_array($make,$eachCurrent)){
			if(in_array($check,$eachCurrent)){
				$loc = array_search($check,$eachCurrent);
				unset($eachCurrent[$loc]);
				$currentHelp = implode(",",$eachCurrent);
				$update = $currentHelp.",".$make;
				file_put_contents($helpFile,$update);
			}else{
				$update = $currentHelp.",".$make;
				file_put_contents($helpFile,$update);
			}
		}
	}
}

?>