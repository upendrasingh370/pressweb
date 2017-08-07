<?php 
//Redirect to another page if the user is already logged in e.g. Redirect from  register/login page to home.
if(isset($_COOKIE['user_id'])){
	header('Location: .');
}
?>