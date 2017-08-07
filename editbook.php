<?php
$title="Edit Book";
include_once('includes/head.php');
include_once('includes/power.php');
power($db);
include_once('includes/nav.php');
?>
<h1>Edit Book</h1>
<hr>
<?php
if(isset($_POST['submit2'])){
	$code=$_POST['book_code'];
	$name=$_POST['book_name'];
	$lang=$_POST['language'];
	$bind=$_POST['binding'];
	$size=$_POST['size'];
	$paper=$_POST['paper-type'];
	$isbn=$_POST['isbn'];
	$query="select * from books where isbn=$isbn";
	$ret=mysqli_query($db,$query);
	if(mysqli_num_rows($ret)==0){
		$query="update books set book_name='$name',book_lang='$lang',book_size=$size,book_bind='$bind',paper_used='$paper',isbn=$isbn where book_code=$code and book_id=".$_POST['book_id'];
		mysqli_query($db,$query) or die('You are tempering with somthing!!');
		$success="Book Updated";
	}
	else{
		$error="Update failed, isbn allotted for other book";
	}
}
if(isset($_POST['submit'])){
	$code=$_POST['book-code'];
	$query="select * from books where book_code=$code";
	$result=mysqli_query($db,$query);
	if(mysqli_num_rows($result)>0){
		$result=mysqli_fetch_assoc($result);
		?>
		<form method="post" onsubmit="return validate()">
			<div class="form-group">
				<label>Book Code :</label><?php echo $result['book_code'] ?>
				<input type="hidden" name="book_code" value="<?php echo $result['book_code']?>">
				<input type="hidden" name="book_id" value="<?php echo $result['book_id']?>">
			</div>
			<div class="form-group">
				<input type="text" name="book_name" class="form-control" value="<?php echo $result['book_name'] ?>">
			</div>
			<div class="form-group">
				<select class="form-control" name="language" required id="lang">
				<option value="0" disabled>Book Language</option>
				<option value="asamiya" <?php if($result['book_lang']=="asamiya") echo "selected";?>>Asamiya</option>
				<option value="bangla" <?php if($result['book_lang']=="bangla") echo "selected";?>>Bangla</option>
				<option value="english" <?php if($result['book_lang']=="english") echo "selected";?>>English</option>
				<option value="gujarati" <?php if($result['book_lang']=="gujarati") echo "selected";?>>Gujarati</option>
				<option value="hindi" <?php if($result['book_lang']=="hindi") echo "selected";?>>Hindi</option>
				<option value="kannada" <?php if($result['book_lang']=="kannada") echo "selected";?>>Kannada</option>
				<option value="malyalam" <?php if($result['book_lang']=="malyalam") echo "selected";?>>Malyalam</option>
				<option value="marathi" <?php if($result['book_lang']=="marathi") echo "selected";?>>Marathi</option>
				<option value="nepali" <?php if($result['book_lang']=="nepali") echo "selected";?>>Nepali</option>
				<option value="oriya" <?php if($result['book_lang']=="oriya") echo "selected";?>>Oriya</option>
				<option value="punjabi" <?php if($result['book_lang']=="punjabi") echo "selected";?>>Punjabi</option>
				<option value="sanskrit" <?php if($result['book_lang']=="sanskrit") echo "selected";?>>Sanskrit</option>
				<option value="tamil" <?php if($result['book_lang']=="tamil") echo "selected";?>>Tamil</option>
				<option value="telugu" <?php if($result['book_lang']=="telugu") echo "selected";?>>Telugu</option>
				<option value="urdu" <?php if($result['book_lang']=="urdu") echo "selected";?>>Urdu</option>
		</select>
		</div>
		<div class="form-group">
		<select class="form-control" name="binding" id="bind">
			<option value="0" disabled>Bind Type</option>
			<option value="soft" <?php if($result['book_bind']=="soft") echo "selected" ?>>Soft Bound</option>
			<option value="hard" <?php if($result['book_bind']=="hard") echo "selected" ?>>Hard Bound</option>
		</select>
		</div>
		<div class="form-group">
	<select class="form-control" name="size" id="size">
	<option value="0" disabled>Book Size</option>
	<?php
	$query="select * from book_size";	
	$result1=mysqli_query($db,$query); 
	while($r=mysqli_fetch_array($result1)){
	?>
	<option value="<?php echo $r['bs_id'] ?>" <?php if($result['book_size']==$r['bs_id']) echo "selected"; ?>><?php echo utf8_decode($r['bs_name']) ?></option>
	<?php
	} 
	?>
	</select>
	</div>
	<div class="form-group">
		<select class="form-control" name="paper-type" id="paper">
			<option value="0" disabled>Paper Type</option>
			<option value="standard" <?php if($result['paper_used']=="standard") echo "selected";?>>Standard Paper</option>
			<option value="deluxe" <?php if($result['paper_used']=="deluxe") echo "selected";?>>Deluxe Paper</option>
			<option value="art" <?php if($result['paper_used']=="art") echo "selected";?>>Art Paper</option>
		</select>
	</div>
	<div class="form-group">
		<input class="form-control" type="number" name="isbn" placeholder="ISBN" id="isbn" value="<?php echo $result['isbn'] ?>" required>
	</div>
	<div class="nomargin col-md-4">
		<button type="submit" name="submit2" class="btn btn-primary">Update</button>
	</div>
	<div class="col-md-4">
		<button type="submit" name="submit3" class="btn btn-primary">Cancel</button>
	</div>
		</form>
		<?php
	}
	else
		$error="No Book with given code found";
}
?>
<?php if(!isset($_POST['submit'])||isset($error)||isset($success)){ ?>
<?php if(isset($error)) echo '<div class="error">'.$error.'</div>'; ?>
<?php if(isset($success)) echo '<div class="success">'.$success.'</div>'; ?>
<form method="post">
	<div class="form-group">
		<input class="form-control" name="book-code" placeholder="Book Code">
		</input>
	</div>
	<button class="btn btn-primary" name="submit" type="submit">Edit Book</button>
</form>
<?php 
}
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