<?php
$title="Add Trader";
include_once('includes/head.php');
include_once('includes/power.php');
power($db);
include_once('includes/nav.php');
if(isset($_POST['submit'])){
	$name=$_POST['name'];
	$address=$_POST['address'];
	$mobile=$_POST['mobile'];
	$pan=strtoupper($_POST['pan']);
	$license=$_POST['licence'];
	$query="select * from trader where pan='$pan' or license=$license";
	$result=mysqli_query($db,$query) or die("Error querying");
	if(mysqli_num_rows($result)==0){
		$query="insert into trader(name,address,contact,pan,license) values('$name','$address',$mobile,'$pan',$license)";
		mysqli_query($db,$query);
		$success="Trader added, happy trading!!";
	}
	else
		$error='Trader with PAN/Licence number exists';
}
?>
<h1>Add Trader</h1>
<hr>
<?php if(isset($error)) echo '<div class="error">'.$error.'</div>'; ?>
		<?php if(isset($success)) echo '<div class="success">'.$success.'</div>'; ?>
<form method="post">
	<div class="form-group">
		<input class="form-control" type="text" name="name" placeholder="Trader Name" required>
	</div>
	<div class="form-group">
		<textarea class="form-control" name="address" placeholder="Address" required></textarea>
	</div>
	<div class="form-group">
		<input class="form-control" name="mobile" type="number" placeholder="Mobile Number" required></input>
	</div>
	<div class="form-group">
		<input class="form-control" name="pan" type="text" placeholder="PAN Card" required></input>
	</div>
	<div class="form-group">
		<input class="form-control" name="licence" type="text" placeholder="License Number" required></input>
	</div>
	<button class="btn btn-primary" type="submit" name="submit">Add</button>
</form>
<?php 
include_once('includes/script.php');
include_once('includes/foot.php'); 
?>