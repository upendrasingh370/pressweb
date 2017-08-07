<?php
$title="Add Book";
include_once('includes/head.php');
include_once('includes/power.php');
power($db);
include_once('includes/nav.php');
?>
<h1>Add Book</h1>
<hr>
<?php
if(isset($_POST['submit'])){
	$code=$_POST['code'];
	$name=$_POST['name'];
	$language=$_POST['language'];
	$size=$_POST['size'];
	$binding=$_POST['binding'];
	$paper=$_POST['paper-type'];
	$isbn=$_POST['isbn'];
	$query="select * from books where book_code=$code or isbn=$isbn";
	$result=mysqli_query($db,$query);
	if(mysqli_num_rows($result)==0){
		$query="insert into books(book_code,book_name,book_lang,book_size,book_bind,paper_used,isbn) values($code,'$name','$language',$size,'$binding','$paper',$isbn)";
		mysqli_query($db,$query);
		$success="Book added successfully";
	}
	else
		$error="Book Code/ISBN already exists";
}
?>
<?php if(isset($error)) echo '<div class="error">'.$error.'</div>'; ?>
		<?php if(isset($success)) echo '<div class="success">'.$success.'</div>'; ?>
<form method="post" onsubmit="return validate()">
	<div class="form-group">
		<input type="number" name="code" placeholder="Book Code" required class="form-control">
	</div>
	<div class="form-group">
		<input type="text" name="name" class="form-control" placeholder="Book Name" required>
	</div>
	<div class="form-group">
		<select class="form-control" name="language" required id="lang">
			<option value="0" disabled selected>Book Language</option>
			<option value="asamiya">Asamiya</option>
			<option value="bangla">Bangla</option>
			<option value="english">English</option>
			<option value="gujarati">Gujarati</option>
			<option value="hindi">Hindi</option>
			<option value="kannada">Kannada</option>
			<option value="malyalam">Malyalam</option>
			<option value="marathi">Marathi</option>
			<option value="nepali">Nepali</option>
			<option value="oriya">Oriya</option>
			<option value="punjabi">Punjabi</option>
			<option value="sanskrit">Sanskrit</option>
			<option value="tamil">Tamil</option>
			<option value="telugu">Telugu</option>
			<option value="urdu">Urdu</option>
		</select>
	</div>
	<div class="form-group">
		<select class="form-control" name="binding" id="bind">
			<option value="0" disabled selected>Bind Type</option>
			<option value="soft">Soft Bound</option>
			<option value="hard">Hard Bound</option>
		</select>
	</div>
	<div class="form-group">
	<select class="form-control" name="size" id="size">
	<option value="0" disabled selected>Book Size</option>
	<?php
	$query="select * from book_size";	
	$result=mysqli_query($db,$query); 
	while($r=mysqli_fetch_array($result)){
	?>
	<option value="<?php echo $r['bs_id']?>"><?php echo utf8_decode($r['bs_name']) ?></option>
	<?php
	} 
	?>
	</select>
	</div>
	<div class="form-group">
		<select class="form-control" name="paper-type" id="paper">
			<option value="0" disabled selected>Paper Type</option>
			<option value="standard">Standard Paper</option>
			<option value="deluxe">Deluxe Paper</option>
			<option value="art">Art Paper</option>
		</select>
	</div>
	<div class="form-group">
		<input class="form-control" type="number" name="isbn" placeholder="ISBN" id="isbn" required>
	</div>
	<div class="nomargin col-md-4">
		<button type="submit" name="submit" class="btn btn-primary">Add</button>
	</div>
</form>
<?php 
include_once('includes/script.php');
?>
<script type="text/javascript">
	function validate(){
		var lang=$('#lang').val();
		if(lang==null){
			alert('Select a value for language of the book');
			return false;
		}
		var bind=$('#bind').val();
		if(bind==null){
			alert('Select a value for Binding');
			return false;
		}
		var size=$('#size').val();
		if(size==null){
			alert('Select a size for the book');
			return false;
		}
		var paper=$('#paper').val();
		if(paper==null){
			alert('Select a value for paper type');
			return false;
		}
		var isbn=$('#isbn').val();
		if(isbn.length!=10){
			alert("ISBN must be 10 digit long");
			return false;
		}
	}
</script>
<?php
include_once('includes/foot.php'); 
?>