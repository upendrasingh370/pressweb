<?php
$title="Add Voucher";
include_once('includes/head.php');
include_once('includes/power.php');
power($db);
include_once('includes/nav.php');
if(isset($_POST['submit'])){
    $vdate=date('Y-m-d', strtotime($_POST['vdate']));
    $final=$_POST['final_count'];
    $books=$_POST['reported'];
    $vtype=$_POST['voucher_type'];
    $ps_id=$_POST['ps_id'];
    $trader=$_POST['trader'];
    $rate=$_POST['rate'];
    $count=$books-$final;
    $query="insert into vouchers(vdate,ps_id,trader,processed_books,unreported_books,final,rate) values('$vdate',$ps_id,$trader,$final,$count, $vtype,$rate)";
    mysqli_query($db,$query) or die('error creating voucher');
    $query="select bproduction_id,book_processed,unprocessed_books,unreported_books from production_steps where ps_id=$ps_id";
    $result=mysqli_query($db,$query);
    $result=mysqli_fetch_assoc($result);
    $total=$final+$result['book_processed'];
    $x=$result['bproduction_id'];
    $query="update production_steps set book_processed=".($total).", unprocessed_books=".($result['unprocessed_books']-$books).", unreported_books=".($result['unreported_books']+$count)." where ps_id=$ps_id";
    mysqli_query($db,$query) or die('Error updateing production steps');
    $query="select * from production_steps where ps_id=$ps_id";
    $result=mysqli_query($db,$query);
    $result=mysqli_fetch_assoc($result);
    if($result['unprocessed_books']==0){
        $query="select * from vouchers where ps_id=$ps_id and final=0";
        $result=mysqli_query($db,$query);
        if(mysqli_num_rows($result)==0){
            $query="update production_steps set step_final=1 where ps_id=$ps_id";
            mysqli_query($db,$query);
        }
    }
    $query="select * from production_steps where step_final=0 and bproduction_id=$x";
    $result=mysqli_query($db,$query);
    $query="select * from production_steps where bproduction_id=$x";
    $result1=mysqli_query($db,$query);
    if((mysqli_num_rows($result)==0)&&(mysqli_num_rows($result1)>0)){
        $query="update book_production set production_status=1 where bp_id=$x";
        mysqli_query($db,$query);
    }
    if(isset($_POST['ps_id1'])){
    $query="select max_books,unprocessed_books from production_steps where ps_id=".$_POST['ps_id1']." order by ps_id desc limit 1";
    $result=mysqli_query($db,$query);
    $result=mysqli_fetch_assoc($result);
    $query="update production_steps set max_books=".($final+$result['max_books']).", unprocessed_books=".($final+$result['unprocessed_books'])." where ps_id=".$_POST['ps_id1'];
    mysqli_query($db,$query);
    $query="select * from production_steps where unprocessed_books>0 and bproduction_id=$x";
    $result=mysqli_query($db,$query);
    if(mysqli_num_rows($result)==0){
        $query="update book_production set production_status=1 where bp_id=$x";
        mysqli_query($db,$query);
    }
    $query="select voucher_id from vouchers where vdate='$vdate' and ps_id=$ps_id and trader=$trader and processed_books=$final and unreported_books=$count order by voucher_id desc limit 1";
    $result=mysqli_query($db,$query);
    $result=mysqli_fetch_assoc($result);
    $success="Voucher successfully created, voucher number is ".$result['voucher_id'];
    }
}
?>
<h1>Add Voucher</h1>
<hr>
Note: Finalised vouchers can't be edited
<?php if(isset($success)) echo '<div class="success">'.$success.'</div>'; ?>
<form method="post" onsubmit="return validate()">
    <div class="form-group">
        <input class="form-control" name="vdate" id="vdate" type="date" value="<?php echo date('Y-m-d'); ?>"></input>
    </div>
	<div class="form-group">
		<input class="form-control" name="book_code" id="book_code" type="number" onchange="getbook()" placeholder="Book Code" required>
	</div>
	<div id="append"></div>
    <div class="form-group">
        <select class="form-control" class="form-control" id="trader" name="trader">
        <option value="0" disabled selected>Trader</option> 
        <?php
        $query="select trader_id,name from trader";
        $result=mysqli_query($db,$query);
        while($row=mysqli_fetch_array($result)){ 
        ?>
        <option value="<?php echo $row['trader_id']; ?>"><?php echo $row['name'] ?></option>
        <?php 
        }
        ?>          
        </select>
    </div>
    <div id="append1"></div>
    <div id="append2"></div>
    <div id="append3"></div>
    <button type="submit" name="submit" id="submit" class="btn btn-primary">Add Voucher</button>
    </form>
<?php 
include_once('includes/script.php');
?>
<script type="text/javascript">
    function reporter(){
        $("#append3").empty();
        var copies=parseInt($('#reported').val());
        var max=$('#unpro').val();
        var type=parseInt($('#voucher_type').val());
        if(copies>max){
            alert("According to our database we do only have "+max+" books to be processed");
            $('#reported').val(max);
            $("#append3").empty();
            copies=max;
        }
        else if(copies==0){
             alert("No of copies should be more than 0");
            $('#reported').val(max);
            $("#append3").empty();
            copies=max;
        }
        var final=copies;
        var remain=0;
        if(type==0){
         final=Math.round(copies*0.9);
         remain=copies-final;
        }
        $('#append3').append('<div class="form-group"><label>No of copies billed:</label><input class="form-control" type="number" id="final_count" name="final_count" value="'+final+'"></div><input type="hidden" name="unreported" value="'+remain+'">');
    }

    function getbook(){
    	$('#append').empty();
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
                $('#append').empty();
                $('#book_code').val(null);
                return;
    		}
            else{
                $('#append').append('<div class="form-group"><label>Book Name : </label>'+msg.book_name+'</div>');
                if(msg.edition==null){
                    alert('No edition in production');
                    $('#book_code').val(null);
                    return;
                }
                else{
                    $('#append').append('<div class="form-group"><select name="edition" id="edition" onchange="getdata()" class="form-control"><option disabled selected>Book Edition</option></select></div>');
                    $.each(msg.edition,function(it,item){
                        if(item.copies_printed!=null)
                        $('#edition').append('<option value="'+item.bp_id+'">'+item.edition+'</option>');
                    });
                }
            }
    	});
    }

    function getdata(){
        $('#append1').empty();
        var bp_id=$('#edition').val();
        $.ajax({
            method:"post",
            url:"includes/fetchedition.php",
            data:{ bp_id: bp_id }
        }).done(function(msg){
            msg=$.parseJSON(msg);
            var count=0;
            if(msg!=null){
                $('#append1').append('<div class="form-group"><select name="bp" id="bp" onchange="getdata1()" class="form-control"><option disabled selected>Binding Process</option></select></div>');
                $.each(msg,function(it,item){
                    if(item.max_books>0&&item.unprocessed_books!=0){
                    $('#bp').append('<option value="'+item.bp_id+'">'+item.bp_name+'</option>');
                    count++;
                    }
                });
                if(count==0){
                    alert('No binding process with appropriate numbers found');
                    $('#edition').prop('selectedIndex',0);
                    $('#append1').empty();
                    return;
                }
            }
            else{

            }
        });
    }

    function getdata1(){
        $('append2').empty();
        var bp_id=$('#edition').val();
        var binding=$('#bp').val();
        $.ajax({
            method:"post",
            url:"includes/fetchedition.php",
            data:{ bp_id: bp_id }
        }).done(function(msg){
            msg=$.parseJSON(msg);
            if(msg!=null){
                var x=0;
                $.each(msg,function(it,item){
                    if(x!=0){
                        x=item.ps_id;
                         $('#append2').append('<input type="hidden" name="ps_id1" value="'+x+'">');
                        x=0;
                    }
                    if(item.bp_id==binding&&item.rate!=null){
                        x=item.bp_id;
                        alert("Max value for no of books is "+item.unprocessed_books);
                        // if(item.book_processed!=0){
                        // var percent=item.book_processed/(item.book_processed+item.unreported_books);
                        // alert("Success rate of this operation is "+(percent*100)+" currently");
                        // }
                        $('#append2').append('<div class="form-group"><label>Machine:</label>'+item.machine_name+'</div>');
                        $('#append2').append('<div class="form-group"><label>Special Options:</label>'+item.so_name+'</div>');
                        $('#append2').append('<div class="form-group"><label>Rate:</label>'+item.rate+'</div><input type="hidden" name="rate" value="'+item.rate+'"><input type="hidden" name="p_time" value="'+item.p_time+'"><input type="hidden" id="unpro" name="unpro" value="'+item.unprocessed_books+'"><input type="hidden" name="ps_id" value="'+item.ps_id+'">');
                        if(item.p_time=="intermediate"){
                            $('#append2').append('<div class="form-group"><label>Voucher Type:</label>Temporary</div><input type="hidden" name="voucher_type" id="voucher_type" value="0">');
                        }
                        else{
                             $('#append2').append('<div class="form-group"><label>Voucher Type:</label>Final</div><input type="hidden" name="voucher_type" id="voucher_type" value="1">');
                        }
                        $('#append2').append('<div class="form-group"><input class="form-control" name="reported" id="reported" onchange="reporter()" placeholder="No of copies reported" type="number" required></div>');
                    }
                    else if(item.bp_id==binding&& item.rate==null){
                        alert('Rate is not defined, ask appropriate authorities');
                        $('#bp').prop('selectedIndex',0);
                        $('#append2').empty();
                        return;
                    }
                })
            }
        });
    }

	function validate(){
        var reported=$('#reported').val();
        var final=$('#final_count').val();
        var trader=$('#trader').val();
        var edition=$('#edition').val();
        var bp=$('#bp').val();
        var code=$('#book_code').val();
        if(code==null){
            alert('Book Code cannot be empty');
            return false;
        }
        if(trader==null){
            alert("Trader cannot be empty");
            return false;
        }
        if(edition==null){
            alert('Edition should not be empty');
            return false;
        }
        if(bp==null){
            alert('Binding Process should not be empty');
            return false;
        }
        if(count>reported){
            alert("Final count of books cannot be greater than reported");
        }
	}
</script>
<?php
include_once('includes/foot.php'); 
?>