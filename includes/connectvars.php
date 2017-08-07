<?php
//Contains database details
define('DBHOST','localhost');
define('DBUSER','root');
define('DBPASS','root');
define('DBNAME','post_press');
$db=mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME) or die('error connecting database');
?>