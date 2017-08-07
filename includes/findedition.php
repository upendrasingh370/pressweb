<?php
	include_once('connectvars.php');
	$edition=$_POST['edition'];
	$code=$_POST['book_code'];
	$query="select * from book_production where edition=$edition and book_code=$code";
	$row=$db->prepare($query);
	$row->execute();
	$row=$row->get_result();
	$result=$row->fetch_assoc();
	$json=json_encode($result);
	echo $json; 
?>