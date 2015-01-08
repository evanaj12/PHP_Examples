<?php

$user= $_GET["user"];
echo (check_user($user));

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

function check_user($js_returned_user){
	$user_input=$js_returned_user;
	$vars = read_pass();
	$users= $vars[0];
	for($j=0; $j<count($users); $j++){
		if($user_input===$users[$j]){
			return true; 
		}
	}
	return false;
}

?>
