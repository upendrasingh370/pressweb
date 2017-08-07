<?php
$title="Add Machine";
include_once('includes/head.php');
include_once('includes/power.php');
power($db);
include_once('includes/nav.php');
if(isset($_POST['submit'])){
	$name=ucwords($_POST['name']);
	$query="insert into machine(machine_name) values('$name')";
	mysqli_query($db,$query) or die('Error querying');
	$success="Machine Added";
}
?>
<h1>Add Machine</h1>
<hr>
<?php if(isset($success)) echo '<div class="success">'.$success.'</div>'; ?>
<form method="POST">
	<div class="form-group">
		<input class="form-control" type="text" name="name" required placeholder="Machine Name">
	</div>
	<button class="btn btn-primary" type="submit" name="submit">Add Machine</button>	
</form>
<?php 
include_once('includes/script.php');
include_once('includes/foot.php'); 
?>