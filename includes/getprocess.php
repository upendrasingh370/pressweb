<?php
	include_once('connectvars.php');
	$query="select bp_id,bp_name from binding_process";
	$row=$db->prepare($query);
	$row->execute();
	$row=$row->get_result();
	$json=array();
	while($r=mysqli_fetch_assoc($row)){
		$json[]=$r;
	}
	$json=json_encode($json);
	echo $json; 
?>