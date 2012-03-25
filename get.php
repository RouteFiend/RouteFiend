<?php 

 	//ini_set('display_errors', 1);
    //error_reporting(E_ALL | E_STRICT);



include 'util.php';
require_once('dbc.php');

function makeIntArr() {
	$query = "SELECT name FROM Intersections";				
	$result = mysql_query($query);
	$arr = array();
	$out = "";
	while ($row = mysql_fetch_assoc($result)) {
		$arr[] = $row["name"];
	}
	for ($i=0; $i < count($arr); $i++) {
		if ($i == (count($arr)-1)) { $out .= '"'.$arr[$i].'"'; }
		else { $out .= '"'.$arr[$i].'", ';} 
	}

	return $out;
}

$timeHtml = genSelectDefault();

if (isset($_POST['sub_post']))
{
	$valid = true;
	$tValid = true;
	$intersections = $_POST['intersection'];
	$times = $_POST['time'];
	$count = count($intersections);
	$errs = array();
	$errsNum = 0;
	$output = "\n";
	for ($v = 0; $v < $count; $v++) {
	// validate house 
		$valid = true;
		$output .= '<div class="well form-inline">
	<div class="control-group">

	<div class="controls">


	';
		for ($e = 0;$e < $count; $e++) {
			if($e != $v && $times[$v] == $times[$e]) {
				$valid = false;
				$tValid = false;
				$errs[] = "Intersections can't have the same time: ".$intersections[$e].":".$times[$e]." = ".$intersections[$v].":".$times[$v];
				$errsNum++;
			}
		}
		if (empty($intersections[$v])) {
			$valid = false;
			$output .= '<a class="ezz"><i class="icon-ban-circle"></i></a>
					<div class="input-prepend">';
			$output .=	'<span class="add-on" style="background-color:#f2dede;color: #b94a48;"><i style="color:#b94a48; ;"class="icon-map-marker"></i></span><input name="intersection[]" placeholder="where" type="text" class="input-mini" style="margin: 0 auto;" data-provide="typeahead" data-items="4" data-source=\'['.makeIntArr().']\'>';

			$errs[] = "Intersections is empty";
							$errsNum++;

		}
		else {
			if(!$valid) {
				$output .= '<a class="ezz"><i class="icon-ban-circle"></i></a>
					<div class="input-prepend">';
				$output .= 	'<span class="add-on" style="background-color:#f2dede;color: #b94a48;"><i style="color:#b94a48; ;"class="icon-map-marker"></i></span><input value="'.$intersections[$v].'" name="intersection[]" placeholder="where" type="text" class="input-mini" style="margin: 0 auto;" data-provide="typeahead" data-items="4" data-source=\'['.makeIntArr().']\'>';

			}
			else {
				$output .= '<a class="ezz"><i class="icon-ok-circle"></i></a>
					<div class="input-prepend">';
								$output .= 	'<span class="add-on" style="background-color:#f2dede;color: #b94a48;"><i style="color:#b94a48; ;"class="icon-map-marker"></i></span><input value="'.$intersections[$v].'" name="intersection[]" placeholder="where" type="text" class="input-mini" style="margin: 0 auto;" data-provide="typeahead" data-items="4" data-source=\'['.makeIntArr().']\'>';

			}
		}
		$output .="\n";
		if ($tValid) {
			$output .= '<span class="add-on"><i class="icon-time"></i></span>'.finGenSelTime($times[$v]);
		}
		else {
			$output .= '<span class="add-on"><i class="icon-time"></i></span>'.finGenTime();
		}

		if ($count > 1) {
			$output .= "</div><a href='#' class='close'>&times;</a>";
		}
		else {
			$output .= "</div>";
		}
		$output .= "
</div></div>
		</div>";
	}


}
else {
	$d = finGenTime();
	$output = '
	<div class="container" id="get_cont">
	<form method="POST" action="index.php?pa=2" autocomplete="off">
	<fieldset>	
	<legend><h2 id="tadd">Add Intersections</h2></legend>
	<div id="main">

	<div class = "well form-inline">

	<div class="control-group">

	<div class="controls">
				<a class="ezz"><i class="icon-ban-circle"></i></a>

	<div class="input-prepend">


	<span class="add-on" style="background-color:#f2dede;color: #b94a48;"><i style="color:#b94a48; ;"class="icon-map-marker"></i></span><input name="intersection[]" placeholder="where" type="text" class="input-mini" style="margin: 0 auto;" data-provide="typeahead" data-items="4" data-source=\'['.makeIntArr().']\'>
	<span class="add-on"><i class="icon-time"></i></span>'.$d.'
	</div>

	</div>
	</div>
	</div>';
}
$foot = '       </div>
<div class="form-actions">
<button id="add" type="button" class="btn" id="sign"><i class="icon-plus"></i> Add</button>  
<button type="submit" class="btn btn-inverse" id="sign">Next <i class="icon-arrow-right"> </i></button>   
</div>
<input type="hidden" name="sub_post" value="TRUE" />
</form>
</div>';
?>
<?php include 'header.php'; ?>
<script type='text/javascript'>
$(document).ready(function() {

	var main = $('#main');

	$("a.close").live("click", function() { 
		if( ($(".well").length) == 2 ) {
			$(this).closest('.well').remove();
			$(main).find(".close").remove();
		}
		$(this).closest('.well').remove();

		return false;
	})
	var html = $('.temp').get(0).cloneNode(true);
	var $clone = $(html);
	$clone.attr('class','well form-inline');

	$('#add').live('click',function() {
		main.append($clone.clone().show());
		if ( ($(".well").length) == 2 ) {
			$('.controls').one().first().append($('<a>', {
				text:"×",
				class: 'close'				
			}));
		}
	})	
})
</script>

<?php 
echo ' <div class="navbar navbar-fixed-top">
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
<a href="#" class="dropdown-toggle" data-toggle="dropdown"><b><i class="icon-user"></i> '.$_SESSION['email'].'</b> <b class="caret"></b></a>
<ul class="dropdown-menu">
<li><a href="logout.php">Logout</a></li>
</ul>
</li>
</ul>
</div>
</div>
</div>
</div>';
if (isset($_POST['sub_post'])){
	if($errsNum != 0){
		echo '<div class="container" id="get_cont">';
		echo '<form method="POST" action="index.php?pa=2">';
		echo'	<fieldset>	';
		echo '<legend><h2 id="tadd">Add Intersections</h2></legend>';
		echo "	<div id='main'>";
		echo ' 
		<div class="alert alert-error">
		<a class="close" data-dismiss="alert">×</a>
		<span class="badge badge-error">';
		echo $errsNum;
		echo '</span> <strong>Errors found </strong></div>';
		echo $output;
		echo $foot;		}
		else {
			echo "<div id='get_cont'> $intersections[0] </div>";
		}
	}
	else {
		echo $output;
		echo $foot;
	}
	?>
	<div class = "temp"style="display:none">
		<div class="control-group">
			<div class="controls">

				<div class="input-prepend">
					<span class="add-on"><i class="icon-map-marker"></i></span><input name="intersection[]" placeholder="where" type="text" class="input-mini" style="margin: 0 auto;" data-provide="typeahead" data-items="4" data-source='[<?php echo makeIntArr(); ?>]'>
					<span class="add-on"><i class="icon-time"></i></span><?php echo finGenTime(); ?>
				</div>
				<a class="close">&times;</a>

			</div>
		</div>
	</div>'
</div>
<?php include 'footer.php'; ?>