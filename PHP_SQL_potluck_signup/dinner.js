//test 3 javascript/jquery

$(document).ready(function(){

$("#real").submit(function(){
	var name=$("#name").val();
	var item=$("#item").val();
	var blank=/^\s$/;

	function check(){
		if((name==="Your Name")||(name==="")||(blank.test(name))
			||(item==="Your Item")||(item==="")||(blank.test(item))){
	
			alert("Please enter all fields");
			return false;
		}else{
			return true;
		}
	}

	return check();
});

});
