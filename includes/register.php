<?php
	//Backend for registration
	if(isset($_POST['submit'])){
		$fname=$_POST['fname'];
		$lname=$_POST['lname'];
		$email=$_POST['email'];
		$pass=$_POST['pass'];
		$confpass=$_POST['confpass'];
		$query="select * from user where email='$email'";
		$result=mysqli_query($db,$query) or die('error querying database');
		if(mysqli_num_rows($result)==0){
			if($pass==$confpass){
			$query="insert into user(fname,lname,email,password) values('$fname','$lname','$email',SHA('$pass'))";
			mysqli_query($db,$query) or die('error querying database 1');
			$success="User registered";
		}
		else{
			$error="Passwords do not match";
		}
		}
		else{
			$error="Email already registered";
		}
	}
?>