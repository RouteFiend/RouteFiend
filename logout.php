<?php 
session_start();
$_SESSION = array();
session_destroy();
setcookie('PHPSESSID','',time()-300,'/','',0);
    		$url = "index.php";
			header("location: $url");
			exit();

 ?>