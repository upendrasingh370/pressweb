<?php
include_once('connectvars.php');
$code=$_POST['bp_id'];
$query="select book_size,paper_used from books inner join book_production on book_production.book_code=books.book_code where bp_id=$code";
$result=mysqli_query($db,$query);
$result=mysqli_fetch_assoc($result);
$size=$result['book_size'];
$paper=$result['paper_used'];
$query="select p_time,machine.machine_id,machine_name, binding_process.bp_id,bp_name,so_name,special_options.so_id,max_books,book_processed,unreported_books,unprocessed_books,rate,ps_id from production_steps inner join machine on machine.machine_id=production_steps.machine_id inner join binding_process on binding_process.bp_id=production_steps.bp_id inner join special_options on special_options.so_id=production_steps.so_id left join rate on (rate.binding_process=binding_process.bp_id and rate.machine=machine.machine_id and special_options.so_id=rate.special_options and book_size=$size and paper_type='$paper') where bproduction_id=$code";
$x=mysqli_query($db,$query);
$result=array();
while($row1=mysqli_fetch_assoc($x)){
	$result[]=$row1;
}

$result=json_encode($result);
echo $result;
?>