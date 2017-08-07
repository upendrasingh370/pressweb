<?php
$title="Print History";
include_once('includes/head.php');
include_once('includes/power.php');
power($db);
include_once('includes/nav.php');
if(isset($_POST['submit'])){
	$book_code=$_POST['book_code'];
	$query="select book_name,bs_name,total_printed from books inner join book_size on bs_id=book_size where book_code=$book_code";
	$result=mysqli_query($db,$query);
	$book_details=mysqli_fetch_assoc($result);
	?>
	<div class="text-center row">Shri Hari</div>
	<div class="row">
		<div class="col-md-6 text-left book_name"><?php echo $book_details['book_name'] ?></div>
		<div class="col-md-6 text-right"><?php echo "Book Code: ".$book_code ?></div>
		<div class="col-md-6 text-right"><?php echo "Book Size: ".$book_details['bs_name'] ?></div>		
	</div>
	<br>
	<?php
	$color=0;
	$query="select bp_id from book_production where book_code=$book_code and csection>0";
	$result=mysqli_query($db,$query);
	if(mysqli_num_rows($result)>0){
		$color=1;
	}
	$query="select edition, section,firma,price,copies_printed,vdate,csection from book_production inner join print_voucher on book_production.bp_id=print_voucher.bp_id where book_code=$book_code order by edition";
	$result=mysqli_query($db,$query);
	?>
	<table class="table table1">
	<thead>
		<tr>
		<th>Edition</th>
		<th>Date</th>
		<th>Copies Printed</th>
		<th>Firma</th>
		<th>Section</th>
		<?php if($color==1) echo '<th>Color Section</th>' ?>
		<th>Price</th>
		</tr>
	</thead>
	<tbody>
	<?php
	while($row=mysqli_fetch_assoc($result)){
		echo '<tr>';
		echo '<td>'.$row['edition'].'</td>';
		echo '<td>'.date("F j, Y",strtotime($row['vdate'])).'</td>';
		echo '<td>'.$row['copies_printed'].'</td>';
		echo '<td>'.($row['firma']+0).'</td>';
		echo '<td>'.($row['section']+0).'</td>';
		if($color==1)
			echo '<td>'.($row['csection']+0).'</td>';
		echo '<td>'.($row['price']+0).'</td>';
		echo '</tr>';
	}
	?>
	<tr>
		<td colspan="7" class="text-right"><b>Total Copies Printed:    </b><?php echo $book_details['total_printed'] ?></td>
	</tr>
	</tbody>
	</table>
	<?php 
}
if(isset($error)||!isset($_POST['submit'])){
?>
<h1>Reprint History</h1>
<hr>
	<form method="post">
		<div class="form-group">
			<input class="form-control" name="book_code" id="book_code" type="number" required placeholder="Book Code"></input>
		</div>
		<button class="btn btn-primary" type="submit" name="submit">Get Reprint History</button>
	</form>
<?php 
}
include_once('includes/script.php');
?>
<?php
include_once('includes/foot.php'); 
?>