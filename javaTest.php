<?php 
define("JAVA_HOSTS", "127.0.0.1:8095");
define("JAVA_SERVLET", "/JavaBridge/servlet.phpjavabridge");
require_once ("java/Java.inc");
//require_once("./Java.inc");

$world = new java("routefiend.RoutingTest");
$world->init();
$times = array('12:00:00','20:00:00','08:00:00','17:00:00','15:00:00');
$des = array(10,15,10,20,30);
$dump = java_values($world->solveForDestinationsAndTimes($des,$times));
if (in_array(-1, $dump))
{
	echo "NOT POSSIBLE!";
}
else {
echo "<pre>";
echo "# Destinations <br>";
print_r($des);
echo "# The route the java gives back <br>";
print_r($dump);	
echo "<br>";
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

print_r($dessy);
echo "<br>";
for ($i=0; $i < count($dump) ; $i++) { 
	if(!$i == 0 && $i != count($dump)-1) {
		$bool = $dump[$i] == $dump[0];
		//echo ">>".$dump[$i]."=".$dump[0]."<<";
	//	echo $bool;
		if((in_array($dump[$i], $des)) && $dump[$i] != $dump[0] && $dump[$i] != $dump[count($dump)-1]) {
			if ($dessy[$dump[$i]] == 1 ) {
			}
			else {
				echo $dessyCount[$dump[$i]]."/".$dessy[$dump[$i]]." ";
				$dessyCount[$dump[$i]]++;
			}
			echo "des";
		}

	}
	elseif ($i == 0) {
		echo "start";
	}
	elseif ($i == count($dump)-1) {
		echo "end";
	}
	echo " ".$dump[$i];
	echo "<br>";
}
/*
for loop -> see how many times a des is mentioned
print inntersection name
Start at Intersection Name (eg. AB) // intersection a
Get next intersection ID // intersection b

Find common street between intersection a & b, eg. street 1 or 2
print common street

print intersection name

*/
}
?> 