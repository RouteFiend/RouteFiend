<?php 
 	ini_set('display_errors', 1);
    error_reporting(E_ALL | E_STRICT);

    session_start();
    echo $_GET['login_err'];
    if (isset($_SESSION['user_id'])) {
    		$url = "in.php";
			header("location: $url");
			exit();
    }
	if (isset($_POST['sub_login'])) {
		require_once('dbc.php');

		$valid = true;
		if (!(empty($_POST['email']))) {
			$e = mysql_real_escape_string(trim(strip_tags($_POST['email'])), $dbc);
			echo $e;
		}
		else {
			$valid = false;
		}
		if (!(empty($_POST['password']))) {
			$p = mysql_real_escape_string(trim(strip_tags($_POST['password'])), $dbc);
			echo $p;
		}
		else {
			$valid = false;
		}

		if($valid) {
			$query = "SELECT user_id, first_name FROM users WHERE email='$e' AND password=SHA('$p')";
			$result = mysql_query($query);
			$row = mysql_fetch_array($result, MYSQL_NUM);
		}
		if ($row) {
			//session_start();
			$_SESSION['user_id'] = $row[0];
			$_SESSION['name'] = $row[1];
			$url = "in.php";
			header("location: $url");
			exit();
			}
		else {
			$login_err = true;
			$url = "index.php?login_err=$login_err";
			header("location: $url");
			exit();
			echo "nah";
		}
	}
?>
<html>
<head>
	<title>routefiend</title>
	<link rel="shortcut icon" href="img/rf.ico">
	<style type="text/css">
	#container{
  width:270px;
}
.fix {
	margin-bottom:10px;
  width:100%;
}
	</style>
</head>
<body>
<div id="container"> 
		<h1>routefiend</h1>
		<form method="POST" action="index.php">
		<div class="fix"> <input name="email" class="input" type="text" placeholder="user" /> </div>
		<div class="fix"> <input name="password" class="input" type="text" placeholder="password" /> </div>
		<div class="fix">
			<a href="#" class="btn" id="sign">Sign Up for RouteFiend</a>   
			<input type="submit">        
			<!-- <a href="in.php" class="btn" id="log">Login</a> -->
		</div>
		<input type="hidden" name="sub_login" value="TRUE" />
		</form>
	</div>
</body>
</html>