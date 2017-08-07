<?php
	include_once('connectvars.php');
	$code=$_POST['book_code'];
	$query="select * from books inner join book_size on books.book_size=book_size.bs_id where book_code=$code limit 1";
	$row=$db->prepare($query);
	$row->execute();
	$row=$row->get_result();
	$result=$row->fetch_assoc();
	$json=json_encode($result);
	echo $json;
?>