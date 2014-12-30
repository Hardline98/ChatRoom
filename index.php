<?php session_start(); ?>
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
		var colour = $(".colour").val();
		var style = $(".style").val();
		$.ajax({
			url: "sendMessage.php",
			data: { user: user, message: text, colour: colour, style: style}
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
	$(".blackSel").text("^");
	$(".normalSel").text("^");
	$(".nameBox").val("");
});

function colour(colour){
	var black = ".blackSel";
	var red = ".redSel";
	var green = ".greenSel";
	var blue = ".blueSel";
	var purple = ".purpleSel";
	var orange = ".orangeSel";
	var cyan = ".cyanSel";
	$(black).text("");$(red).text("");$(green).text("");$(blue).text("");$(purple).text("");$(orange).text("");$(cyan).text("");
	switch(colour){
		case "black": 
			$(".colour").val("black");
			$(black).text("^");break;
		case "red": 
			$(".colour").val("red");
			$(red).text("^");break;
		case "green": 
			$(".colour").val("green");
			$(green).text("^");break;
		case "blue": 
			$(".colour").val("blue");
			$(blue).text("^");break;
		case "purple": 
			$(".colour").val("purple");
			$(purple).text("^");break;		
		case "orange": 
			$(".colour").val("orange");
			$(orange).text("^");break;
		case "cyan":
			$(".colour").val("cyan");
			$(cyan).text("^");break;
		default: 
			$(".colour").val("black");
			$(black).text("^");
	}
}

function go(type){
	var normal = ".normalSel";
	var bold = ".boldSel";
	var italic = ".italicSel";
	var underline = ".underlineSel";
	$(normal).text("");$(bold).text("");$(italic).text("");$(underline).text("");
	switch(type){
		case "normal": 
			$(".style").val("normal");
			$(normal).text("^");
			break;
		case "bold": 
			$(".style").val("<b>,</b>");
			$(bold).text("^");
			break;
		case "italic": 
			$(".style").val("<i>,</i>");
			$(italic).text("^");
			break;
		case "underline": 
			$(".style").val("<u>,</u>");
			$(underline).text("^");
			break;
		default: $(".style").val("normal");$(normal).text("^");
	}
}
</script>
</head>
<body>
<center>
<div class="box"></div>
<div class="input">
	<span class="time">TIME</span>&nbsp;<input class="nameBox" placeholder="Username" type="text" name="name" id="name" maxlength="20"/><input class="inputBox" placeholder="Message" type="text" name="input" id="input" maxlength="100" onkeypress="return myKeyPress(event)"/><button onclick="send()" class="inputButton" >Send</button>
</div>

<table>
	<tr>
		<td><div class="black" onclick="colour('black')">Black</div></td>
		<td><div class="red" onclick="colour('red')">Red</div></td>
		<td><div class="green" onclick="colour('green')">Green</div></td>
		<td><div class="blue" onclick="colour('blue')">Blue</div></td>
		<td><div class="purple" onclick="colour('purple')">Purple</div></td>
		<td><div class="orange" onclick="colour('orange')">Orange</div></td>
		<td><div class="cyan" onclick="colour('cyan')">Cyan</div></td>
		<td></td>
		<td></td>
		<td></td>
		<td><div class="normal" onclick="go('normal')">Normal</div></td>
		<td><div class="bold" onclick="go('bold')"><b>Bold</b></div></td>
		<td><div class="italic" onclick="go('italic')"><i>Italic</i></div></td>
		<td><div class="underline" onclick="go('underline')"><u>Underline</u></div></td>
	</tr>
	<tr style="text-align:center">
		<td class="blackSel"></td>
		<td class="redSel"></td>
		<td class="greenSel"></td>
		<td class="blueSel"></td>
		<td class="purpleSel"></td>
		<td class="orangeSel"></td>
		<td class="cyanSel"></td>
		<td></td>
		<td></td>
		<td></td>
		<td class="normalSel"></td>
		<td class="boldSel"></td>
		<td class="italicSel"></td>
		<td class="underlineSel"></td>
	</tr>
</table>
</center>
<input type="hidden" name="colour" class="colour" value="black" />
<input type="hidden" name="style" class="style" value="normal" />
</body>
</html>