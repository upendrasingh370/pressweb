<?php
$title="Add Binding Process";
include_once('includes/head.php');
include_once('includes/power.php');
power($db);
include_once('includes/nav.php');
if(isset($_POST['submit'])){
	$name=$_POST['process_name'];
	$process_type=$_POST['process_type'];
	$process_time=$_POST['process_time'];
	$count_mode=$_POST['count_mode'];
	$rate_section=$_POST['rate_section'];
	if($rate_section=="")
		$rate_section=0;
	else
		$rate_section=1;
	$query="insert into binding_process(bp_name,p_type,p_time,count_mode,rate_section) values('$name','$process_type','$process_time','$count_mode',$rate_section)";
	mysqli_query($db,$query) or die('error querying');
	$query="select bp_id from binding_process where bp_name='$name' and p_type='$process_type' and p_time='$process_time' order by bp_id desc limit 1";
	$result=mysqli_query($db,$query) or die('error fetching data');
	$result=mysqli_fetch_assoc($result);
	$id=$result['bp_id'];
	if(isset($_POST['so1'])){
		$so1=$_POST['so1'];
		$query="insert into bp_so(bp_id,so_id) values($id,$so1)";
		mysqli_query($db,$query);
	}
	if(isset($_POST['so2'])){
		$so2=$_POST['so2'];
		$query="insert into bp_so(bp_id,so_id) values($id,$so2)";
		mysqli_query($db,$query);
	}
	if(isset($_POST['so3'])){
		$so3=$_POST['so3'];
		$query="insert into bp_so(bp_id,so_id) values($id,$so3)";
		mysqli_query($db,$query);
	}
	if(isset($_POST['so4'])){
		$so4=$_POST['so4'];
		$query="insert into bp_so(bp_id,so_id) values($id,$so4)";
		mysqli_query($db,$query);
	}
	if(isset($_POST['machine1'])){
		$m=$_POST['machine1'];
		$query="insert into bp_machine(bp_id,machine_id) values($id,$m)";
		mysqli_query($db,$query);
	}
	if(isset($_POST['machine2'])){
		$m=$_POST['machine2'];
		$query="insert into bp_machine(bp_id,machine_id) values($id,$m)";
		mysqli_query($db,$query);
	}
	if(isset($_POST['machine3'])){
		$m=$_POST['machine3'];
		$query="insert into bp_machine(bp_id,machine_id) values($id,$m)";
		mysqli_query($db,$query);
	}
	$success="Binding process edited";
}
?>
<h1>Add Binding Process</h1>
<hr>
<?php if(isset($success)) echo '<div class="success">'.$success.'</div>'; ?>
<form method="POST" onsubmit="return validate()">
	<div class="form-group">
		<input class="form-control" type="text" name="process_name" placeholder="Process Name" required></input>
	</div>
	<div class="form-group">
		<select class="form-control" id="type" name="process_type">
			<option value="" disabled selected>Process Type</option>
			<option value="section">Section Process</option>
			<option value="book">Book Process</option>
		</select>
	</div>
	<div class="form-group">
		<select class="form-control" id="time" name="process_time">
		<option value="" disabled selected>Process Time</option>
			<option value="final">Final</option>
			<option value="intermediate">Intermediate</option>
		</select>
	</div>
	<div class="form-group">
		<select class="form-control" id="count" name="count_mode">
		<option value="" disabled selected>Count Mode</option>
			<option value="per book">Per Book</option>
			<option value="per 100">Per 100</option>
			<option value="per 1000">Per 1000</option>
		</select>
	</div>
	<div class="form-group">
	<div class="checkbox" >
		<label><input type="checkbox" name="rate_section" id="check">Rate depends on section</label>
	</div>
	</div>
	<div class="form-group">
		<select class="form-control" id="machine1" name="machine1" onchange="check2()">
			<option value="" disabled selected>Machine 1</option>
			<?php
			$query="select machine_id,machine_name from machine order by machine_name";
			$result1=mysqli_query($db,$query);
			while($r=mysqli_fetch_array($result1)){
			?>
			<option value="<?php echo $r['machine_id']; ?>" ><?php echo $r['machine_name'] ?></option>
			<?php
			} 
			?>
		</select>
	</div>
	<div class="form-group">
		<select class="form-control" onchange="check2()" id="machine2" name="machine2">
			<option value="" disabled selected>Machine 2</option>
			<?php
			$query="select machine_id,machine_name from machine order by machine_name";
			$result1=mysqli_query($db,$query);
			while($r=mysqli_fetch_array($result1)){
			?>
			<option value="<?php echo $r['machine_id']; ?>" ><?php echo $r['machine_name'] ?></option>
			<?php
			} 
			?>
		</select>
	</div>
	<div class="form-group">
		<select class="form-control" id="machine3" onchange="check2()" name="machine3">
			<option value="" disabled selected>Machine 3</option>
			<?php
			$query="select machine_id,machine_name from machine order by machine_name";
			$result1=mysqli_query($db,$query);
			while($r=mysqli_fetch_array($result1)){
			?>
			<option value="<?php echo $r['machine_id']; ?>" ><?php echo $r['machine_name'] ?></option>
			<?php
			} 
			?>
		</select>
	</div>
	<div class="form-group">
		<select class="form-control" id="so1" name="so1" onchange="check1()">
			<option value="" disabled selected>Special Option 1</option>
			<?php
			$query="select so_id,so_name from special_options order by so_name";
			$result1=mysqli_query($db,$query);
			while($r=mysqli_fetch_array($result1)){
			?>
			<option value="<?php echo $r['so_id']; ?>" ><?php echo $r['so_name'] ?></option>
			<?php
			} 
			?>
		</select>
	</div>
	<div class="form-group">
		<select class="form-control" id="so2" onchange="check1()" name="so2">
			<option value="" disabled selected>Special Option 2</option>
			<?php
			$query="select so_id,so_name from special_options order by so_name";
			$result1=mysqli_query($db,$query);
			while($r=mysqli_fetch_array($result1)){
			?>
			<option value="<?php echo $r['so_id']; ?>" ><?php echo $r['so_name'] ?></option>
			<?php
			} 
			?>
		</select>
	</div>
	<div class="form-group">
		<select class="form-control" id="so3" name="so3" onchange="check1()">
			<option value="" disabled selected>Special Option 3</option>
			<?php
			$query="select so_id,so_name from special_options order by so_name";
			$result1=mysqli_query($db,$query);
			while($r=mysqli_fetch_array($result1)){
			?>
			<option value="<?php echo $r['so_id']; ?>" ><?php echo $r['so_name'] ?></option>
			<?php
			} 
			?>
		</select>
	</div>
	<div class="form-group">
		<select class="form-control" id="so4" name="so4" onchange="check1()">
			<option value="" disabled selected>Special Option 4</option>
			<?php
			$query="select so_id,so_name from special_options order by so_name";
			$result1=mysqli_query($db,$query);
			while($r=mysqli_fetch_array($result1)){
			?>
			<option value="<?php echo $r['so_id']; ?>" ><?php echo $r['so_name'] ?></option>
			<?php
			} 
			?>
		</select>
	</div>
	<button class="btn btn-primary" type="submit" name="submit">Add Binding Process</button>
</form>
<?php 
include_once('includes/script.php');
?>
<script type="text/javascript">
	
	function check2(){
		var m1=$('#machine1').val();
		var m2=$('#machine2').val();
		var m3=$('#machine3').val();
		if(m3!=null){
			if(m3==m1||m3==m2){
				$('#machine3').prop('selectedIndex',0);
				return;
			}
		}
		if(m2!=null){
			if(m2==m1){
				$('#machine2').prop('selectedIndex',0);
				return;
			}
		}
	}

	function check1(){
		var s1=$('#so1').val();
		var s2=$('#so2').val();
		var s3=$('#so3').val();
		var s4=$('#so4').val();
		if(s4!=null){
			if(s4==s3||s4==s2||s4==s1){
				$('#so4').prop('selectedIndex',0);
				return;
			}
		}
		if(s3!=null){
			if(s3==s2||s3==s1){
				$('#so3').prop('selectedIndex',0);
				return;
			}
		}
		if(s2!=null){
			if(s2==s1){
				$('#so2').prop('selectedIndex',0);
				return;
			}
		}
	}

	function validate(){
		var type=$('#type').val();
		if(type==null){
			alert('Select the process type');
			return false;
		}
		var time=$('#time').val();
		if(time==null){
			alert('Select the process time');
			return false;
		}
		var count=$('#count').val();
		if(count==null){
			alert('Select the count mode');
			return false;
		}
		var machine1=$('#machine1').val();
		var m2=$('#machine2').val();
		var m3=$('#machine3').val();
		if(machine1==null&&m2==null&&m3==null){
			alert('Select machine for binding process');
			return false;
		}
		var so1=$('#so1').val();
		var s2=$('#so2').val();
		var s3=$('#so3').val();
		var s4=$('#so4').val();
		if(so1==null&&s2==null&&s3==null&&s4==null){
			alert("Select the special option");
			return false;
		}
	}
</script>
<?php
include_once('includes/foot.php'); 
?>