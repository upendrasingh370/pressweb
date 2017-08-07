<?php
$title="Print Bill";
include_once('includes/head.php');
include_once('includes/power.php');
power($db);
include_once('includes/nav.php');
if(isset($_POST['submit'])){
	$bill_id=$_POST['bill'];
	$query="select bdate,name, amount,pan,license,commision from bill inner join trader on trader.trader_id=trader where bill_id=$bill_id";
	$result=mysqli_query($db,$query);
	$details=mysqli_fetch_assoc($result);
	$query="select books.book_code,count_mode,books.book_name,bill_voucher.voucher_id, book_production.edition,(section+csection) as section,bill_voucher.amount,rate_section,bp_name,bill_voucher.books,vouchers.rate,bdate from bill_voucher inner join bill on bill.bill_id=bill_voucher.bill_id inner join vouchers on vouchers.voucher_id=bill_voucher.voucher_id inner join production_steps on production_steps.ps_id=vouchers.ps_id inner join book_production on bproduction_id=book_production.bp_id inner join books on books.book_code=book_production.book_code inner join binding_process on production_steps.bp_id=binding_process.bp_id where bill_voucher.bill_id=$bill_id";
	$result=mysqli_query($db,$query);
	?>
	<div class="row text-center">Shri Hari</div>
	<div class="row">
		<div class="col-md-6 text-left book_name"><?php echo $details['name'] ?></div>
		<div class="col-md-6 text-right"><?php echo "Date: ".date("F j, Y",strtotime($details['bdate'])) ?></div>
		<div class="col-md-6 text-right"><?php echo "Pan: ".$details['pan'] ?></div>
	</div>
	<div class="row">
	<div class="col-md-6 text-left"><?php echo "Bill No: ".$bill_id ?></div>
	<div class="col-md-6 text-right"><?php echo "License: ".$details['license'] ?></div>
	</div>
	<table class="table">
	<thead>
	<th>Code</th>
	<th>Book Name</th>
	<th>Edition</th>
	<th>Sections</th>
	<th>Process</th>
	<th>Copies</th>
	<th>Rate</th>
	<th>Amount</th>
	</thead>
	<tbody>
		<?php 
		while($row=mysqli_fetch_assoc($result)){
			echo '<tr>';
			echo '<td>'.$row['book_code'].'</td>';
			echo '<td>'.$row['book_name'].'</td>';
			echo '<td>'.$row['edition'].'</td>';
			echo '<td>'.($row['section']+0).'</td>';
			echo '<td>'.$row['bp_name'].'</td>';
			echo '<td>'.$row['books'].'</td>';
			if($row['count_mode']=='per book'){
				echo '<td>'.($row['rate']+0).'</td>';
			}
			else if($row['count_mode']=='per 100'){
				echo '<td>'.($row['rate']+0).'/h</td>';
			}
			else if($row['count_mode']=='per 1000'){
				echo '<td>'.($row['rate']+0).'/t</td>';
			}
			echo '<td>'.($row['amount']+0).'</td>';
			echo '</tr>';
		}
		?>
		<tr>
		<td colspan="7" class="text-right"><b>Total :<b></td>
		<td><?php echo ($details['amount']-$details['commision']) ?></td>
		</tr>
		<tr>
			<td colspan="7" class="text-right"><b>Extra 20% :<b></td>
			<td><?php echo $details['commision'] ?></td>
		</tr>
		<tr>
			<td colspan="7" class="text-right"><b>Total amount payable :<b></td>
			<td><?php echo $details['amount'] ?></td>
		</tr>
	</tbody>
	</table>
	<?php
}
if(!isset($_POST['submit'])||isset($error)){
?>
<h1>Print Bill</h1>
<hr>
<form method="post" onsubmit="return validate()">
	<div class="form-group">
		<select class="form-control" name="trader" id="trader" onchange="getbill()">
			<option value="" disabled selected>Trader</option>
			<?php
			$query="select trader_id, name from trader";
			$result=mysqli_query($db,$query);
			while($row=mysqli_fetch_assoc($result))
			echo '<option value="'.$row['trader_id'].'">'.$row['name'].'</option>'; 
			?>
		</select>	
	</div>
	<div class="form-group">
		<select name="bill" id="bill" class="form-control">
			<option value="" disabled selected>Bill</option>
		</select>
	</div>
	<button type="submit" name="submit" class="btn btn-primary">Get Bill</button>
</form>
<?php
}
include_once('includes/script.php');
?>
<script type="text/javascript">
	function getbill(){
		$('#bill').empty();
		$('#bill').append('<option value="" disabled selected>Bill</option>');
		var trader=$('#trader').val();
		$.ajax({
			method:"post",
			url:"includes/getbill.php",
			data:{
				trader: trader
			}
		}).done(function(msg){
			msg=$.parseJSON(msg);
			if(msg!=null){
				$.each(msg,function(it,item){
					$('#bill').append('<option value="'+item.bill_id+'">Bill:'+item.bill_id+', Date:'+item.bdate+', Amount:'+item.amount+'</option>')
				});
			}
			else{
				alert("No Bills to show");
				$('#bill').prop('selectedIndex',0);
				return;
			}
		});
	}
	function validate(){
		var trader=$('#trader').val();
		if(trader==null){
			alert("Trader can't be empty");
			return false;
		}
		var bill=$('#bill').val();
		if(bill==null){
			alert("Select a bill");
			return false;
		}
	}
</script>
<?php
include_once('includes/foot.php'); 
?>