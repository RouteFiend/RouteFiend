<?php 
$navBar = '
<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			<a class="brand" href="index.php"><h1>route<small>fiend</small></h1></a>
			<div class="nav-collapse">
				<ul class="nav">
					<li class="">
						<a href="#">About</a>
					</li>
				</ul>
				<ul class="nav pull-right">
					<li class="divider-vertical"></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><b><i class="icon-user"></i>'.$_SESSION['email'].'</b> <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="logout.php"><i class="icon-off"></i>Logout</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>

';
 ?>