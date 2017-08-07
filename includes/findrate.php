<?php
	include_once('connectvars.php');
	$b_id=$_POST['bp_id'];
	$s_id=$_POST['so_id'];
	$bs_id=$_POST['bs_id'];
	$paper=$_POST['ptype'];
	$machine=$_POST['machine'];
	$bind=$_POST['bind'];
	$query="select * from rate where binding_process=$b_id and special_options=$s_id and book_size=$bs_id and paper_type='$paper' and machine=$machine and bind='$bind'";
	$row=$db->prepare($query);
	$row->execute();
	$row=$row->get_result();
	$result=$row->fetch_assoc();
	$json=json_encode($result);
	echo $json;
	?>