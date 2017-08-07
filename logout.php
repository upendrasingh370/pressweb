<?php
 include_once('includes/checklogin.php');
 	setcookie('user_id', '', time()-7000000);
	setcookie('email', '', time()-7000000);
	setcookie('fname', '', time()-7000000);
	setcookie('lname', '', time()-7000000);
	setcookie('pow', '', time()-7000000);
	header('Location:login.php');
  
?>