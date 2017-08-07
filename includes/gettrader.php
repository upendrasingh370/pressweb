<?php 
	include_once('connectvars.php');
	$trader=$_POST['trader'];
	$query="select * from trader where trader_id=$trader";
	$result=mysqli_query($db,$query);
	echo json_encode(mysqli_fetch_assoc($result));
?>