<?php 
echo '
<html>
<head>
	<title>routefiend</title>
	<link rel="shortcut icon" href="img/ic.ico">
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
		<form method="POST" action="merge.php">
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
</html>';
?>