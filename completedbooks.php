<?php
$title="Completed Books";
include_once('includes/head.php');
include_once('includes/power.php');
power($db);
include_once('includes/nav.php');
if(isset($_POST['submit'])){
	$query="select book_name,book_lang,bs_name,isbn from books inner join book_size on bs_id=book_size where book_code=".$_POST['book_code'];
	$result=mysqli_query($db,$query);
	if(mysqli_num_rows($result)>0){
		$book_details=mysqli_fetch_assoc($result);
		$query="select copies_printed, edition,vdate from book_production inner join print_voucher on book_production.bp_id=print_voucher.bp_id where book_code=".$_POST['book_code'].' order by vdate';
		$result=mysqli_query($db,$query);
		if(mysqli_num_rows($result)==0){
			$error= 'No editions completed';
		}
		else{
?>
<div class="row text-center">Shri Hari</div>
<div class="col-md-6 text-left book_name"><?php echo $book_details['book_name'] ?></div>
	<div class="col-md-6 text-right"><?php echo "Book Code: ".$_POST['book_code'] ?></div>
	<div class="col-md-6 text-right"><?php echo "Book Size: ".$book_details['bs_name'] ?></div>
	<table class="table">
		<thead>
			<th>Date</th>
			<th>Edition</th>
			<th>Copies Printed</th>
		</thead>
		<tbody>
		<?php
		while($row=mysqli_fetch_assoc($result)){
			echo '<tr>';
			echo '<td>'.date("F j, Y",strtotime($row['vdate'])).'</td>';
			echo '<td>'.$row['edition'].'</td>';
			echo '<td>'.$row['copies_printed'].'</td>';
			echo '</tr>';
		}
		?>
		</tbody>
	</table>
<?php
		}
	}
	else{
		$error="Book Not found";
	}
}
if(!isset($_POST['submit'])||isset($error)){
?>
<h1>Completed Books</h1>
<hr>
<form method="post">
	<div class="form-group">
		<input type="number" class="form-control" name="book_code" required placeholder="Book Code">
	</div>
	<button class="btn btn-primary" name="submit" type="submit">Get Details</button>	
</form>
<?php 
}
include_once('includes/script.php');
?>
<?php
include_once('includes/foot.php'); 
?>