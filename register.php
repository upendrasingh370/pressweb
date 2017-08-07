<?php
$title='Register';
include_once('includes/head.php');
include_once('includes/redirectlogin.php');
include_once('includes/register.php');
?>
<div id="login_outer">
	<div id="login_inner" class="col-md-4 col-xs-6 col-md-offset-4 col-xs-offset-3">
		<h1>Gita Press - Post Press</h1>
		<h3>Register</h3>
		<?php if(isset($error)) echo '<div class="error">'.$error.'</div>'; ?>
		<?php if(isset($success)) echo '<div class="success">'.$success.'</div>'; ?>
		<div class="error1">Passwords do not match or password length should be 8</div>
		<form method="POST" onsubmit="return validate()">
			<div class="col-md-6">
			<div class="form-group">
				<input type="text" name="fname" class="form-control" placeholder="First Name" required>
			</div>
			</div>
			<div class="col-md-6">
			<div class="form-group">
				<input type="text" name="lname" class="form-control" placeholder="Last Name" required>
			</div>
			</div>
			<div class="col-md-12">
			<div class="form-group">
				    <input type="email" class="form-control" placeholder="Email" name="email" required>
               </div>
               </div>
               <div class="col-md-6">
               <div class="form-group">
               		<input type="password" class="form-control" placeholder="Password" name="pass" id="pass" required>	
               </div>
               </div>
               <div class="col-md-6">
               <div class="form-group">
               		<input type="password" class="form-control" placeholder="Retype Password" name="confpass" id="confpass" required>	
               </div>
               </div>
               <button type="submit" name="submit" class="btn btn-primary">Log In</button>
               <a href="login.php" class="col-xs-offset-6">Log In</a>
		</form>
	</div>	
</div>
<?php
include_once('includes/script.php');
?>
<script type="text/javascript">
	function validate(){
		var conf=$('#confpass').val();
		var pass=$('#pass').val();

		if(conf!=pass){
			alert('Passwords do not match');
			return false;
		}
		else if(pass.length<8){
			alert('Password should atleast be 8 digits long');
			return false;
		}
		else{
			$(".error").css("display","none");
		}
	}
</script>
<?php
include_once('includes/foot.php'); 
?>