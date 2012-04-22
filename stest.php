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
 function finGenTime() {
	    $output = "<select style='width:70px;'class='input-small' name='ts' id='ts'>"."\n";
		for ($i=0; $i < 24; $i++) {
			for ($j=0; $j < 60; $j = $j + 15) { 
				if($j == 0 && $i < 10) {
					$output .= "<option value='0$i:00'>0$i:00</option>";
				}
				else if($j == 0) {
					$output .= "<option value='$i:00'>$i:00</option>";
				}
				else if($i < 10) {
					$output .= "<option value='0$i:$j'>0$i:$j</option>";
				}
				else {
					$output .=  "<option value='$i:$j'>$i:$j</option>";
				}
				$output .= "\n";
			}
		}
		$output .= "</select>";
			return $output;
    }

     function FinGenSelTime($selected) {
	    $output = "<select class='input-small' name='ts' id='ts'>"."\n";
		for ($i=0; $i < 24; $i++) {
			for ($j=0; $j < 60; $j = $j + 15) { 
				if($j == 0 && $i < 10) {
					$vals = "0$i:00";
				}
				else if($j == 0) {
					$vals = "$i:00";
				}
				else if($i < 10) {
					$vals = "0$i:$j";
				}
				else {
					$vals ="$i:$j";
				}
				if ($vals == $selected)	{
					$output .=  "<option selected='selected' value='$vals'>$vals</option>";
				}
				else {
					$output .=  "<option value='$vals'>$vals</option>";
				}
				$output .= "\n";
			}
		}
		$output .= "</select>";
			return $output;
    }
    $d = genTime();
    $e = genSelTime("01:00");
include 'header.php';


?>
<style type="text/css">
body{padding:50px;}
.input-prepend{font-size:16px;}

</style>

<div class = "well form-inline">
     	<div class="control-group">
            <div class="controls">
              <div class="input-prepend">
              	                <span class="add-on"><i class="icon-map-marker"></i></span><input name="in" placeholder="where" type="text" class="input-mini" style="margin: 0 auto;" data-provide="typeahead" data-items="4" data-source='[<?php
            for ($i=0; $i < count($arr); $i++) {
	if ($i == (count($arr)-1)) { echo '"'.$arr[$i].'"'; }
	else { echo '"'.$arr[$i].'", ';} 


}
            ?>]'>

                <span class="add-on"><i class="icon-time"></i></span><?php echo $d;?>
              </div>
            </div>
        </div>


</html>