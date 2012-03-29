<?php 

 	//ini_set('display_errors', 1);
    //error_reporting(E_ALL | E_STRICT);



include 'util.php';
include 'nav.php';
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
	$deets = "(Scroll over left buttons for details)";
	$valid = true;
	$tValid = true;
	$iValid = true;
	$intersections = $_POST['intersection'];
	$times = $_POST['time'];
	$count = count($intersections);
	$errsNum = 0;
	$output = "\n";
	for ($v = 0; $v < $count; $v++) {
		$errs = array();

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
				$errsNum++;
			}
		}
		if (!$tValid) {
			$errs[] = "Intersections can't have the same time";

		}	
		if (empty($intersections[$v])) {
			$valid = false;
			$iValid = false;
			

			$errs[] = "Intersections is empty";
			$errsNum++;

		}
		if (!$valid) {
			$output .= '<a class="ezz err" rel="tooltip" title="<strong>Error: </strong><br>'.implode("<br>", $errs)
			.'"><i class="icon-remove-circle"></i></a>';
		}
		else {
			$output .= '<a class="ezz sucs" rel="tooltip" title="<strong>Everything fine here! </strong>"><i class="icon-ok-circle"></i></a>';

		}
		$output .= '<div class="input-prepend">';
		if (!$iValid) {
			$output .=	'<span class="add-on bErr"><i class="icon-map-marker"></i></span><input name="intersection[]" placeholder="where" type="text" class="input-mini" style="margin: 0 auto;" data-provide="typeahead" data-items="4" data-source=\'['.makeIntArr().']\'>';

		} 
		else {
			$output .=	'<span class="add-on bSuc"><i class="icon-map-marker"></i></span><input value="'.$intersections[$v].'"name="intersection[]" placeholder="where" type="text" class="input-mini" style="margin: 0 auto;" data-provide="typeahead" data-items="4" data-source=\'['.makeIntArr().']\'>';

		}
		$output .="\n";
		if ($tValid) {
			$output .= '<span class="add-on bSuc"><i class="icon-time"></i></span>'.finGenSelTime($times[$v]);
		}
		else {

			$output .= '<span class="add-on bErr"><i class="icon-time"></i></span>'.finGenTime();
		}

		if ($count > 1) {
			$output .= "</div><a href='#' class='close'>&times;</a>";
		}
		else {
			$valid = false;
			$errsNum++;
			$deets = "Must have over 1 Intersection";
			$output .= "</div>";
		}
		$output .= "
		</div></div>
		</div>";
	}


}
?>
<?php include 'header.php'; ?>
<script type='text/javascript'>
$(document).ready(function() {

	var main = $('#main');

	$("a.close").live("click", function() { 
		if( ($(".well").length) == 2 ) {
			$(this).closest('.well').remove().fadeOut("fast");
			$('.controls').find(".close").remove();
		}
		$(this).closest('.well').remove().fadeOut("fast");

		return false;
	})
	var html = $('.temp').get(0).cloneNode(true);
	var $clone = $(html);
	$clone.attr('class','well form-inline');

	$('#add').live('click',function() {
		main.append($clone.clone().show().fadeIn("fast"));
		if ( ($(".well").length) == 2 ) {
			$('.controls').first().append($('<a>', {
				text:"×",
				class: 'close'				
			}));
		}
	})	
	$('.controls').tooltip({
		placement: "left",
		selector: "a[rel=tooltip]"
	})

	$('.controls').tooltip();
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
if (isset($_POST['sub_post'])){
	if($errsNum != 0){ ?>
	<div class="container" id="get_cont">
		<form method="POST" action="index.php?pa=2" autocomplete="off">
			<fieldset>
				<legend><h2 id="tadd">Add Intersections</h2></legend>
				<div id='main'>
					<div class="alert alert-error fade in">
						<a class="close" data-dismiss="alert">×</a>
						<span><i class="exo icon-exclamation-sign"></i> <strong><?php 
						echo $errsNum." ";  
						echo $errOrErrs = ($errsNum > 1 ? "Errors: " : "Error: ");
						?> </strong> <?php echo $deets; ?></span>
					</div>
							<?php 
							echo $output."</div>";
							
						}

						else {
							$pa = 3;
							$url = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);
							if ((substr($url, -1) == '/r') OR (substr($url, -1)) == '\\') {
					$url = substr($url, 0,-1); //chop slash
				}
				$url .= "/index.php?pa=$pa";
				header("location: $url");
				exit();
			}
		}
		else { 
			?>
			<div class="container" id="get_cont">
				<form method="POST" action="index.php?pa=2" autocomplete="off">
					<fieldset>	
						<legend><h2 id="tadd">Add Intersections </h2></legend>
						<div id="main">
							<div class = "well form-inline">
								<div class="control-group">
									<div class="controls">
										<div class="input-prepend">
											<span class="add-on"><i class="icon-map-marker"></i></span><input name="intersection[]" placeholder="where" type="text" class="input-mini" style="margin: 0 auto;" data-provide="typeahead" data-items="4" data-source='[<?php echo makeIntArr();?>]'>
											<span class="add-on"><i class="icon-time"></i></span><?php echo finGenTime(); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php	}	?>
						<div class="form-actions">
							<button id="add" type="button" class="btn" id="sign"><i class="icon-plus"></i> Add</button>  
							<button type="submit" class="btn btn-inverse" id="sign">Next <i class="icon-arrow-right"> </i></button>   
						</div>
						<input type="hidden" name="sub_post" value="TRUE" />
					</form>
				</div>

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