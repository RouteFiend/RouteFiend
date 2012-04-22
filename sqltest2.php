<?php 

echo $_POST['in'];

ini_set('display_errors', 1);
    error_reporting(E_ALL | E_STRICT);
define('DB_USER', 'miles');
define('DB_PASSWORD', 'test');
define('DB_HOST', 'localhost');
define('DB_NAME', 'miles');

include 'header.php';

$dbc = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) OR die('phlur'.mysql_error());

mysql_select_db(DB_NAME) OR die('phlur x2'.mysql_error());

echo "success!!";
$in = $_POST['in'];
$query = "SELECT id FROM Intersections WHERE name='$in'";				
$result = mysql_query($query);
				$result = mysql_query($query);
				$row = mysql_fetch_array($result, MYSQL_NUM);
echo $row[0];

 ?>