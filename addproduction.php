<?php
$title="Add Production Details";
include_once('includes/head.php');
include_once('includes/power.php');
power($db);
include_once('includes/nav.php');
if(isset($_POST['submit'])){
	$code=$_POST['book-code'];
	$sections=$_POST['sections'];
	$firmas=$_POST['firmas'];
	$csections=$_POST['csections'];
	$edition=$_POST['edition'];
	$curr_edition=$_POST['curr_edition'];
	$processes=$_POST['processes'];
	$query="select * from book_production where book_code=$code and edition=$edition";
	$result=mysqli_query($db,$query);
	if(mysqli_num_rows($result)==0){
		$query="insert into book_production(book_code,edition,section, firma,csection,processes) values($code,$edition,$sections,$firmas,$csections,$processes)";
		mysqli_query($db,$query) or die("error inserting");
		$query="select bp_id from book_production where book_code=$code and edition=$edition order by bp_id desc limit 1";
		$x=mysqli_query($db,$query);
		$x=mysqli_fetch_assoc($x);
		$x=$x['bp_id'];
		if($edition>$curr_edition){
			$query="update books set latest_edition=".$edition." where book_code=$code";
			mysqli_query($db,$query) or die("error updating user");
		}
		for($i=1;$i<=$_POST['processes'];$i++){
			$process=$_POST['process-'.$i];
			$machine=$_POST['machine-'.$i];
			$special=$_POST['special-'.$i];
			$query="insert into production_steps(bproduction_id,machine_id,bp_id,so_id) values($x,$machine,$process,$special)";
			mysqli_query($db,$query);
		}
		$success="Added the book production details";
	}
	else{
		$result=mysqli_fetch_assoc($result);
		$query="update book_production set section=$sections, firma=$firmas, csection=$csections where bp_id=".$result['bp_id'];
		mysqli_query($db,$query);
		$success="Updated the book production details";
	}
}
?>
<h1>Add/Edit Production Details</h1>
<hr>
<?php if(isset($success)) echo '<div class="success">'.$success.'</div>'; ?>
<form method="post" onsubmit="return validate()">
	<div class="form-group">
		<input class="form-control" name="book-code" placeholder="Book Code" required type="number" id="book-code" onchange="check()"></input>
	</div>
	<div id="append"></div>
	<div class="form-group">
		<input class="form-control" name="sections" placeholder="Number of sections" required type="number" step="0.25" id="sections"></input>
	</div>
	<div class="form-group">
		<input class="form-control" name="firmas" placeholder="Number of firmas" required type="number" step="0.25" id="firmas"></input>
	</div>
	<div class="form-group">
		<input class="form-control" name="csections" placeholder="Number of colored sections" required type="number" step="0.25" id="csections"></input>
	</div>
	<div class="form-group" id="x">
		<input type="text" class="form-control" onchange="process()" name="processes" placeholder="No of processes" required type="number" min="1" max="15" id="processes">
	</div>
	<div id="append1"></div>
	<button class="btn btn-primary" name="submit" type="submit" disabled id="submit">Add Production Detail</button>
</form>
<?php 
include_once('includes/script.php');
?>
<script type="text/javascript">


function process(){
	$('#append1').empty();
	var x=$('#processes').val();
	if(x>15){
		alert("No of process cant exceed 15");
		$('#append1').empty();
		$('#processes').val(null);
		return;
	}
	else if(x<1){
		alert("No of process cant be less than 1");
		$('#append1').empty();
		$('#processes').val(null);
		return;
	}
	var i=0;
	$.ajax({
	  method: "POST",
	  url: "includes/getprocess.php"
	})
	  .done(function( msg ) { 
		if(msg!="null")	{
			msg=jQuery.parseJSON(msg);
			for(i=1;i<=x;i++){
				$('#append1').append('<div class="form-group nomargin col-md-4"><select class="form-control" onchange="process1('+i+','+x+')" id="process-'+i+'" name="process-'+i+'"><option disabled selected>Process '+i+'</option></select></div><div class="col-md-4 form-group"><select class="form-control" id="machine-'+i+'" name="machine-'+i+'"><option disabled selected>Machine '+i+'</option></select></div><div class="form-group nomargin col-md-4"><select class="form-control" id="special-'+i+'" name="special-'+i+'"><option disabled selected>Special Options '+i+'</option></select></div>');
				$.each(msg,function(it,item){
					$('#process-'+i).append('<option value="'+item.bp_id+'">'+item.bp_name+'</option>');
				return;
				});
			}
		}    
	  });
}

function process1(item){
	$('#append3-'+item).empty();
	$("#special-"+item).empty();
	$("#machine-"+item).empty();
	$("#special-"+item).append('<option disabled selected>Special Options '+item+'</option>');
	$("#machine-"+item).append('<option disabled selected>Machine '+item+'</option>');
	var bp=$('#process-'+item).val();
	for(var i=1;i<item;i++){
		var val=$('#process-'+i).val();
		if(val==bp){
			$('#process-'+item).prop('selectedIndex',0);
			return;
		}
	}
	$.ajax({
		method: "POST",
		url: "includes/bindingprocess.php",
		data: { bp_id: bp }
	})
	.done(function(msg) {
		if(msg!="null"){
			msg=jQuery.parseJSON(msg);
			$.each(msg.machine,function(it,iteme){
				$("#machine-"+item).append('<option value="'+iteme.machine_id+'">'+iteme.machine_name+'</option>');
			});
			$.each(msg.special, function(it,iteme){
				$("#special-"+item).append('<option value="'+iteme.so_id+'">'+iteme.so_name+'</option>');
			});
			if(msg.special==null){
				alert("We do not have special option for the selected binding process, please select other or contact admin");
				$('#process-'+item).prop('selectedIndex',0);
				return;
			}
		}
	});
}


function validate(){
	var code=$('#book-code').val();
	var edition=$('#edition').val();
	var section=$('#sections').val();
	var firma=$('#firmas').val();
	var csection=$('#csections').val();
	var processes=$('#processes').val();
	if(code==null){
		alert('Book code can\'t be null');
		return false;
	}
	if(code==null){
		alert('Book code can\'t be null');
		return false;
	}
	if(section==null){
		alert('Number of sections can\'t be null, enter 0 or greater value');
		return false;
	}
	if(firma==null&&firma>0){
		alert('Number of firmas can\'t be null, enter 1 or greater value');
		return false;
	}
	if(csection==null){
		alert('Number of colored sections can\'t be null, enter 0 or greater value');
		return false;
	}
	for(var i=1;i<=processes;i++){
		var processx=$('#process-'+i).val();
		var machine=$('#machine-'+i).val();
		var special=$('#special-'+i).val();
		if(processx==null){
			alert('Binding Process is empty');
			return false;
		}
		if(machine==null){
			alert('Machine is empty');
			return false;
		}
		if(special==null){
			alert('Special Option should not be empty');
			return false;
		}
	}
}

function check(){
	$('#append').empty();
	$('#submit').attr("disabled","disabled");
	var code=$('#book-code').val();
	$.ajax({
	  method: "POST",
	  url: "includes/findbook.php",
	  data: { book_code: code }
	})
	  .done(function( msg ) {
	    if(msg!="null"){
	    	msg=jQuery.parseJSON(msg);
	    	$('#submit').removeAttr("disabled");
	    	$('#append').append('<div class="form-group"><label>Book Name:</label>  '+msg.book_name+'</div>');
	    	$('#append').append('<div class="form-group capital"><label>Book Binding:</label>  '+msg.book_bind+' Bound</div>');
	    	$('#append').append('<div class="form-group capital"><label>Book Language:</label>  '+msg.book_lang+'</div>');
	    	$('#append').append('<div class="form-group"><label>Book Size:</label>  '+msg.bs_name+'</div>');
	    	$('#append').append('<div class="form-group"><label>Edition</label><input class="form-control" name="edition" id="edition" onchange="checkprevedition()" type="number" value="'+(msg.latest_edition+1)+'"><input type="hidden" id="curr_edition" name="curr_edition" value="'+msg.latest_edition+'"></div>');

	    }
	    else{
	    	alert("Book Code not found");
	    }
	  });
}

function checkprevedition(){
	$('#sections').val(null);
	$('#firmas').val(null);
	$('#csections').val(null);
	$('#x').show();
	$('#submit').text("Add Production detail");
	var edition=$('#edition').val();
	var curr_edition=$('#curr_edition').val();
	var code=$('#book-code').val();
	if(edition<=curr_edition){
	$.ajax({
	  method: "POST",
	  url: "includes/findedition.php",
	  data: { book_code: code, edition: edition }
	})
	  .done(function( msg ) {
	    if(msg!="null"){
	    	$('#x').hide();
	    	msg=jQuery.parseJSON(msg);
	    	$('#sections').val(msg.section);
	    	$('#firmas').val(msg.firma);
	    	$('#csections').val(msg.csection);
	    	$('#processes').val(msg.processes);
	    	$('#submit').text("Update Production detail");
	    }
	    else{
	    	$('#sections').val(null);
			$('#firmas').val(null);
			$('#csections').val(null);
	
	    }
	  });
	}
}
</script>
<?php
include_once('includes/foot.php'); 
?>