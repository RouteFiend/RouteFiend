<?php 

 	//ini_set('display_errors', 1);
    //error_reporting(E_ALL | E_STRICT);



    include 'util.php';
    $timeHtml = genSelectDefault();

	if (isset($_POST['sub_post']))
	{
		$valid = true;
	$intersections = $_POST['intersection'];
	$periodsFrom = $_POST['periodFrom'];
	$periodsTo = $_POST['periodTo'];
	$timeFrom = $_POST['timeSelectFrom'];
	$timeTo = $_POST['timeSelectTo'];	
	$count = count($intersections);

	$output = "\n";
	for ($v = 0; $v < $count; $v++) {
	// validate house 
		$output .= "<div class='well' style='background-color: #f2dede' >";
		if (empty($intersections[$v])) {
			$valid = false;
			$output .= '<input class="input-small" type="text" name="intersection[]" size="1"placeholder="intersection">';
		}
		else {
			$output .= '<input class="input-small"type="text" name="intersection[]" size="1"placeholder="intersection" value="'.$intersections[$v].'">';

		}
		if ($count > 1) {
			$output .= "<a href='#' class='close'>&times;</a>";
		}
		$fullTimeFrom = strtotime($timeFrom[$v].$periodsFrom[$v]);
		$fullTimeTo = strtotime($timeTo[$v].$periodsTo[$v]);
		if ($fullTimeFrom > $fullTimeTo) {
			$output .= '<span class="label label-important">Important</span> ';
			$output .= genSelectDefault();
		}
		else {
			$output .= genSelect($timeFrom[$v],$periodsFrom[$v],$timeTo[$v],$periodsTo[$v]);

		}
		$output .= "</div>";
	}
	}
	else {
		$output = '
    <div class="container" id="get_cont">
<form method="POST" action="index.php?pa=2">
<fieldset>	
			<legend><h2 id="tadd">Add Intersections</h2></legend>
	<form method="POST" action="index.php?pa=2">
     <div id="main">
     	<div class = "well">
     	   <input class="input-small" type="text" name="intersection[]" size="1"placeholder="intersection">'.$timeHtml.'

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
			$clone.attr('class','well');

			$('#add').live('click',function() {
				main.append($clone.clone().show());
					if ( ($(".well").length) == 2 ) {
					$('.well').one().first().append($('<a>', {
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
		if(!$valid){
			echo '<div class="container" id="get_cont">';
			echo '<form method="POST" action="index.php?pa=2">';
			echo'	<fieldset>	';
			echo '<legend><h2 id="tadd">Add Intersections</h2></legend>';
			echo "	<div id='main'>";
			  echo ' 
    <div class="alert alert-error">
    <a class="close" data-dismiss="alert">×</a>
        <span class="badge badge-error">6</span> <strong>Errors found </strong></div>';
			echo $output;
			echo $foot;		}
		else {
			for ($i=0; $i < $count; $i++) { 
		$orders[$i] = 	$houseNums[$i]." ".
						$streets[$i]." ".
						$postcodes[$i]." ".
						$timeFrom[$i]." ".
						$periodsFrom[$i]." - ".
						$timeTo[$i]." ".
						$periodsTo[$i]."<br />";
	} 
		for ($i=0; $i < $count; $i++) { 
			$jsonurl = "http://maps.googleapis.com/maps/api/geocode/json?address=".$houseNums[$i]."+".urlencode($streets[$i]).",+".urlencode($postcodes[$i])."&sensor=false";
			//$json = file_get_contents($jsonurl,0,null,null);
			$ch = curl_init($jsonurl);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
			$content = curl_exec($ch);
			curl_close($ch);
			$json_output = json_decode($content);
			echo (String) $json_output->results[0]->formatted_address." ".$timeFrom[$i].$periodsFrom[$i]." - ".$timeTo[$i].$periodsTo[$i]."<br>";
		}
	}
		}
	else {
		echo $output;
		echo $foot;
	}
	?>
   	<div class = "temp"style="display:none">
   		     	   <input class="input-small" type="text" name="intersection[]" size="1"placeholder="intersection">
          <?php echo genSelectDefault(); ?>
               	         	    <a class="close">&times;</a>

      </div>
<?php include 'footer.php'; ?>