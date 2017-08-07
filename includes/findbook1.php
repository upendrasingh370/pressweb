<?php
	include_once('connectvars.php');
	$code=$_POST['book_code'];
	$query="select book_name,book_lang,latest_edition,total_printed from books inner join book_size on books.book_size=book_size.bs_id where book_code=$code limit 1";
	$row=$db->prepare($query);
	$row->execute();
	$row=$row->get_result();
	$result=$row->fetch_assoc();
	if($result!=null){
	$query="select book_production.bp_id, edition,copies_printed from book_production left join print_voucher on book_production.bp_id=print_voucher.bp_id inner join books on book_production.book_code=books.book_code where book_production.book_code=$code and production_status=0 order by edition";
	$result['edition']=array();
	$row1=$db->prepare($query);
	$row1->execute();
	$row1=$row1->get_result();
	while($r=mysqli_fetch_assoc($row1)){
		$result['edition'][]=$r;
	}
}
	$json=json_encode($result);
	echo $json;
?>