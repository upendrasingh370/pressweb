<?php
$title="Edit Voucher";
include_once('includes/head.php');
include_once('includes/power.php');
power($db);
include_once('includes/nav.php');
if(isset($_POST['submit'])){
    $voucher_id=$_POST['voucher'];
    $bp_id=$_POST['edition'];
    $books=$_POST['new_report'];
    $old_books=$_POST['reported']+$books;
    $unreported=$_POST['unreported']-$books;
    $ps_id=$_POST['ps_id'];
    $query="update vouchers set processed_books=$old_books, unreported_books=$unreported,final=1 where voucher_id=$voucher_id";
    mysqli_query($db,$query);
    $query="select * from production_steps where bproduction_id=$bp_id";
    $x=0;
    $result=mysqli_query($db,$query) or die('Error fetching');
    while($row=mysqli_fetch_assoc($result)){
        if($x==1){
            $x=0;
            $query="update production_steps set max_books=".($row['max_books']+$books).",unprocessed_books=".($row['unprocessed_books']+$books).", step_final=0 where ps_id=".$row['ps_id'];
            mysqli_query($db,$query);
        }
        if($row['ps_id']==$ps_id){
            $query="update production_steps set book_processed=".($row['book_processed']+$books).',unreported_books='.($row['unreported_books']-$books)." where ps_id=$ps_id";
            mysqli_query($db,$query);
            $x=1;
        }
    }
    $query="select * from vouchers where final=0 and ps_id=$ps_id";
    $result=mysqli_query($db,$query);
    $query="select * from vouchers where ps_id=$ps_id";
    $result1=mysqli_query($db,$query);
    if(mysqli_num_rows($result)==0&&mysqli_num_rows($result1)>0){
        $query="select * from production_steps where bproduction_id=$bp_id";
        $result=mysqli_query($db,$query);
        while($row=mysqli_fetch_assoc($result)){
        if($row['unprocessed_books']==0){
            $query="update production_steps set step_final=1 where ps_id=".$row['ps_id'];
            mysqli_query($db,$query);
            }
        }
    }
    $query="select * from production_steps where step_final=0 and bproduction_id=$bp_id";
    $result=mysqli_query($db,$query);
    $query="select * from production_steps where bproduction_id=$bp_id";
    $result1=mysqli_query($db,$query);
    if((mysqli_num_rows($result)==0)&&(mysqli_num_rows($result1)>0)){
        $query="update book_production set production_status=1 where bp_id=$bp_id";
        mysqli_query($db,$query);
    }
}
?>
<h1>Edit Voucher</h1>
<hr>
<form method="post" onsubmit="return validate()">
	<div class="form-group">
		<input class="form-control" onchange="getbook()" name="book_code" id="book_code" type="number" placeholder="Book Code"></input>
	</div>
    <div id="append3"></div>
	<div class="form-group">
		<select class="form-control" name="edition" id="edition" onchange="getvoucher()">
			<option disabled selected>Book Edition</option> 
		</select>
	</div>
    <div id="append"></div>
    <div id="append2"></div>
</form>
<?php
include_once('includes/script.php');
?>
<script type="text/javascript">
	function validate(){
		var code=$('#book_code').val();
		var edition=$('#edition').val();
		if(code==null){
			alert('Book code cannot be empty');
			return false;
		}
		if(edition==null){
			alert('Edition cannot be empty');
			return false;
		}
        var newr=parseInt($('#new_report').val());
        var unrepor=parseInt($('#unreported').val());
        if(newr==null){
            alert("No of books cant be empty");
            return false;
        }
        if(newr>unrepor){
            alert("Value exceeded the limit");
            $('#new_report').val(unrepor);
            return false;
        }
	}

    function getvoucher(){
        $('#append').empty();
        $('#append2').empty();
        var bp_id=$('#edition').val();
        $.ajax({
            method:"post",
            url:"includes/getvoucher.php",
            data:{
                bp_id: bp_id
            }
        }).done(function(msg){
            msg=$.parseJSON(msg);
            if(msg!=null){
                $('#append').append('<div class="form-group"><select name="voucher" onchange="getdata()" id="voucher" class="form-control"><option disabled selected>Voucher</option></select></div');
                $.each(msg,function(it,item){
                    $('#voucher').append('<option value="'+item.voucher_id+'">'+item.vdate+'  Processed:'+item.processed_books+'  Unreported:'+item.unreported_books+'</option>')
                })
            }
            else{
                $('#append').append('<p>No vouchers found</p>');
                $('#edition').prop('selectedIndex',0);
                return;
            }
        });
    }
    function getdata(){
        $('#append2').empty();
        var voucher_id=$('#voucher').val();
        $.ajax({
            method:"post",
            url:"includes/getvoucher.php",
            data:{
                voucher: voucher_id
            }
        }).done(function(msg){
            msg=$.parseJSON(msg);
            if(msg!=null){
                msg=msg[0];
            $('#append2').append('<div class="form-group"><input type="number" class="form-control" id="new_report" placeholder="Number of Books" name="new_report"></div>');
            $('#append2').append('<div class="form-group"><label>No of books billed:</label>'+msg.processed_books+'</div><input type="hidden" name="reported" value="'+msg.processed_books+'">');
            $('#append2').append('<div class="form-group"><label>No of books unreported:</label>'+msg.unreported_books+'</div><input type="hidden" name="unreported" id="unreported" value="'+msg.unreported_books+'"><input type="hidden" name="ps_id" id="ps_id" value="'+msg.ps_id+'">' );
            $('#append2').append('<button class="btn btn-primary" name="submit" type="submit">Finalize Voucher</button>');
            alert('Max value can be max '+msg.unreported_books);
            }
        });

    }

	function getbook(){
		var code=$('#book_code').val();
    	$.ajax({
    		method:"post",
    		url:'includes/findbook1.php',
    		data : {
    			book_code : code
    		}
    	}).done(function(msg){
    		msg=$.parseJSON(msg);
    		if(msg==null){
                alert('Book does not exists');
                $('#edition').empty();
                $('#book_code').val(null);
                $('#edition').append('<option disabled selected>Book Edition</option>');
                return;
    		}
            else{
                if(msg.edition==null){
                    alert('No edition in production');
                    $('#book_code').val(null);
                    return;
                }
                else{
                    $('#append3').append('<div class="form-group"><label>Books Name:</label>'+msg.book_name+'</div><div class="form-group capital"><label>Book Language:</label>'+msg.book_lang+'</div>');
                    $.each(msg.edition,function(it,item){
                        if(item.copies_printed!=null)
                        $('#edition').append('<option value="'+item.bp_id+'">'+item.edition+'</option>');
                    });
                }
            }
    	});
	}
</script>
<?php
include_once('includes/foot.php'); 
?>