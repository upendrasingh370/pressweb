<?php
$title="Generate Bill";
include_once('includes/head.php');
include_once('includes/power.php');
power($db);
include_once('includes/nav.php');
if(isset($_POST['submit'])){
	$trader=$_POST['trader'];
	$date=$_POST['bdate'];
	$query="select books.book_code,books.book_name,voucher_id, book_production.edition,(section+csection) as section,rate_section,bp_name,(vouchers.processed_books-billed_books) as books_billed,billed_books,vouchers.rate,count_mode from vouchers inner join production_steps on production_steps.ps_id=vouchers.ps_id inner join book_production on bproduction_id=book_production.bp_id inner join books on books.book_code=book_production.book_code inner join binding_process on production_steps.bp_id=binding_process.bp_id where trader=$trader and (vouchers.processed_books-billed_books)>0";
	$result=mysqli_query($db,$query);
	$sum=0;
	if(mysqli_num_rows($result)>0){
		$query="insert into bill(bdate,trader) values('$date',$trader)";
		mysqli_query($db,$query);
		$query="select bill_id from bill where bdate='$date' and trader=$trader order by bill_id desc limit 1";
		$res1=mysqli_query($db,$query);
		$res1=mysqli_fetch_assoc($res1);
		$res1=$res1['bill_id'];
		while($row=mysqli_fetch_assoc($result)){
			if($row['count_mode']=='per book'){
				$x=1;
			}else if($row['count_mode']=='per 100'){
				$x=100;
			}else if($row['count_mode']=='per 1000'){
				$x=1000;
			}
			$amt=($row['books_billed']*$row['rate'])/$x;
			if($row['rate_section']==1){
				$amt=$amt*$row['section'];
			}
			$sum=$sum+$amt;
			$query='insert into bill_voucher(bill_id,voucher_id,books,amount) values('.$res1.','.$row['voucher_id'].','.$row['books_billed'].','.$amt.')';
			mysqli_query($db,$query);
			$query="update vouchers set billed_books=".($row['billed_books']+$row['books_billed'])." where voucher_id=".$row['voucher_id'];
			mysqli_query($db,$query);
		} 
		$commision=round(0.2*$sum,2);
		$amount=$sum+$commision;
		$query="update bill set amount=$amount, commision=$commision where bill_id=$res1";
		mysqli_query($db,$query);
		$query="select bill_id from bill where amount=$amount and commision=$commision order by bill_id desc limit 1";
		$resul=mysqli_query($db,$query);
		$resul=mysqli_fetch_assoc($resul);
		$success="Bill number ".$resul['bill_id'];
	}
	else{
		$error="Nothing to bill!";
	}
}
?>
<h1>Generate Bill</h1>
<hr>
<?php if(isset($error)) echo '<div class="error">'.$error.'</div>'; ?>
		<?php if(isset($success)) echo '<div class="success">'.$success.'</div>'; ?>
<form method="post" onsubmit="return validate()">
	<div class="form-group">
		<input class="form-control" type="date" name="bdate" value="<?php echo date('Y-m-d'); ?>"></input>
	</div>
	<div class="form-group">
		<select class="form-control" name="trader" id="trader">
			<option value="" disabled selected>Trader</option>
			<?php
			$query="select trader_id, name from trader";
			$result=mysqli_query($db,$query);
			while($row=mysqli_fetch_assoc($result))
			echo '<option value="'.$row['trader_id'].'">'.$row['name'].'</option>'; 
			?>
		</select>
	</div>
	<button class="btn btn-primary" type="submit" name="submit">Generate Bill</button>
</form>
<?php
include_once('includes/script.php');
?>
<script type="text/javascript">
	function validate(){
		var trader=$('#trader').val();
		if(trader==null){
			alert("Trader can't be empty");
			return false;
		}
	}
</script>
<?php
include_once('includes/foot.php'); 
?>