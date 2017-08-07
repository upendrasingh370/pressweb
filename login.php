<?php
$title='Login';
$user=0;
include_once('includes/redirectlogin.php'); 
include_once('includes/head.php');
include_once('includes/login.php');
?>
<div id="login_outer">
	<div id="login_inner" class="col-md-4 col-xs-6 col-md-offset-4 col-xs-offset-3">
		<h1>Gita Press - Post Press</h1>
		<h3>Log In</h3>
		<?php if(isset($error)) echo '<div class="error">'.$error.'</div>'; ?>
		<form method="POST">
			<div class="form-group">
				    <input type="email" class="form-control" placeholder="Email" name="email" required>
               </div>
               <div class="form-group">
               		<input type="password" class="form-control" placeholder="Password" name="pass" required>	
               </div>
               <button type="submit" name="submit" class="btn btn-primary">Log In</button>
               <a href="register.php" class="col-xs-offset-6">Create an Account</a>
		</form>
	</div>	
</div>
<?php
include_once('includes/script.php');
include_once('includes/foot.php'); 
?>