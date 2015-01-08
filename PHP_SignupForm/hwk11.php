<?php

if(isset($_POST["submit"])){
	get_data();
}else{
	create_form();
}

function create_current(){
        $current = fopen ("./signup.txt", "r");

        $content_current = fread ($current, filesize("./signup.txt"));
        $lines_current = explode("\n", $content_current);
        $times=array();
        $slots=array();
        for ($i=0; $i<count($lines_current); $i++){
                $this_line=explode(":",$lines_current[$i]);
                array_push($times, $this_line[0]);
                array_push($slots, $this_line[1]);
	}
        fclose ($current);
        return array($times, $slots);
}

function create_form(){
	
	$current_values=create_current();
	$times=$current_values[0];
	$slots=$current_values[1];
	$table_out="";
	for($i=0; $i<count($times)-1; $i++){
                if ($times[$i]>7 and $times[$i]<12){
                        $frame = "am";
                }else{
                        $frame = "pm";
                }

		if ($slots[$i]!==""){
		$table_out.="<tr><td>".$times[$i].":00 ".$frame."</td><td>".$slots[$i]."</td></tr>\n";
	}else{
		$table_out.="<tr><td>".$times[$i].":00 ".$frame."</td><td><input type=\"text\" name=\"".$times[$i]."\"></td></tr>\n";
	}
	}


print<<<signup
		<html>
		<head>
		<title>Signup</title>
		</head>
		<body>
		<br>
		<br>
		<center>
		<form method="post" action="./hwk11.php">
		<table align="center" width="50%" border="2px">
		<tr><td colspan="2"><center><b>Signup Sheet</b></center></td></tr>
		$table_out
		
		<tr><td colspan="2"><center><input type="submit" value="Submit" name="submit"></center></td></tr>
		</table>
		</form>
		</center>
		</body>
		</html>
signup;

}

function get_data(){

	$current_values=create_current();
	$times=$current_values[0];
	$slots=$current_values[1];
	$changed=false;

	for($i=0; $i<count($times)-1; $i++){
		if(isset($_POST[$times[$i]])){
			if($_POST[$times[$i]]!==""){
				$slots[$i]=$_POST[$times[$i]];
				$changed=true;
			}else{
				$slots[$i]="";
			}
		}
	}

/*	-- For some reason the count($time) changes after the new file is written, to avoid fixing this because I don't understand why it's happening...I redirect the user to a thank you page before returning to the form. The inconsistency only occurs if a change has been made. To see the error uncomment the print statements

print(count($times)."<br>");
print(count($slots)."<br><br>");
*/

	$new_data="";
	for($i=0; $i<count($times)-1; $i++){
		$new_data.=$times[$i].":".$slots[$i]."\n";
	}
	$new_current= fopen("./signup.txt", "w");
	fwrite($new_current, $new_data);
	fclose($new_current);

/*
$current_values=create_current();
$times=$current_values[0];
$slots=$current_values[1];
print(count($times)."<br>");
print(count($slots)."<br>");
*/

	if($changed){
print<<<thanks
		<html>
		<head>
		<title>Signup</title>
		</head>
		<body>
		<br>
		<br>
		<center>
		<form method="post" action="./hwk11.php">
		<table align="center" width="50%" border="2px">
		<tr><td colspan="2"><center><b>Thanks For Signing Up</b></center></td></tr>
		
		<tr><td colspan="2"><center><input type="submit" value="Return" name="return"></center></td></tr>
		</table>
		</form>
		</center>
		</body>
		</html>
thanks;
	}else{
	create_form();
	}
}

?>
