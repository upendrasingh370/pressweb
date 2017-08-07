<?php
$title="Add/Edit Print Job";
include_once('includes/head.php');
include_once('includes/power.php');
power($db);
include_once('includes/nav.php');
if(isset($_POST['submit'])){
	$vdate=date('Y-m-d', strtotime($_POST['vdate']));
	$id=$_POST['bp_id'];
	$printed=$_POST['printed'];
	$query="delete from print_voucher where bp_id=$id";
	$total=$_POST['total_printed1'];
	mysqli_query($db,$query);
	$query="insert into print_voucher(bp_id,copies_printed,vdate) values($id,$printed,'$vdate')";
	mysqli_query($db,$query);
	$code=$_POST['book_code'];
	$query="update books set total_printed=$total where book_code=$code";
	mysqli_query($db,$query);	
	$price=$_POST['price'];
	$query="update book_production set price=$price where bp_id=$id";
	mysqli_query($db,$query);
	$psid=$_POST['ps_id'];
	$query="select * from production_steps where bproduction_id=$id order by ps_id asc";
	$result=mysqli_query($db,$query);
	$frow=mysqli_fetch_assoc($result);
	$unprocessed=$printed-$frow['book_processed']-$frow['unreported_books'];
	$query="update production_steps set max_books=$printed, unprocessed_books=$unprocessed where ps_id=".$frow['ps_id'];
	mysqli_query($db,$query);
	$success="Successfully created voucher";
}
?>
<h1>Add/Edit Print Job</h1>
<hr>
<?php if(isset($success)) echo '<div class="success">'.$success.'</div>'; ?>
<form method="post" onsubmit="return validate()">
	<div class="form-group">
		<label>Voucher Date:</label>
		<input class="form-control" type="date" name="vdate" id="vdate" value="<?php echo date('Y-m-d'); ?>" required></input>
	</div>
	<div class="form-group">
		<input type="number" name="book_code" id="book_code" class="form-control" onchange="getbook()" placeholder="Book Code" required>
	</div>
	<div id="append"></div>
	<div class="form-group">
		<input class="form-control" type="number" name="printed" id="printed" placeholder="Copies Printed" required onchange="total()"></input>
		<input type="hidden" name="xprinted" id="xprinted" value=0>
	</div>
	<div class="form-group">
		<input type="number" name="price" id="price" class="form-control" placeholder="Price" required >
	</div>
	<div id="append1"></div>
	<button class="btn btn-primary" class="submit" id="submit" name="submit" type="submit">Add Print Voucher</button>
</form>
<?php 
include_once('includes/script.php');
?>
<script type="text/javascript">
	function getbook(){
		$('#append').empty();
		var book_code=$('#book_code').val();
		$.ajax({
			method: "POST",
			url: "includes/findbook1.php",
			data: { book_code: book_code }
		}).done(function(msg){
			if(msg!="null"){
				msg=jQuery.parseJSON(msg);
				$('#append').append('<div class="form-group"><label>Book Name:</label> '+msg.book_name+'</div>');
				$('#append').append('<div class="form-group capital"><label>Language:</label>  '+msg.book_lang+'</div>');
				$('#append').append('<div class="form-group"><label>Edition:</label><select name="edition" id="edition" class="form-control" onchange="getedition()"><option disabled selected>Book Edition</option><select><input type="hidden" name="max_edition" id="max_edition" value="'+msg.latest_edition+'"></div>');
				$.each(msg.edition,function(it,item){
					$('#edition').append('<option value="'+item.bp_id+'">'+item.edition+'</option>');
				});
				$('#append').append('<input type="hidden" name="total_printed" id="total_printed" value="'+msg.total_printed+'">');
			}
			else{
				alert("Book not found");
				$('#book_code').val(null);
				return;
			}
		});
	}

	function getedition(){
		$('#append1').empty();
		$('#xprinted').removeAttr('value');
		$('.x').remove();
		var bp_id=$('#edition').val();
		$.ajax({
			method: "POST",
			url: "includes/fetcheditiondetails.php",
			data: { bp_id: bp_id }
		}).done(function(msg){
			if(msg!="null"){
				msg=$.parseJSON(msg);
				$('#xprinted').attr('value',msg.copies_printed);
				$('#printed').val(msg.copies_printed);
				if(msg.price!=0)
				$('#price').val(msg.price);
				$('#append').append('<div class="form-group x"><label>Sections:</label>  '+msg.section+'</div>');
				$('#append').append('<div class="form-group x"><label>Colored Section:</label>  '+msg.csection+'</div>');
				if(msg.book_processed>0)
				$('#append').append('<input type="hidden" name="book_processed" id="book_processed" value="'+msg.book_processed+'">');
			$('#append').append('<input type="hidden" name="bp_id" id="bp_id" value="'+msg.bproduction_id+'"><input type="hidden" name="ps_id" id="ps_id" value="'+msg.ps_id+'">');
				total();
			}
		});
	}

	function total(){
		var books=parseInt($('#book_processed').val());
		var printed=parseInt($('#printed').val());
		var xprinted=parseInt($('#xprinted').val());
		var total_printed=parseInt($('#total_printed').val());
		if(books!=null&&books>printed){
			alert('Can\'t go this low, more books have been processed');
			$('#printed').val(xprinted);
			printed=xprinted;
			return;	
		}
		var total;
		if(!isNaN(xprinted))
		 total=printed+total_printed-xprinted;
		else
			total=printed+total_printed;
		if(!isNaN(printed)){
			$('#append1').empty();
			$('#append1').append('<div class="form-group"><label>Total Book Printed:<label>   '+total+'</div><input type="hidden" name="total_printed1" id="total_printed1" value="'+total+'">');
		}
	}
	function validate(){
		if($('#book_code').val()==null){
			alert("Book Code should not be empty");
			return false;
		}
		if($('#edition').val()==null){
			alert("Please select edition");
			return false;
		}
		if($('#printed').val()==null){
			alert("No of copies should not be zero");
			return false;
		}
		if($('#price').val()==null){
			alert("Price cant be left blank");
			return false;
		}
	}
</script>
<?php
include_once('includes/foot.php'); 
?>