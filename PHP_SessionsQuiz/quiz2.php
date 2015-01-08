<?php

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

function welcome(){

print <<<welcome
	<html>
	<head>
	<title>Login</title>
	</head>
	<body>
	<center>
	<form method="POST" action="./quiz2.php">
	<table>
	<tr><td colspan="2">Please Login to take the quiz</td></tr>
	<tr><td>Username:</td><td><input type="text" name="username"></td></tr>
	<tr><td>Password:</td><td><input type="password" name="pass"></td></tr>
	<tr><td><input type="submit" value="Login" name="login"></td><td><input type="reset" value="Clear"></td></tr>
	<tr><td colspan="2"><input type="submit" value="Register" name="reg"></td></tr>
	</table>
	</form>
	</center>
	</body>
	</html>
welcome;
}

function quest1(){

$_SESSION["question"]++;
$user=$_SESSION["user"];
print<<<question1
<html>
<head>
<title> Astronomy Quiz </title>
</head>

<body>
 <center><h1><u> Astronomy Quiz for $user </u></h1></center>
 <form action="./quiz2.php" name="quizq1" method="post">
 <hr>
 <h3> True / False </h3>
  <p><b>1)</b> According to Kepler the orbit of the earth is a circle with
	the sun at the center.</p>
	<p> a) True<input type="radio" name="tf1" value="tf1a" >
	 b) False<input type="radio" name="tf1" value="tf1b" ></p>
	<br>
 <input type="submit" value="Next" name="q1">
 </form>
 </body>
</html>
question1;
}

function quest2(){
session_start();

if ((session_id()===$_SESSION["id"])&&(timer())&&($_SESSION["question"]===1)){
	$_SESSION["question"]++;
	$user=$_SESSION["user"];
	$_SESSION["tf1"]=$_POST["tf1"];
	if ($_SESSION["tf1"]=="tf1b"){
		$_SESSION["correct"]++;
	}else{}

print<<<question2
<html>
<head>
<title> Astronomy Quiz </title>
</head>

<body>
 <center><h1><u> Astronomy Quiz for $user </u></h1></center>
 <form action="./quiz2.php" name="quizq2" method="post">
 <hr>
 <h3> True / False </h3>
  <p><b>2)</b> Ancient astronomers did consider the heliocentric model of
	the solar system but rejected it because they could not detect parallax.</p>
	<p> a) True<input type="radio" name="tf2" value="tf2a">
	 b) False<input type="radio" name="tf2" value="tf2b"></p>
	<br>
 <input type="submit" value="Next" name="q2">
 </form>
 </body>
</html>
question2;

}else{
	print ("<center><h5>Your quiz has ended either because you went over the alloted 15 mins or you attempted to go back</h5></center>");
	res_report();
}
}

function quest3(){
session_start();

if ((session_id()===$_SESSION["id"])&&(timer())&&($_SESSION["question"]===2)){
	$_SESSION["question"]++;
	$user=$_SESSION["user"];
	$_SESSION["tf2"]=$_POST["tf2"];
	if ($_SESSION["tf2"]=="tf2a"){
		$_SESSION["correct"]++;
	}else{}

print<<<question3
<html>
<head>
<title> Astronomy Quiz </title>
</head>

<body>
 <center><h1><u> Astronomy Quiz for $user </u></h1></center>

 <form action="./quiz2.php" name="quizq3" method="post">
 <hr>
 <h3> Multiple Choice </h3>
  <p><b>3)</b> The total amount of energy that a star emits is directly related
	to its</p>
	<p>a) surface gravity and magnetic field <input type="checkbox" name="mc1[]" value="mc1a"><br>
	b) radius and temperature <input type="checkbox" name="mc1[]" value="mc1b"><br>
	c) pressure and volume <input type="checkbox" name="mc1[]" value="mc1c"><br>
	d) location and velocity <input type="checkbox" name="mc1[]" value="mc1d"></p><br> 
 <input type="submit" value="Next" name="q3">
 </form>
 </body>
</html>
question3;

}else{
	print ("<center><h5>Your quiz has ended either because you went over the alloted 15 mins or you attempted to go back</h5></center>");
	res_report();
}
}

function quest4(){
session_start();

if ((session_id()===$_SESSION["id"])&&(timer())&&($_SESSION["question"]===3)){
	$_SESSION["question"]++;
	$user=$_SESSION["user"];
	$_SESSION["mc1"]=$_POST["mc1"];
	if ((count($_SESSION["mc1"])===1)&&($_SESSION["mc1"][0]==="mc1b")){
		$_SESSION["correct"]++;
	}else{}

print<<<question4
<html>
<head>
<title> Astronomy Quiz </title>
</head>

<body>
 <center><h1><u> Astronomy Quiz for $user </u></h1></center>

 <form action="./quiz2.php" name="quizq4" method="post">
 <hr>
 <h3> Multiple Choice </h3>
  <p><b>4)</b> Stars that live the longest have</p>
	<p>a) high mass <input type="checkbox" name="mc2[]" value="mc2a"><br>
	b) high temperature <input type="checkbox" name="mc2[]" value="mc2b"><br>
	c) lots of hydrogen <input type="checkbox" name="mc2[]" value="mc2c"><br>
	d) small mass <input type="checkbox" name="mc2[]" value="mc2d"></p><br>
 <input type="submit" value="Next" name="q4">
 </form>
 </body>
</html>
question4;

}else{
	print ("<center><h5>Your quiz has ended either because you went over the alloted 15 mins or you attempted to go back</h5></center>");
	res_report();
}
}

function quest5(){
session_start();

if ((session_id()===$_SESSION["id"])&&(timer())&&($_SESSION["question"]===4)){
	$_SESSION["question"]++;
	$user=$_SESSION["user"];
	$_SESSION["mc2"]=$_POST["mc2"];
	if ((count($_SESSION["mc2"])===1)&&($_SESSION["mc2"][0]==="mc2d")){
		$_SESSION["correct"]++;
	}else{}

print<<<question5
<html>
<head>
<title> Astronomy Quiz </title>
</head>

<body>
 <center><h1><u> Astronomy Quiz for $user </u></h1></center>

 <form action="./quiz2.php" name="quizq5" method="post">
 <hr>
 <h3> Fill in the Blank </h3>
  <p><b>5)</b> A collection of a hundred billion stars, gas, and dust is
	called a <input type="text" name="text1">.</p>
 <input type="submit" value="Next" name="q5">
 </form>
 </body>
</html>
question5;

}else{
	print ("<center><h5>Your quiz has ended either because you went over the alloted 15 mins or you attempted to go back</h5></center>");
	res_report();
}
}

function quest6(){
session_start();

if ((session_id()===$_SESSION["id"])&&(timer())&&($_SESSION["question"]===5)){
	$_SESSION["question"]++;
	$user=$_SESSION["user"];
	$_SESSION["text1"]=$_POST["text1"];
	$pattern1='/galaxy/i';

	if (preg_match($pattern1, $_SESSION["text1"])){
		$_SESSION["correct"]++;
	}else{}

print<<<question6
<html>
<head>
<title> Astronomy Quiz </title>
</head>

<body>
 <center><h1><u> Astronomy Quiz for $user </u></h1></center>

 <form action="./quiz2.php" name="quizq6" method="post">
 <hr>
 <h3> Fill in the Blank </h3>

  <p><b>6)</b> The inverse of the Hubble's constant is a measure of the
	<input type="text" name="text2"> of the universe.</p><br>
 <input type="submit" value="Finish" name="complete">
 </form>
 </body>
</html>
question6;

}else{
	print ("<center><h5>Your quiz has ended either because you went over the alloted 15 mins or you attempted to go back</h5></center>");
	res_report();
}
}

function res_report(){
session_start();

$user=$_SESSION["user"];

$_SESSION["text2"]=$_POST["text2"];
$pattern2='/age/i';

if (preg_match($pattern2, $_SESSION["text2"])){
	$_SESSION["correct"]++;
}

$correct=$_SESSION["correct"];
$reported=$correct*10;

if ($user!==""){
	$result_file = fopen ("results.txt", "a");
	$results=$user.":".$reported."\n";
	fwrite($result_file, $results);
	fclose($result_file);
}

print<<<results
<html>
<head>
<title> Astronomy Quiz </title>
</head>

<body>
 <center><h1><u> Astronomy Quiz for $user </u></h1>
	<h3>Your results are $reported/60</h3>
 </center>
 </body>
<html>
results;
session_destroy();
}

function login(){
	$user_input=$_POST["username"];
	$pwd_input=$_POST["pass"];
	$vars = create_current();
	$users= $vars[0];
	$pwds= $vars[1];	
	for($j=0; $j<count($users); $j++){
		if($user_input===$users[$j]){
			if($pwd_input===$pwds[$j]){
				return $users[$j];
			}else{
				return ""; 
			}
		}
	}
}

function reg(){
	$user_input=$_POST["username"];
	$pwd_input=$_POST["pass"];
	$new_current= fopen ("passwd.txt", "a");
	$new_user_info=$user_input.":".$pwd_input."\n";
	fwrite($new_current, $new_user_info);
	fclose($new_current);
	print ("<center><h5>Thanks for registering, please login</h5></center>");
	welcome();
}

function one_time_check($this_user){
	$check_results= fopen ("results.txt", "r");
	$result_content =  fread ($check_results, filesize("results.txt"));
	$lines_results= explode("\n", $result_content);
	$users=array();
	$scores=array();
	for ($i=0; $i<count($lines_results); $i++){
		$this_line=explode(":",$lines_results[$i]);
		array_push($users, $this_line[0]);
		array_push($scores, $this_line[1]);
	}
	fclose ($check_results);

	for ($i=0; $i<count($users); $i++){
		if ($users[$i]===$this_user){
			return $scores[$i];
		}else{}
	}
	return "";
}

function timer(){
	$current_time=time();
	$time_taken=($current_time)-($_SESSION["time"]);
	if ($time_taken>=900){
		return false;
	}else{
		return true;
}}


if(isset($_POST["complete"])){
	res_report();
}elseif(isset($_POST["q5"])){
	quest6();
}elseif(isset($_POST["q4"])){
	quest5();
}elseif(isset($_POST["q3"])){
	quest4();
}elseif(isset($_POST["q2"])){
	quest3();
}elseif(isset($_POST["q1"])){
	quest2();
}elseif(isset($_POST["login"])){
	if (login()!==""){
		$user=login();
		session_start();
		$_SESSION["id"]=session_id();
		$_SESSION["time"]=time();
		$_SESSION["correct"]=0;
		$_SESSION["question"]=0;
		$_SESSION["tf1"]="";
		$_SESSION["tf2"]="";
		$_SESSION["mc1"]="";
		$_SESSION["mc2"]="";
		$_SESSION["text1"]="";
		$_SESSION["text2"]="";
		$_SESSION["user"]=$user;
		print ("<center><h5>Thanks for logging in</h5></center>");
		$check=one_time_check($_SESSION["user"]);
		if($check!==""){
			print ("<center><h5>$user, you have already taken this quiz and received a score of $check/60</h5></center>");
			session_destroy();
			welcome();
		}else{
		quest1();
		}
	}else{
		print ("<center><h5>Wrong password</h5></center>");
		welcome();
	}
}elseif(isset($_POST["reg"])){
	reg();
}else{
	welcome();
}
?>
