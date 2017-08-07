<?php
$title="Edit Trader";
include_once('includes/head.php');
include_once('includes/power.php');
power($db);
include_once('includes/nav.php');
if(isset($_POST['submit'])){
	$name=$_POST['name'];
	$address=$_POST['address'];
	$contact=$_POST['contact'];
	$pan=$_POST['pan'];
	$license=$_POST['license'];
	$trder=$_POST['trader'];
	$query="select * from trader where (pan='$pan' or license=$license) and trader_id not in ($trder)";
	$result=mysqli_query($db,$query);
	if(mysqli_num_rows($result)==0){
	$query="update trader set name='$name',address='$address',contact='$contact',pan='$pan',license=$license where trader_id=$trder";
	mysqli_query($db,$query);
	$success="Trader Updated";
	}
	else{
		$error="Trader with PAN/Licence number exists";
	} 
}
?>
<h1>Edit Trader</h1>
<hr>
<?php if(isset($error)) echo '<div class="error">'.$error.'</div>'; ?>
		<?php if(isset($success)) echo '<div class="success">'.$success.'</div>'; ?>
<form method="post">
	<div class="form-group">
		<select class="form-control" name="trader" id="trader" onchange="gettrader()">
			<option value="" disabled selected>Trader</option>
			<?php
			$query="select trader_id, name from trader";
			$result=mysqli_query($db,$query);
			while($row=mysqli_fetch_assoc($result))
			echo '<option value="'.$row['trader_id'].'">'.$row['name'].'</option>'; 
			?>
		</select>
	</div>
	<div id="append"></div>
</form>
<?php 
include_once('includes/script.php');
?>
<script type="text/javascript">
	function gettrader(){
		$('#append').empty();
		var trader=$('#trader').val();
		$.ajax({
			method:"post",
			url:"includes/gettrader.php",
			data:{
				trader:trader
			}
		}).done(function(msg){
			msg=$.parseJSON(msg);

				$('#append').append('<div class="form-group"><input class="form-control" name="name" id="name" value="'+msg.name+'" placeholder="Trader Name" required></div>');
				$('#append').append('<div class="form-group"><textarea class="form-control" name="address" placeholder="Address" required>'+msg.address+'</textarea></div>');
				$('#append').append('<div class="form-group"><input class="form-control" name="contact" id="contact" value="'+msg.contact+'" placeholder="Mobile Number" type="number" required></div>');
				$('#append').append('<div class="form-group"><input class="form-control" name="pan" id="pan" value="'+msg.pan+'" placeholder="Pan Card" required></div>');
				$('#append').append('<div class="form-group"><input class="form-control" name="license" id="license" type="number" value="'+msg.license+'" placeholder="License Number" required></div>');
				$('#append').append('<button class="btn btn-primary" type="submit" name="submit">Edit Trader</button>');
		});
	}
</script>
<?php
include_once('includes/foot.php'); 
?>