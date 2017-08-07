<?php
	include_once('connectvars.php');
	$trader=$_POST['trader'];
	$query="select bdate,bill_id, amount from bill where trader=$trader";
	$result=mysqli_query($db,$query);
	$bills;
	if(mysqli_num_rows($result)>0){
		$bills=array();
		while($row=mysqli_fetch_assoc($result))
			$bills[]=$row;
	}
	else{
		$bills=null;
	} 
	echo json_encode($bills);
?>