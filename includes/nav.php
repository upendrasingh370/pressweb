<div id="login_outer">
<div class="container">
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href=".">Post Press</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <?php
              $query="select fc_id,fc_name from func_category INNER join functions on func_category.fc_id=functions.func_category
                INNER join user_power on user_power.function_id=functions.function_id WHERE user_id=".$_COOKIE['user_id']." and show_in_menu=1 group by fc_id";
              $result=mysqli_query($db,$query);
              while($r=mysqli_fetch_array($result)){
                $query="select function_name,function_link from functions inner join user_power on functions.function_id=user_power.function_id where func_category=".$r['fc_id']." and user_id=".$_COOKIE['user_id']." and  show_in_menu=1 order by function_name";
                $result1=mysqli_query($db,$query);
              ?>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $r['fc_name'] ?><span class="caret"></span></a>
                <ul class="dropdown-menu">
                <?php
                while($r1=mysqli_fetch_array($result1)){ 
                ?>
                <li><a href="<?php echo $r1['function_link'] ?>"><?php echo $r1['function_name']?></a></li>
                <?php
                }
                ?>
                </ul>
              </li>
              <?php  
              } 
            ?>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $_COOKIE['fname'].' '.$_COOKIE['lname'] ?><span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="changepass.php">Change Pass</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="logout.php">Log Out</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>