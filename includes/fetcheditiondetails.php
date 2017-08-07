<?php
	include_once('connectvars.php');
	$bp_id=$_POST['bp_id'];
	$query="select bproduction_id,edition,section,csection,price,ps_id,book_processed,unprocessed_books,copies_printed,vdate from book_production inner join production_steps on book_production.bp_id=production_steps.bproduction_id left join print_voucher on book_production.bp_id=print_voucher.bp_id where book_production.bp_id=$bp_id and production_status=0 order by ps_id asc";
	$row=$db->prepare($query);
	$row->execute();
	$row=$row->get_result();
	$result=$row->fetch_assoc();
	$json=json_encode($result);
	echo $json;
?>