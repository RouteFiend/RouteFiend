<?php 
 	//ini_set('display_errors', 1);
    //error_reporting(E_ALL | E_STRICT);

    session_start();
   //echo $_GET['login_err'];
    //echo $_GET['pa'];
    if (($_GET['pa'] == 2) && (isset($_SESSION['user_id'])) ) {
    	include 'get.php';
    }
    else {
    	include 'login.php';
    	if (isset($_SESSION['user_id'])) {
    		$pa = 2;
    				$url = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);
				if ((substr($url, -1) == '/r') OR (substr($url, -1)) == '\\') {
					$url = substr($url, 0,-1); //chop slash
				}

    		$url .= "/index.php?pa=$pa";
			header("location: $url");
			exit();
    }
   		else {
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
				$query = "SELECT user_id, first_name, email FROM users WHERE email='$e' AND password=SHA('$p')";
				$result = mysql_query($query);
				$row = mysql_fetch_array($result, MYSQL_NUM);
			}
			if ($row) {
				//session_start();
				$_SESSION['user_id'] = $row[0];
				$_SESSION['name'] = $row[1];
				$_SESSION['email'] = $row[2];
				$url = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);
				if ((substr($url, -1) == '/') OR (substr($url, -1)) == '\\') {
					$url = substr($url, 0,-1); //chop slash
				}
								    		$pa = 2;

					$url .= '/index.php?ph=$pa';


			header("location: $url");
			exit();
				exit();
				}
			else {
				$login_err = true;
						$url = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);
				if ((substr($url, -1) == '/') OR (substr($url, -1)) == '\\') {
					$url = substr($url, 0,-1); //chop slash
				}
				$url .= "/index.php?login_err=$login_err";
				header("location: $url");
				exit();
				echo "nah";
			}
		}
	}
    }
    
?>
