<?php
$title="Add Binding Process";
include_once('includes/head.php');
include_once('includes/power.php');
power($db);
include_once('includes/nav.php');
if(isset($_POST['submit'])){
	$rate=$_POST['rate'];
	if(isset($_POST['rate_id'])){
		$id=$_POST['rate_id'];
		$query="update rate set rate=$rate where rate_id=$id";
		mysqli_query($db,$query) or die('error_querying');
		$success="Rate updated";
	}
	else{
		$bindingprocess=$_POST['binding_process'];
		$special=$_POST['special'];
		$book_size=$_POST['book_size'];
		$ptype=$_POST['paper_type'];
		$machine=$_POST['machine'];
		$bind=$_POST['bind'];
		$query="insert into rate(binding_process,special_options,book_size,paper_type,rate,machine,bind) values($bindingprocess,$special,$book_size,'$ptype',$rate,$machine,'$bind')";
		mysqli_query($db,$query) or die($query);
		$success="Rate added";
	}
}
?>
<h1>Add/Edit Rate</h1>
<hr>
<?php if(isset($success)) echo '<div class="success">'.$success.'</div>'; ?>
<form method="post" onsubmit="return validate()">
	<div class="form-group">
		<select class="form-control" onchange="getData(this.value)" name="binding_process" id="binding_process">
			<option value="" disabled selected>Binding Process</option>
			<?php
			$query="select * from binding_process"; 
			$result=mysqli_query($db,$query);
			while($row=mysqli_fetch_array($result)){
			?>
			<option value="<?php echo $row['bp_id']?>"><?php echo $row['bp_name'] ?></option>
			<?php
			}
			?>
		</select>
	</div>
	<div id="append"></div>
	<div class="form-group">
		<select class="form-control" name="book_size" id="book_size" onchange="check()">
			<option value="" disabled selected>Book Size</option>
			<?php
			$query="select bs_id,bs_name from book_size";
			$result=mysqli_query($db,$query);
			while($row=mysqli_fetch_array($result)){ 
			?>
			<option value="<?php echo $row['bs_id']; ?>"><?php echo $row['bs_name'] ?></option>
			<?php
			 } 
			?>
		</select>
	</div>
	<div class="form-group">
		<select class="form-control" name="paper_type" id="paper_type" onchange="check()">
			<option value="" disabled selected>Paper Type</option>
			<option value="standard">Standard Paper</option>
			<option value="deluxe">Deluxe Paper</option>
			<option value="art">Art Paper</option>
		</select>
	</div>
	<div class="form-group">
		<select class="form-control" name="bind" id="bind" onchange="check()">
			<option value="" disabled selected>Bind</option>
			<option value="hard">Hard Bound</option>
			<option value="soft">Soft Bound</option>
		</select>
	</div>
	<div class="form-group">
		<input class="form-control" type="number" step="0.01" placeholder="Rate" name="rate" id="rate"></input>
	</div>
	<button type="submit" class="btn btn-primary" name="submit">Add Rate</button>
</form>
<?php 
include_once('includes/script.php');
?>
<script type="text/javascript">
	function validate(){
		var b_process=$('#binding_process').val();
		var b_size=$('#book_size').val();
		var p_type=$('#paper_type').val();
		var rate=$('#rate').val();
		var special=$('#special').val();
		var machine=$('#machine').val();
		if(b_process==null){
			alert('Select Binding Process');
			return false;
		}
		if(special==null){
			alert('Select Special Options');
			return false;
		}
		if(b_size==null){
			alert("Select Book Size");
			return false;
		}
		if(p_type==null){
			alert("Select paper type");
			return false;
		}
		var rate1=$.trim(rate)
		if(rate==null || rate1=="" || rate==0){
			alert("Enter positive value for rate");
			return false;
		}
		var curr_rate=$('#current_rate').val();
		if(curr_rate.length>0){
			if(curr_rate==rate){
				alert("The value provided by you is already updated");
				return false;
			}
			else{
				if(!confirm("The current rate is "+rate+", do you want to update it with "+curr_rate)){
					return false;
				}
			}
		}
	}

	function check(){
		var b_process=$('#binding_process').val();
		var b_size=$('#book_size').val();
		var p_type=$('#paper_type').val();
		var rate=$('#rate').val();
		var special=$('#special').val();
		var machine=$('#machine').val();
		var bind=$('#bind').val();
		if(b_process!=null&&b_size!=null&&p_type!=null&&special!=null&&machine!=null){
		$.ajax({
 		 method: "POST",
  		 url: "includes/findrate.php",
  		 data: { 
  		 	bp_id: b_process,
  			bs_id: b_size,
  			ptype: p_type,
  			machine: machine,
  			so_id: special,
  			bind:bind }
		})
  		.done(function( msg ) {
  			if(msg!="null"){
  				msg=jQuery.parseJSON(msg);
  				$('#append').append('<input name="rate_id" type="hidden" value="'+msg.rate_id+'">');
  				$('#append').append('<input name="current_rate" type="hidden" id="current_rate" value="'+msg.rate+'">');
  				$('#rate').val(msg.rate);
  				}
  			else{
  			$('#append').append('<input name="current_rate" id="current_rate" type="hidden">');
  			} 
   		});
  		}
	}

	function getData(id){
		$.ajax({
 		 method: "POST",
  		url: "includes/bindingprocess.php",
  data: { bp_id: id }
})
  .done(function( msg ) {
  	$('#append').empty();
  	msg=jQuery.parseJSON(msg);
   $('#append').append('<div class="form-group"><select class="form-control" name="machine" id="machine" onchange="check()"><option value="" disabled selected>Machine</option></select><div>');
   $.each(msg.machine, function(i, machine){
   	$('#machine').append('<option value="'+machine.machine_id+'">'+machine.machine_name+'</option>');
   });
   $('#append').append('<div class="form-group"><select class="form-control" name="special" id="special" onchange="check()"><option value="" disabled selected>Special Options</option></select><div>');
   $.each(msg.special, function(i, special){
   	$('#special').append('<option value="'+special.so_id+'">'+special.so_name+'</option>');
   });
  });
	}
</script>
<?php
include_once('includes/foot.php'); 
?>