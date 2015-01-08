<?php

if((isset($_POST["username"]))&&(isset($_POST["pass"]))){
	check();
}else{
	return_to_login();
}

function read_pass(){
	$current = fopen ("passwd.txt", "r");

	$content_current = fread ($current, filesize("passwd.txt"));
	$lines_current = explode("\n", $content_current);
	$users=array();
	$pwds=array();
	for ($i=0; $i<count($lines_current); $i++){
		$this_line=explode(":",$lines_current[$i]);
		array_push($users, $this_line[0]);
		array_push($pwds, $this_line[1]);
	}
	fclose ($current);
	return array($users, $pwds);
}


function return_to_login(){
	$url="./hwk15.html";
	header("location:$url");
}

function wrong_pw(){

print <<<welcome
	<html>
	<head>
	<title>Error</title>
	</head>
	<body>
	<center>
	<h4>Username is taken, or Wrong Password</h4>
	<form method="POST" action="./hwk15b.php">
	<table>
	<tr><td colspan="2"><input type="submit" value="Return" name="logout"></td></tr>
	</table>
	</form>
	</center>
	</body>
	</html>
welcome;
}

function welcome(){

print <<<welcome
	<html>
	<head>
	<title>Home</title>
	</head>
	<body>
	<center>
	<form method="POST" action="./hwk15b.php">
	<table>
	<tr><td colspan="2"><input type="submit" value="Logout" name="logout"></td></tr>
	</table>
	</form>
	</center>
	</body>
	</html>
welcome;
}

/* function to check if user is logging in, if password matches, or creates new user */ 

function check(){
	$user_input=$_POST["username"];
	$pwd_input=$_POST["pass"];
	$vars = read_pass();
	$users= $vars[0];
	$pwds= $vars[1];	
	for($j=0; $j<count($users); $j++){
		if($user_input===$users[$j]){
			if(crypt($pwd_input,$user_input)===$pwds[$j]){
				print ("<center><h5>Thanks for logging in</h5></center>");
				welcome();
				return;
			}else{
				print (crypt($pwd_input,$user_input));
				print ("<br>");
				print ($pwds[$j]);
				wrong_pw();
				return;
			}
		}
	}
	$new_pass= fopen ("passwd.txt", "a");
	$new_user_info=$user_input.":".crypt($pwd_input,$user_input)."\n";
	fwrite($new_pass, $new_user_info);
	fclose($new_pass);
	print ("<center><h5>Thanks for registering</h5></center>");
	welcome();
}

?>
