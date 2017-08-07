<?php
//Check if user can really access that page
function power($db){
	$link=$_SERVER['REQUEST_URI'];
	$link=basename($link).PHP_EOL;
	$link=trim($link);
	$query="select * from user_power inner join functions on user_power.function_id=functions.function_id where function_link='$link' and user_id=".$_COOKIE['user_id'];
	$result=mysqli_query($db,$query)or die('Error querying db');
	if(mysqli_num_rows($result)==0&&($link!='changepass.php'))
	header('Location: .');
}

//Gets the list of all the functions possible 
function functions($db){
	$query="select * from func_category inner join functions on func_category.fc_id=functions.func_category order by func_category";
	$result=mysqli_query($db,$query);
	return $result;
}

?>