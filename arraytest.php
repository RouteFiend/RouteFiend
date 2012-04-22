<?php
$key = "keyy";
$val = "valss";

$array = array(
	$key => $val
	);

echo $array[$key];
echo count($array);
if (isset($array[$key])){
	echo "ye";
}
$array["keyd"] = "vals2";
echo count($array);
?>