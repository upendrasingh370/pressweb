<?php
$title="Edit Users";
include_once('includes/head.php');
include_once('includes/power.php');
power($db);
include_once('includes/nav.php');
?>
<h1>Edit User</h1>
<hr>
<?php
if(isset($_POST['submit2'])){
	$id=$_POST['user_id'];
	$query="delete from user_power where user_id=$id";
	mysqli_query($db,$query);
	foreach($_POST['func'] as $func){
		$query="insert into user_power(user_id,function_id) values($id,$func)";
		mysqli_query($db,$query) or die("error querying db");
		$success="Successfully updated user";
	}
}
if(isset($_POST['submit'])){
	$email=$_POST['email'];
	if($email!=$_COOKIE['email']){
		$query="select * from user where email='$email'";
		$result=mysqli_query($db,$query);
		if(mysqli_num_rows($result)>0){
			$result=mysqli_fetch_assoc($result);
			if($result['verified']==1){
			$query="select user_power.function_id,function_name from user_power inner join functions on functions.function_id=user_power.function_id where user_id=".$result['user_id']." group by func_category";
			$result1=mysqli_query($db,$query);
			$ids=array();
			$i=0;
			$query="select user_power.function_id,function_name from user_power inner join functions on functions.function_id=user_power.function_id group by func_category";
			$result2=mysqli_query($db,$query);
			while($r=mysqli_fetch_array($result1)){
				$ids[$i]=$r['function_id'];
				$i++;
			}
			?>
			<div class="row">
			<div class="col-xs-3">Name:</div>
			<div class="col-xs-9"><?php echo $result['fname'].' '.$result['lname']; ?></div>
			</div>
			<div class="row">
			<div class="col-xs-3">Email:</div>
			<div class="col-xs-9"><?php echo $result['email']; ?></div>
			</div>
			<hr>
			<h3>Edit Powers</h3>
			<hr>
			<form method="POST">

			<?php
			$data=functions($db);
			$num=0;

			while($x=mysqli_fetch_array($data)){
				if($num%3==0)
					echo '<div class="row">';

			?>
			<div class="col-md-4">
				<label class="checkbox-inline">
					<input type="checkbox" value="<?php echo $x['function_id'] ?>" name="func[]" <?php if(in_array($x['function_id'], $ids)) echo 'checked' ?> ><?php echo $x['function_name'];	?>
				</label>
			</div>
			<?php
			if($num%3==2)
				echo '</div>';
			$num++;
		    }
		    if($num%3!=0)
		    	echo '</div>';
		     ?>
		     <hr>
		     <div class="row">
		     <div class="col-md-4 col-md-offset-4">
		    <input type="hidden" name="user_id" value="<?php echo $result['user_id'] ?>" >
		    <button type="submit" class="btn btn-success" name="submit2">Update</button>
		    </div>
		    <div class="col-md-4">
		    <button type="submit" class="btn btn-primary" name="submit3">Cancel</button>
		    </div>
		    </div>
		    <hr>
		    </form>
			<?php
			}
			else
			$error="User is not verified";
		}
		else
			$error="Email does not exists";
	}
	else
		$error="You cannot edit your own powers";
}
if(!isset($_POST['submit'])||isset($error)){ ?>
<p>Enter the email id of user to be edited</p>
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