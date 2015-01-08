<?php

function login(){
	$user_input=$_POST["username"];
	$pwd_input=$_POST["pass"];
	$vars = create_current();
	$users= $vars[0];
	$pwds= $vars[1];	
	for($j=0; $j<count($users); $j++){
		if($user_input===$users[$j]){
			if($pwd_input===$pwds[$j]){
				return true; 
			}else{
				return false; 
			}
		}
	}
}

function create_current(){
	$current = fopen ("./dbase/passwd.txt", "r");

	$content_current = fread ($current, filesize("./dbase/passwd.txt"));
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
	<br>
	<br>
	<br>
	<form method="POST" action="./hwk14.php">
	<table>
	<tr><td colspan="2"><b>Student Records Login</b></td></tr>
	<tr><td>Username:</td><td><input type="text" name="username"></td></tr>
	<tr><td>Password:</td><td><input type="password" name="pass"></td></tr>
	<tr><td><input type="submit" value="Login" name="login"></td><td><input type="reset" value="Reset"></td></tr>
	</table>
	</form>
	</center>
	</body>
	</html>
welcome;
}

function options_page(){
	session_start();
	if(session_id()===$_SESSION["this"]){

print <<<options
	<html>
	<head>
	<title>Student DBS</title>
	</head>
	<body>
	<center>
	<br>
	<br>
	<br>
	<form method="POST" action="./hwk14.php">
	<table>
	<tr><td><b>Student Records</b></td></tr>
	<tr><td><input type="submit" name="insert" value="Insert Student Record"></td></tr>
	<tr><td><input type="submit" name="update" value="Update Student Record"></td></tr>
	<tr><td><input type="submit" name="delete" value="Delete Student Record"></td></tr>
	<tr><td><input type="submit" name="view" value="View Student Record"></td></tr>
	<tr><td><input type="submit" name="logout" value="Logout"></td></tr>
	</table>
	</form>
	</center>
	</body>
	</html>
options;
}else{
	welcome();
}
}

function insert_page(){
	session_start();
	if (session_id()===$_SESSION["this"]){

print<<<insert
	<html>
	<head>
	<title>Student DBS</title>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

	</head>
	<body>
	<center>
	<br>
	<br>
	<br>
	
	<form method="POST" action="./hwk14.php"> 
	<table>
	<tr><td colspan="2"><b>Insert Student Record</b></td></tr>
	<tr><td colspan="2">Please fill out all fields</td></tr>
	<tr><td>ID</td><td><input required type="text" name="id"></td></tr>
	<tr><td>LAST</td><td><input required type="text" name="last"></td></tr>
	<tr><td>FIRST</td><td><input required type="text" name="first"></td></tr>
	<tr><td>MAJOR</td><td><input required type="text" name="major"></td></tr>
	<tr><td>GPA</td><td><input required type="text" name="gpa"></td></tr>
	<tr><td><input type="submit" value="Submit" name="insert_studs"></td>
		<td><input type="reset" value="Reset"></td></tr>
	</table>
	</form>
	</center>
	</body>
	</html>	
insert;
}else{
	welcome();
}
}

function insert_func(){

	$id=$_POST["id"];
	$last=$_POST["last"];
	$first=$_POST["first"];
	$major=$_POST["major"];
	$gpa=$_POST["gpa"];

	if(
		(0<strlen($id))&&(strlen($id)<10)&&(preg_match('/^[0-9]{1,10}$/', $id))
		&&(0<strlen($last))&&(strlen($id)<20)&&(preg_match('/^[a-z A-Z \- \s]{1,20}$/', $last))
		&&(0<strlen($first))&&(strlen($id)<20)&&(preg_match('/^[a-z A-Z \- \s]{1,20}$/', $first))
		&&(0<strlen($major))&&(strlen($id)<50)&&(preg_match('/^[a-z A-Z \- \s]{1,50}$/', $major))
		&&(0<strlen($gpa))&&(strlen($id)<10)&&(preg_match('/^[0-4]{1}\.[0-9]{1,10}$/', $gpa))
	){


	$id=intval($id);
	$gpa=floatval($gpa);

	$host = "127.0.0.1";
	$user = "root";
	$pwd = "*";
	$dbs = "evanjohnston";
	//$port = "3306";
	$connect = mysqli_connect ($host, $user, $pwd, $dbs);
	$table = "Students";
	/*
	$host = "fall-2014.cs.utexas.edu";
	$user = "evanaj12";
	$pwd = "_zqAskkb9~";
	$dbs = "cs329e_evanaj12";
	$port = "3306";
	$connect = mysqli_connect ($host, $user, $pwd, $dbs, $port);
	*/
	if (empty($connect))
	{
		die("mysqli_connect failed: " . mysqli_connect_error());
	}

	//print "Connected to ". mysqli_get_host_info($connect) . "<br><hr><br>\n";

	$stmt="INSERT INTO $table (id, last, first, major, gpa) VALUES ($id, '$last', '$first', '$major', $gpa)";
	$connect->query($stmt);
	mysqli_close($connect);
	
}else{
print("<center><h3>Input Error, please use correct format</h3><table width='30%'><tr><td>ID</td><td>Integer</td></tr><tr><td>Last, First, Major</td><td>Letters, spaces, hyphens</td></tr><tr><td>GPA</td><td>Floating</td></tr></table></center>");
}
}

function update_page(){
	session_start();
	if (session_id()===$_SESSION["this"]){

print<<<update
	<html>
	<head>
	<title>Student DBS</title>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

	</head>
	<body>
	<center>
	<br>
	<br>
	<br>
	
	<form method="POST" action="./hwk14.php"> 
	<table>
	<tr><td colspan="2"><b>Update Student Record</b></td></tr>
	<tr><td colspan="2">Please fill out ID and at least 1 other field</td></tr>
	<tr><td>ID</td><td><input required type="text" name="id"></td></tr>
	<tr><td>LAST</td><td><input type="text" name="last"></td></tr>
	<tr><td>FIRST</td><td><input type="text" name="first"></td></tr>
	<tr><td>MAJOR</td><td><input type="text" name="major"></td></tr>
	<tr><td>GPA</td><td><input type="text" name="gpa"></td></tr>
	<tr><td><input name="update_studs" type="submit" value="Submit"></td>
		<td><input type="reset" value="Reset"></td></tr>
	</table>
	</form>
	</center>
	</body>
	</html>	
update;
}else{
	welcome();
}
}

function update_func(){
	$id=$_POST["id"];
	$last=$_POST["last"];
	$first=$_POST["first"];
	$major=$_POST["major"];
	$gpa=$_POST["gpa"];

	if(
		((0<strlen($id))&&(strlen($id)<10)&&(preg_match('/^[0-9]{1,10}$/', $id)))
		&&(((0<strlen($last))&&(strlen($id)<20)&&(preg_match('/^[a-z A-Z \- \s]{1,20}$/', $last)))
			||((0<strlen($first))&&(strlen($id)<20)&&(preg_match('/^[a-z A-Z \- \s]{1,20}$/', $first)))
			||((0<strlen($major))&&(strlen($id)<50)&&(preg_match('/^[a-z A-Z \- \s]{1,50}$/', $major)))
			||((0<strlen($gpa))&&(strlen($id)<10)&&(preg_match('/^[0-4]{1}\.[0-9]{1,10}$/', $gpa))))
	){

	$id=intval($id);
	$gpa=floatval($gpa);

	$host = "127.0.0.1";
	$user = "root";
	$pwd = "*";
	$dbs = "evanjohnston";
	//$port = "3306";
	$connect = mysqli_connect ($host, $user, $pwd, $dbs);
	$table = "Students";
	/*
	$host = "fall-2014.cs.utexas.edu";
	$user = "evanaj12";
	$pwd = "_zqAskkb9~";
	$dbs = "cs329e_evanaj12";
	$port = "3306";
	$connect = mysqli_connect ($host, $user, $pwd, $dbs, $port);
	*/
	if (empty($connect))
	{
		die("mysqli_connect failed: " . mysqli_connect_error());
	}

	//print "Connected to ". mysqli_get_host_info($connect) . "<br><hr><br>\n";

	if($_POST["last"]!==""){
		$stmt="UPDATE $table SET last='$last' WHERE id=$id;";
		$connect->query($stmt);
	}
	if($_POST["first"]!==""){
		$stmt="UPDATE $table SET first='$first' WHERE id=$id;";
		$connect->query($stmt);
	}
	if($_POST["major"]!==""){
		$major=$_POST["major"];
		$stmt="UPDATE $table SET major='$major' WHERE id=$id;";
		$connect->query($stmt);
	}
	if($_POST["gpa"]!==""){
		$stmt="UPDATE $table SET gpa=$gpa WHERE id=$id;";
		$connect->query($stmt);
	}
	
	mysqli_close($connect);
}else{
print("<center><h3>Input Error, please use correct format</h3><table width='30%'><tr><td>ID</td><td>Integer</td></tr><tr><td>Last, First, Major</td><td>Letters, spaces, hyphens</td></tr><tr><td>GPA</td><td>Floating</td></tr></table></center>");
}
}

function delete_page(){
	session_start();
	if (session_id()===$_SESSION["this"]){

print<<<delete_student
	<html>
	<head>
	<title>Student DBS</title>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

	</head>
	<body>
	<center>
	<br>
	<br>
	<br>
	
	<form method="POST" action="./hwk14.php"> 
	<table>
	<tr><td colspan="2"><b>Delete Student Record</b></td></tr>
	<tr><td colspan="2">Please fill out ID</td></tr>
	<tr><td>ID</td><td><input required type="text" name="id"></td></tr>
	<tr><td><input name="delete_studs" type="submit" value="Submit"></td>
		<td><input type="reset" value="Reset"></td></tr>
	</table>
	</form>
	</center>
	</body>
	</html>	
delete_student;
}else{
	welcome();
}

}

function delete_func(){
	$id=$_POST["id"];

	if(
		((0<strlen($id))&&(strlen($id)<10)&&(preg_match('/^[0-9]{1,10}$/', $id)))
	){

	$id=intval($id);

	$host = "127.0.0.1";
	$user = "root";
	$pwd = "*";
	$dbs = "evanjohnston";
	//$port = "3306";
	$connect = mysqli_connect ($host, $user, $pwd, $dbs);
	$table = "Students";
	/*
	$host = "fall-2014.cs.utexas.edu";
	$user = "evanaj12";
	$pwd = "_zqAskkb9~";
	$dbs = "cs329e_evanaj12";
	$port = "3306";
	$connect = mysqli_connect ($host, $user, $pwd, $dbs, $port);
	*/
	if (empty($connect))
	{
		die("mysqli_connect failed: " . mysqli_connect_error());
	}

	//print "Connected to ". mysqli_get_host_info($connect) . "<br><hr><br>\n";

	$stmt="DELETE FROM $table WHERE id=$id;";
	$connect->query($stmt);
	
	mysqli_close($connect);
}else{
print("<center><h3>Input Error, please use correct format</h3><table width='30%'><tr><td>ID</td><td>Integer</td></tr><tr><td>Last, First, Major</td><td>Letters, spaces, hyphens</td></tr><tr><td>GPA</td><td>Floating</td></tr></table></center>");
}
}


function view_page(){
	session_start();
	if (session_id()===$_SESSION["this"]){

print<<<view
	<html>
	<head>
	<title>Student DBS</title>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

	</head>
	<body>
	<center>
	<br>
	<br>
	<br>
	
	<form method="POST" action="./hwk14.php"> 
	<table>
	<tr><td colspan="2"><b>ViewStudent Record</b></td></tr>
	<tr><td colspan="2">Please fill out at least 1 criteria</td></tr>
	<tr><td>ID</td><td><input type="text" name="id"></td></tr>
	<tr><td>LAST</td><td><input type="text" name="last"></td></tr>
	<tr><td>FIRST</td><td><input type="text" name="first"></td></tr>
	<tr><td><input name="view_studs" type="submit" value="Submit"></td>
		<td><input type="reset" value="Reset"></td></tr>
	<tr><td><input type="submit" value="View All Student Records" name="view_all_studs"></td></tr>
	</table>
	</form>
	</center>
	</body>
	</html>	
view;

}else{
	welcome();
}
}

function view_func(){
	$id=$_POST["id"];
	$last=$_POST["last"];
	$first=$_POST["first"];

	if(
		((0<strlen($id))&&(strlen($id)<10)&&(preg_match('/^[0-9]{1,10}$/', $id)))
		||((0<strlen($last))&&(strlen($id)<20)&&(preg_match('/^[a-z A-Z \- \s]{1,20}$/', $last)))
		||((0<strlen($first))&&(strlen($id)<20)&&(preg_match('/^[a-z A-Z \- \s]{1,20}$/', $first)))
	){

	
	$host = "127.0.0.1";
	$user = "root";
	$pwd = "*";
	$dbs = "evanjohnston";
	//$port = "3306";
	$connect = mysqli_connect ($host, $user, $pwd, $dbs);
	$table = "Students";
	/*
	$host = "fall-2014.cs.utexas.edu";
	$user = "evanaj12";
	$pwd = "_zqAskkb9~";
	$dbs = "cs329e_evanaj12";
	$port = "3306";
	$connect = mysqli_connect ($host, $user, $pwd, $dbs, $port);
	*/
	if (empty($connect))
	{
		die("mysqli_connect failed: " . mysqli_connect_error());
	}

	//print "Connected to ". mysqli_get_host_info($connect) . "<br><hr><br>\n";

// Get data from a table in the database and print it out

	$ivar=false;
	$lvar=false;
	$fvar=false;

	if($_POST["id"]!==""){
		$id=intval($id);
		$ivar=true;
	}
	if($_POST["last"]!==""){
		$lvar=true;
	}
	if($_POST["first"]!==""){
		$fvar=true;
	}
	
	//id
	if(($ivar)&&(!($lvar))&&(!($fvar))){
	$result = mysqli_query($connect, "SELECT * from $table WHERE id='$id' ORDER BY last");
	}

	//last
	elseif((!($ivar))&&($lvar)&&(!($fvar))){
	$result = mysqli_query($connect, "SELECT * from $table WHERE last='$last' ORDER BY last");
	}
	
	//first
	elseif((!($ivar))&&(!($lvar))&&($fvar)){
	$result = mysqli_query($connect, "SELECT * from $table WHERE first='$first' ORDER BY last");
	}
	
	//id+last
	elseif(($ivar)&&($lvar)&&(!($fvar))){
	$result = mysqli_query($connect, "SELECT * from $table WHERE id='$id' AND last='$last' ORDER BY last");
	}
	
	//id+first
	elseif(($ivar)&&(!($lvar))&&($fvar)){
	$result = mysqli_query($connect, "SELECT * from $table WHERE id='$id' AND first='$first' ORDER BY last");
	}
	
	//last+first
	elseif((!($ivar))&&(!($lvar))&&($fvar)){
	$result = mysqli_query($connect, "SELECT * from $table WHERE last='$last' AND first='$first' ORDER BY last");
	}
	
	//id+first+last
	elseif(($ivar)&&($lvar)&&($fvar)){
	$result = mysqli_query($connect, "SELECT * from $table WHERE id='$id' AND last='$last' AND first='$first' ORDER BY last");
	}

	else{
		print<<<no_res
	<html>
	<head>
	<title>Student DBS</title>


	</head>
	<body>
	<center>
	<br>
	<br>
	<br>

	There were no results found
	<br>
	<form method="POST" action="./hwk14.php"> 
	<input type="submit" value="New Action">
	</form>
	</center>
	</body>
	</html>	
no_res;
	return;	
	}
	
	$output=array ();

	while ($row = $result->fetch_row())
	{
  		array_push($output, $row);
	}

	$num_rows=count($output);
	$table_out="";
	for($i=0; $i<$num_rows; $i++){
		$table_out.="<tr><td>".$output[$i][0]."</td>
				<td>".$output[$i][1]."</td>
				<td>".$output[$i][2]."</td>
				<td>".$output[$i][3]."</td>
				<td>".$output[$i][4]."</td></tr>";
	}
	
print<<<view
	<html>
	<head>
	<title>Student DBS</title>
	<style>
		td{ border: solid 1px black;}
	</style>
	</head>
	<body>
	<center>
	<br>
	<br>
	<br>

	<table width="40%">
	<tr><td colspan="5"><center>Students</center></td></tr>
	<tr><td>ID</td><td>Lastname</td><td>Firstname</td><td>Major</td><td>GPA</td></tr>
	$table_out
	</table>
	<br>
	<form method="POST" action="./hwk14.php"> 
	<input type="submit" value="New Action">
	</form>
	</center>
	</body>
	</html>	
view;
	mysqli_close($connect);
}else{
print("<center><h3>Input Error, please use correct format</h3><table width='30%'><tr><td>ID</td><td>Integer</td></tr><tr><td>Last, First, Major</td><td>Letters, spaces, hyphens</td></tr><tr><td>GPA</td><td>Floating</td></tr></table><form method=\"POST\" action=\"./hwk14.php\">
        <input type=\"submit\" value=\"New Action\">
        </form></center>");
}
}

function view_all_func(){
	$host = "127.0.0.1";
	$user = "root";
	$pwd = "*";
	$dbs = "evanjohnston";
	//$port = "3306";
	$connect = mysqli_connect ($host, $user, $pwd, $dbs);
	$table = "Students";
	/*
	$host = "fall-2014.cs.utexas.edu";
	$user = "evanaj12";
	$pwd = "_zqAskkb9~";
	$dbs = "cs329e_evanaj12";
	$port = "3306";
	$connect = mysqli_connect ($host, $user, $pwd, $dbs, $port);
	*/
	
	if (empty($connect))
	{
		die("mysqli_connect failed: " . mysqli_connect_error());
	}

	//print "Connected to ". mysqli_get_host_info($connect) . "<br><hr><br>\n";

// Get data from a table in the database and print it out

	$result = mysqli_query($connect, "SELECT * from $table ORDER BY last");
	
	$output=array ();

	while ($row = $result->fetch_row())
	{
  		array_push($output, $row);
	}

	$num_rows=count($output);
	$table_out="";
	for($i=0; $i<$num_rows; $i++){
		$table_out.="<tr><td>".$output[$i][0]."</td>
				<td>".$output[$i][1]."</td>
				<td>".$output[$i][2]."</td>
				<td>".$output[$i][3]."</td>
				<td>".$output[$i][4]."</td></tr>";
	}
	
print<<<view
	<html>
	<head>
	<title>Student DBS</title>

	<style>
		td{ border: solid 1px black;}
	</style>

	</head>
	<body>
	<center>
	<br>
	<br>
	<br>

	<table width="40%" style="border: solid 1px black;">
	<tr><td colspan="5"><center>Students</center></td></tr>
	<tr><td>ID</td><td>Lastname</td><td>Firstname</td><td>Major</td><td>GPA</td></tr>
	$table_out
	</table>
	<br>
	<form method="POST" action="./hwk14.php"> 
	<input type="submit" value="New Action">
	</form>
	</center>
	</body>
	</html>	
view;
	mysqli_close($connect);
}

function logout_page(){
	session_start();
	session_unset();
	session_destroy();

print<<<logout
	<html>
	<head>
	<title>Student DBS</title>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

	</head>
	<body>
	<center>
	<br>
	<br>
	<br>

	<h3>Thank you for logging out.<br> Good bye </h3>	
	<form method="POST" action="./hwk14.php"> 
		<input type="submit" value="Home">
	</form>
	</center>
	</body>
	</html>	
logout;

}
function check(){

	

	$id=$_POST["id"];
	$last=$_POST["last"];
	$first=$_POST["first"];
	$major=$_POST["major"];
	$gpa=$_POST["gpa"];

	if (($last==="")&&($first==="")&&($major==="")&&($gpa==="")){
		return false;
	}else{
		return true;
	}
}

	
if (isset($_POST["logout"])){
	logout_page();
}elseif (isset($_POST["insert"])){
	insert_page();
}elseif (isset($_POST["insert_studs"])){
	insert_func();
	options_page();
}elseif (isset($_POST["update"])){
	update_page();
}elseif (isset($_POST["update_studs"])){
	update_func();
	options_page();
}elseif (isset($_POST["delete"])){
	delete_page();
}elseif (isset($_POST["delete_studs"])){
	delete_func();
	options_page();
}elseif (isset($_POST["view"])){
	view_page();
}elseif (isset($_POST["view_studs"])){
	view_func();
}elseif (isset($_POST["view_all_studs"])){
	view_all_func();
}elseif (isset($_POST["login"])){
	if(login()){
		session_start();
		$_SESSION["this"]=session_id();
		options_page();
	}else{
		print ("<br><center><h3>Login Failed</h3></center>");
		welcome();
	}
}else{
	session_start();
	if (session_id()===$_SESSION["this"]){
		options_page();
	}else{
	welcome();
	}
}
?>
