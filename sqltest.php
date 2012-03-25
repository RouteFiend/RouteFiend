<?php 

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

$query = "SELECT name FROM Intersections";				
$result = mysql_query($query);
$arr = array();
while ($row = mysql_fetch_assoc($result)) {
	    $arr[] = $row["name"];
	}

echo count($arr);

for ($i=0; $i < count($arr); $i++) {
	if ($i == (count($arr)-1)) { echo '"'.$arr[$i].'"'; }
	else { echo '"'.$arr[$i].'", ';} 


}

	
?>
  <div class="well">
  	<form  method="POST" action="sqltest2.php" autocomplete="off">
            <input name="in" type="text" class="span3" style="margin: 0 auto;" data-provide="typeahead" data-items="4" data-source='[<?php
            for ($i=0; $i < count($arr); $i++) {
	if ($i == (count($arr)-1)) { echo '"'.$arr[$i].'"'; }
	else { echo '"'.$arr[$i].'", ';} 


}
            ?>]'>
                 <button type="submit" class="btn btn-inverse" id="sign">Next <i class="icon-arrow-right"> </i></button>   

            </form>
          </div>