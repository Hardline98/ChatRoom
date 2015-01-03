<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<title>Chat Room</title>
<link rel="stylesheet" href="style.css" type="text/css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script>

var newMessage = document.createElement('audio');
var clearChat = document.createElement('audio');

$(document).ready(function(){
	$('.box').animate({
	scrollTop: $('.box')[0].scrollHeight}, 2000);
	$(".blackSel").text("^");
	$(".normalSel").text("^");
	$(".nameBox").val("");
	$(".soundCheck").prop("checked", true);
	newMessage.setAttribute('src','receive.mp3');
	clearChat.setAttribute('src','clear.mp3');
});

var isBanned;
var ban = new EventSource("bans.php");
ban.onmessage = function(event){
	var toString = String(event.data);
	if(toString == "disabled"){
		$(".nameBox").prop('disabled',true);
		$(".inputBox").prop('disabled',true);
		$(".inputButton").prop('disabled',true);
		$(".inputbutton").attr('class','disabledButton');
		$(".inputBox").val("You have been banned!");
		isBanned = true;
	}else{
		$(".nameBox").prop('disabled',false);
		$(".inputBox").prop('disabled',false);
		$(".inputButton").prop('disabled',false);
		$(".inputbutton").attr('class','inputButton');
		isBanned = false;
		if($(".inputBox").val() == "You have been banned!"){
			$(".inputBox").val("");
		}
	}
};
function send(){
	var userName = $(".nameBox").val();
	var str = $(".inputBox").val();
	var command = str.split("");
	var text = $(".inputBox").val();
	if(isBanned == false){
		if(userName.trim() != ""){
			if(text.trim() != ""){
				var user = $(".nameBox").val();
				var colour = $(".colour").val();
				var style = $(".style").val();
				$.ajax({
					url: "sendMessage.php",
					data: { user: user, message: text, colour: colour, style: style}
				});
				$(".nameBox").attr("placeholder","Username");
				$(".inputBox").val("");
				$(".inputBox").focus();
				$(".nameBox").attr("placeholder","Username");
				$(".inputBox").attr("placeholder","Message");
			}else{
				$(".inputBox").focus();
				$(".inputBox").attr("placeholder","Please enter an actual message");
			}
		}else if(command[0] == "/"){
			var user = $(".nameBox").val();
			var colour = $(".colour").val();
			var style = $(".style").val();
			$.ajax({
				url: "sendMessage.php",
				data: { user: user, message: text, colour: colour, style: style}
			});
			$(".nameBox").attr("placeholder","Username");
			$(".inputBox").val("");
			$(".inputBox").focus();
			$(".nameBox").attr("placeholder","Username");
			$(".inputBox").attr("placeholder","Message");
		}else{
			$(".nameBox").focus();
			$(".nameBox").attr("placeholder","Enter a valid name");
		}
	}
}


function testStuff(){
	var noteSound = $(".soundCheck").val();
	if($(".soundCheck").prop("checked")){
		alert("Checked");
	}else{
		alert("Not checked");
	}
}

var messages = [];
var source = new EventSource("serverEventHandler.php");
source.onmessage = function(event){
	//$.ajax({
		//url: "userCount.php",
		//data: { user: "" }
	//});
	if(messages.indexOf(event.data) != -1){
		
	}else{
		$(".box").html(event.data);
		messages = [event.data];
		$('.box').animate({
		scrollTop: $('.box')[0].scrollHeight}, 2000);
		if($(".soundCheck").prop("checked")){
			var dataString = String(event.data);
			var checkEmpty;
			var splitData = dataString.split("");
			if(splitData.slice(96,112) == "C,h,a,t, ,w,a,s, ,c,l,e,a,r,e,d"){
				if(splitData[250] === undefined){
					checkEmpty = "true";
				}else{
					checkEmpty = "false";
				}
			}else if(dataString.trim() == ""){
				checkEmpty = "true";
			}else{
				checkEmpty = "false";
			}
			if(checkEmpty == "true"){
				clearChat.play();
			}else{
				newMessage.play();
			}
		}
	}
};
var time = new EventSource("time.php");
time.onmessage = function(event){
	$(".time").html(event.data);
};
var counter = new EventSource("counter.php");
counter.onmessage = function(event){
	$(".counter").html("Users: "+event.data);
};

function myKeyPress(e){
	if(e.keyCode == 13){
		send();
	}
}

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
<body class="body">
<div class="collect">
	<div class="box">
	
	</div>
		<div class="input">
			<table class="main">
				<tr>
					<td class="timeTable"><span class="time"><?php echo date('h:i:s A'); ?></span></td>
					<td class="nameTable"><input class="nameBox" placeholder="Username" type="text" name="name" id="name" maxlength="20" onkeypress="return myKeyPress(event)"/></td>
					<td class="inputTable"><input class="inputBox" placeholder="Message" type="text" name="input" id="input" maxlength="100" onkeypress="return myKeyPress(event)"/></td>
					<td class="sendTable"><button onclick="send()" class="inputButton" >Send</button></td>
					<td class="soundCheckTable"><input type="checkbox" class="soundCheck" value="On" /> Notifications</td>
				</tr>
			</table>
		</div>

		<table class="options">
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
</div>
<input type="hidden" name="colour" class="colour" value="black" />
<input type="hidden" name="style" class="style" value="normal" />
</body>
</html>