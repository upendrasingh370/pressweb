<?php
	include_once('connectvars.php');
	
	if(isset($_POST['bp_id'])){
	$bp_id=$_POST['bp_id'];
	$query="select ps_id from production_steps left join print_voucher on bproduction_id=print_voucher.bp_id where step_final=0 and bproduction_id=$bp_id and copies_printed>0";
	$result=mysqli_query($db,$query);
	$vouchers=array();
	while($row=mysqli_fetch_assoc($result)){
		$query="select vdate,voucher_id,processed_books,unreported_books from vouchers where final=0 and ps_id=".$row['ps_id'];
		$result1=mysqli_query($db,$query);
		while($row1=mysqli_fetch_assoc($result1)){
			$vouchers[]=$row1;
		}
	}
	}
	else{
		$query="select vdate, ps_id,voucher_id,processed_books,unreported_books from vouchers where final=0 and voucher_id=".$_POST['voucher'];
		$result=mysqli_query($db,$query);
		$vouchers=array();
		while($row=mysqli_fetch_assoc($result))
			$vouchers[]=$row;
	}
	if(sizeOf($vouchers)==0)
		$sorted=null;
	else
		$sorted=array_orderby($vouchers,'vdate',SORT_ASC,'processed_books',SORT_DESC);
	echo json_encode($sorted);

	function array_orderby()
	{
	    $args = func_get_args();
	    $data = array_shift($args);
	    foreach ($args as $n => $field) {
	        if (is_string($field)) {
	            $tmp = array();
	            foreach ($data as $key => $row)
	                $tmp[$key] = $row[$field];
	            $args[$n] = $tmp;
	            }
	    }
	    $args[] = &$data;
	    call_user_func_array('array_multisort', $args);
	    return array_pop($args);
	}
?>