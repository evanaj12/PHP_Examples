<?php

/* hwk12 php */


/* function to open and read existing users and corresponding pwds*/
function create_current(){
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

/* welcome page, allows users to login or register, no articles can be viewed yet*/
function welcome(){

print <<<welcome
	<html>
	<head>
	<title>Pretty Hard Programming</title>
	</head>
	<body>
	<center>
	<h3>Welcome to PHP!</h3>
	<h2><u>Pretty Hard Programming</u></h2>
	<h3>Programming News Network</h3>
	<p> Login to read the full stories, or register now and start reading!</p>
	<form method="POST" action="./hwk12.php">
	<table>
	<tr><td>Username:</td><td><input type="text" name="username"></td></tr>
	<tr><td>Password:</td><td><input type="password" name="pass"></td></tr>
	<tr><td><input type="submit" value="Login/Register" name="submit"></td><td><input type="reset" value="Clear"></td></tr>
	</table>
	</form>
	</center>
	</body>
	</html>
welcome;
}

/* after logging in, user can see links to articles, cookie set for 180 seconds
if the page is refreshed then the cookie is refreshed; however if the user
exits the page for over 180 sec then the cookie fades */
function home($this_user){
setcookie ("logged_in", $this_user, time()+180);

print<<<home

	<html>
	<head>
	<title>Pretty Hard Programming</title>
	</head>
	<body>
	<center>
	<h3>Welcome to PHP $this_user!</h3>
	<h2><u>Pretty Hard Programming</u></h2>
	<h3>Programming News Network</h3>

	<h4>
	<a href="./page1.html">News in Web Programming</a><br>
	<a href="./page2.html">News in Hardware Development</a><br>
	<a href="./page3.html">Videogames in Development</a><br>
	<a href="./page4.html">Security Central</a><br>
	<a href="./page5.html">Operating Systems and Development</a><br>

	</h4>
	</center>
	</body>
	</html>
home;
}

/* function to check if user is logging in, if password matches, or creates new user */
function check(){
	$user_input=$_POST["username"];
	$pwd_input=$_POST["pass"];
	$vars = create_current();
	$users= $vars[0];
	$pwds= $vars[1];	
	for($j=0; $j<count($users); $j++){
		if($user_input===$users[$j]){
			if($pwd_input===$pwds[$j]){
				print ("<center><h5>Thanks for logging in</h5></center>");
				home($users[$j]);
				return;
			}else{
				print ("<center><h5>Either that username is already chosen, or you have input the wrong password</h5></center>");
				welcome();
				return;
			}
		}
	}
	$new_current= fopen ("passwd.txt", "a");
	$new_user_info=$user_input.":".$pwd_input."\n";
	fwrite($new_current, $new_user_info);
	fclose($new_current);
	print ("<center><h5>Thanks for registering, please login</h5></center>");
	welcome();
}

if (isset($_COOKIE["logged_in"])){
	$current_user=$_COOKIE["logged_in"];
	home($current_user);
}elseif(isset($_POST["submit"])){
	check();
}else{
	welcome();
}

?>
