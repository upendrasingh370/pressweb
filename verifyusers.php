<?php
$title="Verify Users";
include_once('includes/head.php');
include_once('includes/power.php');
power($db);
include_once('includes/nav.php');
?>
<h1>Verify Users</h1>
<hr>
<?php
if(isset($_POST['submit1'])){
	$id=$_POST['user_id'];
	$query="delete from user where user_id=$id";
	mysqli_query($db,$query);
}
if(isset($_POST['submit'])){
	$id=$_POST['user_id'];
	$query2="update user set verified=1 where user_id=$id";
	mysqli_query($db,$query2);
	$query1="select * from user where user_id=$id";
	$result=mysqli_query($db,$query1);
	$result=mysqli_fetch_assoc($result);
	?>
	<div class="row">
	<div class="col-md-6">
	<?php echo $result['fname'].' '.$result['lname'] ?>
	</div>	
	<div class="col-md-6">
		<?php echo $result['email'] ?>
	</div>
	<hr>
	</div>
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
			<input type="checkbox" value="<?php echo $x['function_id'] ?>" name="func[]" ><?php echo $x['function_name'] ?>
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
    <input type="hidden" name="user_id" value="<?php echo $id ?>" >
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
if(isset($_POST['submit2'])){
	$id=$_POST['user_id'];
	foreach($_POST['func'] as $func){
		$query="insert into user_power(user_id,function_id) values($id,$func)";
		mysqli_query($db,$query) or die("error querying db");
	}
}
$query="select * from user where verified=0";
$result=mysqli_query($db,$query);
if(mysqli_num_rows($result)>0){
while($row=mysqli_fetch_array($result)){
?>
<form method="post" class="form1">
<input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
<div class="row">
<div class="col-md-4"><?php echo $row['fname'].' '.$row['lname']; ?></div>
<div class="col-md-4"><?php echo $row['email']; ?></div>
<div class="col-md-2"><button type="submit" name="submit" class="btn btn-success">Verify</button></div>
<div class="col-md-2"><button type="submit" name="submit1" class="btn btn-danger">Reject</button></div>
</div>
<hr>
</form>
<?php
}
}
else{ 
?>
<p>No users to be verified</p>
<?php
}
include_once('includes/script.php');
include_once('includes/foot.php'); 
?>

