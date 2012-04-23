<?php 
define("JAVA_HOSTS", "127.0.0.1:8095");
define("JAVA_SERVLET", "/JavaBridge/servlet.phpjavabridge");
require_once ("java/Java.inc");
require_once('dbc.php');
include "header.php";
include "nav.php";
session_start();
?>
<script type='text/javascript'>
$(document).ready(function() {
	$('.chance').tooltip({
		placement: "right",
		selector: "a[rel=tooltip]"
	})

	$('.chance').tooltip();
	$('.popover-test').popover()

    // popover demo
    $("a[rel=popover]")
    .popover()
    .click(function(e) {
    	e.preventDefault()
    })
})
</script>
<?php
echo $navBar;
echo '	<div class="container" id="get_cont" style="width:600px;">';
echo '				<legend><h2 id="tadd">Directions</h2></legend>';
$intersections = $_SESSION['des'];
$times = $_SESSION['times'];
//print_r($intersections);

$arr = array();
for ($i=0;$i < count($intersections);$i++){
$query = "SELECT id FROM Intersections WHERE Name='$intersections[$i]'";				
$result = mysql_query($query);

	while ($row = mysql_fetch_assoc($result)) {
		$arr[] = $row["id"];
	}
}
//print_r($arr);
// add 00 to the end of times (for java sake)
$newTimes = array();
foreach($times as $time) {
$newTimes[] = $time.":00";
}
//echo "<br>";
//print_r($newTimes);

$world = new java("routefiend.RoutingTest");
$world->init();
$dump = java_values($world->solveForDestinationsAndTimes($arr,$newTimes));

$des = $arr;
if (in_array(-1, $dump))
{
	echo "NOT POSSIBLE!";
}
else {
	//echo "# Destinations <br>";
	//print_r($intersections);
	//echo "# The route the java gives back <br>";
	//print_r($dump);	
	//echo "<br>";
	//print_r(java_values($dump));
	$routeNum = 0;
	$desGone = array();
	for($i = 0; $i <count($des); $i++){
		$desGone[$i] = 0;
	}
//echo count($desGone);
	$uDes = array_unique($des);

	$dessy = array();
	$dessyCount = array();
	for ($e =0;$e <	 count($des);$e++){
		$dessy[$des[$e]] = 0;
		$dessyCount[$des[$e]] = 1;

	}
/*
for($i=0;$i < count($dump); $i++) {
	for($d=0;$d < count($des); $d++) {
		if ($dump[$i] == $des[$d]) {
			$dessy[$dump[$i]]++;
		}
	}
}
*/
//print_r($uDes);
	for ($i=0;$i < count($des); $i++) {
		for($d=0;$d < count($dump);$d++){
			//echo $i."-".$d."_".$uDes[$i]."~".$dump[$d]."<---- <br>";
			if($uDes[$i] == $dump[$d]){
					//echo "<br>".$dump[$d]."<br>";

				$dessy[$uDes[$i]]++;
			}
		}
	}

//	print_r($dessy);
	$forPrint = "";

	$forPrint .= "    <table class='table table-striped table-bordered' style='margin-top:20px;	'>
    <thead>
    <tr>
    <th></th>
    <th>Location</th>
    <th>Road to next Location</th>
    <th class='chance'>Chance<a href='#' rel='tooltip' title='The system gives you various chances to stop at intersections if you do not have enough time'><small> ?</small></a></th>
    </tr>
    </thead>
    <tbody>";

	for ($i=0; $i < count($dump) ; $i++) { 
		$forPrint .= "<tr>";
		if((in_array($dump[$i], $des)) && $dump[$i] != $dump[0] && $dump[$i] != $dump[count($dump)-1]) {
			$forPrint .= "<td><i class='icon-map-marker' style='font-size:20px;'></i> <b style='font-size:10px;'>Waypoint</b></td>";
		}
		elseif($i != 0 && $i != count($dump)-1 ) {
			$forPrint .=  "<td><i class='icon-road' style='font-size:20px;'></i></td>";
			$isWaypoint = true;

		}
		else {
			$isWaypoint = false;
		}


		if ($i == 0) {
			$forPrint .=  "<td><i class='icon-home' style='font-size:20px;'></i><b style='font-size:10px;'> Start</b></td>";
		}
		elseif ($i == count($dump)-1) {

			$forPrint .= "<td><i class='icon-map-marker' style='font-size:20px'></i><b style='font-size:10px;'> End</b></td>";
		}
		$query = "SELECT Name FROM Intersections WHERE id='$dump[$i]' ";
		$result = mysql_query($query);
		$ar =  mysql_fetch_array($result,MYSQL_NUM);
		$forPrint .=  "<td><strong>".$ar[0]."</strong> ".$dump[$i]."</td>";

		$foundStreet = false;
		$query = "SELECT Street1, Street2, Street3, Street4 FROM Intersections WHERE id='$dump[$i]'";				
		$result = mysql_query($query);
		$qq = $dump[$i+1];
		$q2 = "SELECT Street1, Street2, Street3, Street4 FROM Intersections WHERE id='$qq'";				
		$r2 = mysql_query($q2);
		//print_r($result);
		$ff = array();
		$ss = array();
		$row = mysql_fetch_array($result,MYSQL_NUM);
		$row2 = mysql_fetch_array($r2,MYSQL_NUM);
		$row = array_filter($row);
		$row3 = $row;
		$row2 = array_filter($row2);
		$diff =  array_intersect($row, $row2);
		$diff = reset($diff);
		$streetQ = "SELECT name FROM Streets WHERE id='$diff'";
		$streetR = mysql_query($streetQ);
		$streetName = mysql_fetch_assoc($streetR);
		$forPrint .= "<td>".$streetName['name']."</td>";
		if ($i == 0) {
			$forPrint .= "<td></td>";
		}
		elseif($i == count($dump)-1) {
			$forPrint .= "<td style='border-left:none;'></td>";
		}
				if(!$i == 0 && $i != count($dump)-1) {
			$bool = $dump[$i] == $dump[0];
			//echo ">>".$dump[$i]."=".$dump[0]."<<";
		//	echo $bool;
			if((in_array($dump[$i], $des)) && $dump[$i] != $dump[0] && $dump[$i] != $dump[count($dump)-1]) {
				if ($dessy[$dump[$i]] == 1 ) {
				}
				else {
					$forPrint .= "<td>".$dessyCount[$dump[$i]]."/".$dessy[$dump[$i]]."</td>";
					$dessyCount[$dump[$i]]++;
				}
			}

		}
		if($isWaypoint) {
			$forPrint .= "<td></td>";
		}
		$forPrint .=  "</tr>";
	}
	$forPrint .= "    </tbody>
    </table>
";
echo $forPrint;
$_SESSION['print'] = $forPrint;
echo '		<div class="form-actions">
							
							<a class="btn btn-primary"><i class="icon-list-alt"></i> View Stats</a>
							<a class="btn btn-inverse" href="print.php"><i class="icon-print"></i> Print </a>
							<a class="btn"><i class="icon-refresh" href="index.php"></i> Start again</a>
						</div>';
}
echo "</div>";
 ?>