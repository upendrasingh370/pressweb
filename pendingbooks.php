<?php
$title="Pending Books";
include_once('includes/head.php');
include_once('includes/power.php');
power($db);
include_once('includes/nav.php');
	$query="select vdate,books.book_code,book_name,book_production.edition,copies_printed,price from book_production inner join books on books.book_code=book_production.book_code left join print_voucher on print_voucher.bp_id=book_production.bp_id where production_status=0 order by books.book_code asc,edition asc";
	$result=mysqli_query($db,$query);
?>
<div class="row text-center">Shri Hari</div>
<table class="table">
	<thead>
		<th>Date</th>
		<th>Book Code</th>
		<th>Book Name</th>
		<th>Edition</th>
		<th>Copies Printed</th>
		<th>Price</th>
	</thead>
	<tbody>
		<?php
		while($row=mysqli_fetch_assoc($result)){
			echo '<tr>';
			echo '<td>'.date("F j, Y",strtotime($row['vdate'])).'</td>';
			echo '<td>'.$row['book_code'].'</td>';
			echo '<td>'.$row['book_name'].'</td>';
			echo '<td>'.$row['edition'].'</td>';
			echo '<td>'.$row['copies_printed'].'</td>';
			echo '<td>'.$row['price'].'</td>';
			echo '</tr>';
		} 
		?>
	</tbody>
</table>
<?php 
include_once('includes/script.php');
?>
<?php
include_once('includes/foot.php'); 
?>