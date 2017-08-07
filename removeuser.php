<?php
$title="Remove Users";
include_once('includes/head.php');
include_once('includes/power.php');
power($db);
include_once('includes/nav.php');
?>
<h1>Remove User</h1>
<hr>
<?php
if(isset($_POST['submit1'])){
	$id=$_POST['user_id'];
	$query="delete from user_power where user_id=$id";
	mysqli_query($db,$query);
	$query="delete from user where user_id=$id";
	mysqli_query($db,$query);
	$success="User deleted";
}
if(isset($_POST['submit'])){
	$email=$_POST['email'];
	if($email!=$_COOKIE['email']){
	$query="select * from user where email='$email'";
	$result=mysqli_query($db,$query);
	if(mysqli_num_rows($result)>0){
	$result=mysqli_fetch_assoc($result);
	?>
	<p>Kindly Verify that you want to delete this user</p>
	<form method="POST">
	<div class="row">
	<div class="col-xs-3">Name:</div>
	<div class="col-xs-9"><?php echo $result['fname'].' '.$result['lname']; ?></div>
	</div>
	<div class="row">
	<div class="col-xs-3">Email:</div>
	<div class="col-xs-9"><?php echo $result['email']; ?></div>
	</div>
	<hr>
	<input type="hidden" name="user_id" value="<?php echo $result['user_id'] ?>">
	<div class="col-md-3 col-xs-6 nomargin">
	<button type="submit" name="submit1" class="btn btn-danger">Delete</button>
	</div>
	<div class="col-md-3 col-md-6">
	<button type="submit" name="submit2" class="btn btn-primary">Cancel</button>
	</div>
	</form>
	<?php
	}
	else
		$error="Email not found";
	}
	else
	$error="You cannot delete your own account";
} 
if(!isset($_POST['submit'])||isset($error)){ ?>
<p>Enter the email id of user to be removed</p>
<form method="POST">
	<?php if(isset($error)) echo '<div class="error">'.$error.'</div>'; ?>
	<?php if(isset($success)) echo '<div class="success">'.$success.'</div>'; ?>
	<div class="form-group">
    <input type="email" name="email" class="form-control" placeholder="Email">
 	</div>
 	<div class="col-md-3 col-xs-6 nomargin">
    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
  </div>
</form>
<?php } 
include_once('includes/script.php');
include_once('includes/foot.php'); 
?>