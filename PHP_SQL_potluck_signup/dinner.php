<?php
//test3 php - dinner
//state is maintained with unlimited sessions destroyed upon logout

if (isset($_POST["logout"])){
        logout_page();
}elseif(isset($_POST["submit"])){
	insert_func();
	new_action();
}elseif(isset($_POST["continue"])){
	view_all_func();
}elseif(isset($_POST["login"])){
	if(login()){
	        session_start();
                $_SESSION["this"]=session_id();
		view_all_func();
	}else{
		print ("<br><center><h3>Login Failed</h3></center>");
                welcome();
	}
}else{
        session_start();
        if (session_id()===$_SESSION["this"]){
		new_action();
        }else{
        welcome();
        }
}

//Dr. Mitra's basic purge function
function purge ($str)
  {
    $purged_str = preg_replace("/\W/", "", $str);
    return $purged_str;
  }

function login(){
	$user_input= purge($_POST["username"]);
	$pwd_input= purge($_POST["pass"]);
	$user_regex="/^guest$/i";
	$pass_regex="/^dinner$/i";
	if((preg_match($user_regex, $user_input))&&(preg_match($pass_regex, $pwd_input))){
		return true;
	}else{
		return false;
	}
}

function logout_page(){
        session_start();
        session_unset();
        session_destroy();

print<<<logout
        <html>
        <head>
        <title>Potluck Logout</title>
	<link rel="stylesheet" name="style1" type="text/css" href="./dinner.css">
        </head>
        <body>
        <center>
        <br>
        <br>
        <br>

        <h3>Thank you for logging out.<br> Good bye </h3>       
        <form method="POST" action="./dinner.php"> 
                <input type="submit" value="Home">
        </form>
        </center>
        </body>
        </html> 
logout;

}

function welcome(){

print <<<welcome
	<html>
	<head>
	<title>Potluck Login</title>
	<link rel="stylesheet" name="style1" type="text/css" href="./dinner.css">
	</head>
	<body>
	<center>
	<br>
	<br>
	<br>
	<form method="POST" action="./dinner.php">
	<table>
	<tr><td colspan="2" class='title'><center><b>Potluck Dinner Login</b></center></td></tr>
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

function view_all_func(){

        session_start();
        if (session_id()===$_SESSION["this"]){
	
	$host = "127.0.0.1";
	$user = "root";
	$pwd = "*";
	$dbs = "evanjohnston";
	//$port = "3306";
	$connect = mysqli_connect ($host, $user, $pwd, $dbs);
	$table = "Dinner";	
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
		welcome();
		return;
	}

	//print "Connected to ". mysqli_get_host_info($connect) . "<br><hr><br>\n";

// Get data from a table in the database and print it out

	$result = mysqli_query($connect, "SELECT * from $table ORDER BY name");
	
	$output=array ();

	while ($row = $result->fetch_row())
	{
  		array_push($output, $row);
	}

	$num_rows=count($output);
	$table_out="";
	for($i=0; $i<$num_rows; $i++){
		$table_out.="<tr><td class='box'>".$output[$i][0]."</td>
				<td class='box'>".$output[$i][1]."</td></tr>";
	}
	
print<<<view
	<html>
	<head>
	<title>Potluck Signup</title>
	<link rel="stylesheet" name="style1" type="text/css" href="./dinner.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="./dinner.js"></script>

	</head>
	<center>
	<br>
	<br>
	<br>

	<table width="40%"> 
	<form method="POST" action="./dinner.php" id="real"> 
	<tr><td colspan="2" class='title'><center><b>Potluck Signup</b></center></td></tr>
	<tr><td><center><u>Name</u></center></td><td><center><u>Item</u></center></td></tr>
	$table_out
	<tr><td class='box'><input type="text" value="Your Name" name="name" id="name"></td>
		<td class='box'><input type="text" value="Your Item" name="item" id="item"></td>
		</tr>
	<tr><td><center><input type="submit" value="Submit" name="submit"></center></td>
		<td><center><input type="reset" value="Clear"></center></td>
		</tr>
	</form>

	<form method="POST" action="./dinner.php" id="dummy">
        <tr><td colspan="2"><center><input type="submit" value="Logout" name="logout"></center></td></tr>
	</form>

	</table>
	</center>
	</body>
	</html>	
view;
	mysqli_close($connect);
	}else{
	welcome();
	}
}

function insert_func(){

	//input checking done by mysqli_real_escape_string function and by regex checker
	$host = "127.0.0.1";
	$user = "root";
	$pwd = "*";
	$dbs = "evanjohnston";
	//$port = "3306";
	$connect = mysqli_connect ($host, $user, $pwd, $dbs);
	$table = "Dinner";
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
		welcome();
		return;
	}

	//print "Connected to ". mysqli_get_host_info($connect) . "<br><hr><br>\n";
	$name=mysqli_real_escape_string($connect, $_POST["name"]);
	$item=mysqli_real_escape_string($connect, $_POST["item"]);

	if(
		(0<strlen($name))&&(strlen($name)<21)&&(preg_match('/^[a-z A-Z \- \s]{1,20}$/', $name))
			&&($name!=="Your Name")
		&&(0<strlen($item))&&(strlen($item)<101)&&(preg_match('/^[\w \- \s]{1,100}$/', $item))
			&&($item!=="Your Item")
	){

	$table = "dinner";

	$stmt="INSERT INTO $table (name, items) VALUES ('$name', '$item')";
	$connect->query($stmt);
	mysqli_close($connect);
	
}else{
	if(($name!=="Your Name")||($item!=="Your Item")){
print("<center><h3>Input Error, please only use letters, spaces, or hyphens.<br>
		(numbers can be used in items column)</h3></center>");
	}else{
	return;
	}
}
}

function new_action(){

        session_start();
        if (session_id()===$_SESSION["this"]){
	
print <<<new_act
	<html>
	<head>
	<title>Potluck Thank You</title>
	<link rel="stylesheet" name="style1" type="text/css" href="./dinner.css">
	</head>
	<body>
	<center>
	<br>
	<br>
	<br>
	<form method="POST" action="./dinner.php">
	<table>
	<tr><td colspan="2" class='title'><b>Thank you for your contribution.</b></td></tr>
	<tr><td colspan="2">What would you like to do now?</td></tr>
	<tr><td><input type="submit" value="Add Another Item" name="continue"></td>
		<td><input type="submit" value="Logout" name="logout"></td></tr>
	</table>
	</form>
	</center>
	</body>
	</html>
new_act;

}else{
	welcome();
	}
}

?>
