<?php
$title="Change Password";
include_once('includes/head.php');
include_once('includes/power.php');
power($db);
include_once('includes/nav.php');
if(isset($_POST['submit'])){
	$pass=$_POST['current'];
	$newpass=$_POST['pass'];
	$query="select user_id from user where password=SHA('$pass') and user_id=".$_COOKIE['user_id'];
	$result=mysqli_query($db,$query);
	if(mysqli_num_rows($result)>0){
		$id=mysqli_fetch_assoc($result);
		$id=$id['user_id'];
		$query="update user set password=SHA('$newpass') where user_id=$id";
		mysqli_query($db,$query);
		$success="Password changed successfully";
	}
	else{
		$error="Current password entered by you proved to be wrong!";
	}
}
?>
<h1>Change Password</h1>
<hr>
<?php if(isset($error)) echo '<div class="error">'.$error.'</div>'; ?>
<?php if(isset($success)) echo '<div class="success">'.$success.'</div>'; ?>
<form method="post" onsubmit="return validate()">
	<div class="form-group">
		<input class="form-control" type="password" name="current" id="current" placeholder="Current Password"></input>
	</div>
	<div class="form-group">
		<input class="form-control" type="password" name="pass" id="pass" placeholder="Enter New Password"></input>
	</div>
	<div class="form-group">
		<input class="form-control" type="password" name="confirm" id="confirm" placeholder="Retype Password"></input>
	</div>
	<button type="submit" name="submit" class="btn btn-primary">Change Password</button>
</form>
<?php
include_once('includes/script.php');
?>
<script type="text/javascript">
	function validate(){
		var pass=$('#pass').val();
		var confirm=$('#confirm').val();
		if(pass.length<8){
			alert('Password should be longer than 8 characters');
			return false;
		}
		if(pass!=confirm){
			alert('Password and confirm password do not match');
			return false;
		}
	}
</script>
<?php
include_once('includes/foot.php'); 
?>