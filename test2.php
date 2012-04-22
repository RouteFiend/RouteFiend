<?php 
define("JAVA_HOSTS", "127.0.0.1:8095");
define("JAVA_SERVLET", "/JavaBridge/servlet.phpjavabridge");
require_once ("java/Java.inc");
//require_once("./Java.inc");

$world = new java("routefiend.RoutingTest");
$world->init();
$times = array('10:00:00','09:00:00','11:00:00','14:00:00');
$des = array(10,15,20,30);
$dump = java_values($world->solveForDestinationsAndTimes($des,$times));
echo "<pre>";
print_r($dump);

 ?>