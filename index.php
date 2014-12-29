<?php

session_start();

?>
<!DOCTYPE html>
<html>
<head>
<title>Chat Room</title>
<link rel="stylesheet" href="style.css" type="text/css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script>
var isBanned;
var ban = new EventSource("bans.php");
ban.onmessage = function(event){
	var toString = String(event.data);
	if(toString == "disabled"){
		$(".nameBox").prop('disabled',true);
		$(".inputBox").prop('disabled',true);
		$(".inputButton").prop('disabled',true);
		$(".inputBox").val("You have been banned!");
		isBanned = true;
	}else{
		$(".nameBox").prop('disabled',false);
		$(".inputBox").prop('disabled',false);
		$(".inputButton").prop('disabled',false);
		isBanned = false;
		if($(".inputBox").val() == "You have been banned!"){
			$(".inputBox").val("");
		}
	}
};
function send(){
	if(isBanned == false){
		var text = $(".inputBox").val();
		var user = $(".nameBox").val();
		var password = $(".password").val();
		$.ajax({
			url: "sendMessage.php",
			data: { user: user, message: text, password: password }
		});
		$(".inputBox").val("");
	}
}

var messages = [];
var source = new EventSource("serverEventHandler.php");
source.onmessage = function(event){
	if(messages.indexOf(event.data) != -1){
		//$(".box").html(event.data);
		$('.box').animate({
		scrollTop: $('.box')[0].scrollHeight}, 2000);
	}else{
		$(".box").html(event.data);
		messages = [event.data];
		$('.box').animate({
		scrollTop: $('.box')[0].scrollHeight}, 2000);
	}
	
};
var time = new EventSource("time.php");
time.onmessage = function(event){
	$(".time").html(event.data);
};

function myKeyPress(e){
	if(e.keyCode == 13){
		send();
	}
}
$(document).ready(function(){
	$('.box').animate({
	scrollTop: $('.box')[0].scrollHeight}, 2000);
});
</script>
</head>
<body>

<div class="box"></div>
<div class="input">
	<span class="time">TIME</span>&nbsp;<input class="nameBox" placeholder="Username" type="text" name="name" id="name" maxlength="20"/><input class="inputBox" placeholder="Message" type="text" name="input" id="input" maxlength="100" onkeypress="return myKeyPress(event)"/><button onclick="send()" class="inputButton" >Send</button>
</div>

<table>
	<tr>
		<td><div class="black">Black</div></td>
		<td><div class="red">Red</div></td>
		<td><div class="green">Green</div></td>
		<td><div class="blue">Blue</div></td>
		<td><div class="purple">Purple</div></td>
		<td><div class="orange">Orange</div></td>
		<td><div class="cyan">Cyan</div></td>
	</tr>
	<tr>
		<td class="blackSel"></td>
		<td class="redSel"></td>
		<td class="greenSel"></td>
		<td class="blueSel"></td>
		<td class="purpleSel"></td>
		<td class="orangeSel"></td>
		<td class="cyanSel"></td>
	</tr>
</table>

</body>
</html>