<?php 

require_once('dbc.php');
echo "<pre>";

$intersections = $_SESSION['des'];
$times = $_SESSION['times'];
print_r($intersections);

$arr = array();
for ($i=0;$i < count($intersections);$i++){
	echo "hello";
$query = "SELECT id FROM Intersections WHERE Name='$intersections[$i]'";				
$result = mysql_query($query);

	while ($row = mysql_fetch_assoc($result)) {
		echo "hello";
		$arr[] = $row["id"];
	}
}
print_r($arr);
// add 00 to the end of times (for java sake)
$newTimes = array();
foreach($times as $time) {
$newTimes[] = $time.":00";
}
echo "<br>";
print_r($newTimes);

 ?>