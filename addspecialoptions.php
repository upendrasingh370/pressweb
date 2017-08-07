<?php
$title="Add Special Options";
include_once('includes/head.php');
include_once('includes/power.php');
power($db);
include_once('includes/nav.php');
if(isset($_POST['submit'])){
	$option=ucwords($_POST['option']);
	$query="insert into special_options(so_name) values('$option')";
	mysqli_query($db,$query);
	$success="Special Options Added";
}
?>
<h1>Add Special Options</h1>
<hr>
<?php if(isset($success)) echo '<div class="success">'.$success.'</div>'; ?>
<form method="POST">
	<div class="form-group">
		<input class="form-control" type="text" name="option" placeholder="Special Option Name" required></input>
	</div>
	<button type="submit" class="btn btn-primary" name="submit">Add Option</button>
</form>
<?php 
include_once('includes/script.php');
include_once('includes/foot.php'); 
?>