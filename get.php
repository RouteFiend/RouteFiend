<?php 

 	//ini_set('display_errors', 1);
    //error_reporting(E_ALL | E_STRICT);

    session_start();


    include 'util.php';
    $timeHtml = genSelectDefault();

	if (isset($_POST['sub_post']))
	{
		$valid = true;
	$houseNums = $_POST['houseNum'];
	$streets = $_POST['street'];
	$postcodes = $_POST['postCode'];
	$periodsFrom = $_POST['periodFrom'];
	$periodsTo = $_POST['periodTo'];
	$timeFrom = $_POST['timeSelectFrom'];
	$timeTo = $_POST['timeSelectTo'];	
	$count = count($postcodes);

	$output = "\n";
	for ($v = 0; $v < $count; $v++) {
	// validate house 
		$output .= "<div class='entry'>";
		if (!is_numeric($houseNums[$v]) || empty($houseNums[$v])) {
			$valid = false;
			$output .= '<span> Error - </span> <input type="text" name="houseNum[]" size="1"placeholder="number"><br>';
		}
		else {
			$output .= '<input type="text" name="houseNum[]" size="1"placeholder="number" value="'.$houseNums[$v].'"><br>';
		}
		// validate street
		if (empty($streets[$v]))
		{
			$valid = false;
			$output .= '<span> Error - </span> <input type="text" name="street[]" size="10"placeholder="street"> <br>';
		}
		else {
			$output .= '<input type="text" name="street[]" size="10"placeholder="street" value="'.$streets[$v].'"> <br>';
		}
		//validate postcode
		if (!isPost($postcodes[$v])) {
			$valid = false; 
			$output .= '<span> Error - </span> <input type="text" name="postCode[]" maxlength="7"size="2"placeholder="postcode"> <br>';
		}
		else {
			$output .= '<input type="text" name="postCode[]" maxlength="7"size="2"placeholder="postcode"value="'.$postcodes[$v].'"> <br>';
		}
		
		$output .= genSelect($timeFrom[$v],$periodsFrom[$v],$timeTo[$v],$periodsTo[$v]);
		if ($count > 1) {
			$output .= "<a href='#' class='delete'> delete </a>";
		}
		$output .= "</div>";
	}
	}
	else {
		$output = ' <div class="navbar navbar-fixed-top">
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
               <li><a href="#">Options</a></li>
                <li class="divider"></li>
                <li><a href="logout.php">Logout</a></li>
              </ul>
            </li>
          </ul>
          </div>
        </div>
      </div>
    </div>


    <div class="container">
<form method="POST" action="index.php?pa=2">
<fieldset>	
			<legend><h2>Form</h2></legend>
	<form method="POST" action="index.php?pa=2">
     <div id="main">
     	<div class = "entry">
     		<input type="text" name="houseNum[]" size="1"placeholder="number"><br />
     		<input type="text" name="street[]" size="10"placeholder="street"> <br />
          <input type="text" name="postCode[]" maxlength="7"size="2"placeholder="postcode"> <br>'.$timeHtml.'
	      </div>
     </div>
     <input id="add" type="button" value="Add another text input">
     <input type="submit">
     <input type="hidden" name="sub_post" value="TRUE" />
</form>
</div>';
	}
 ?>
<?php include 'header.php'; ?>
	<script type='text/javascript'>
		$(document).ready(function() {
			
				var main = $('#main');

			$("a.delete").live("click", function() { 
				if( ($(".entry").length) == 2 ) {
						$(this).closest('.entry').remove();
						$(main).find(".delete").remove();
				}
				$(this).closest('.entry').remove();

			  return false;
			})
			var html = $('.temp').get(0).cloneNode(true);
			var $clone = $(html);
			$clone.attr('class','entry');

			$('#add').live('click',function() {
				main.append($clone.clone().show());
					if ( ($(".entry").length) == 2 ) {
					$('.entry').one().first().append($('<a>', {
					text: 'delete', 
					class: 'delete', 
					href: '#'
					}));
				}
			})	
		})
	</script>

	<?php 
	if (isset($_POST['sub_post'])){
		if(!$valid){
			echo "<h1 id = 'logo'>route<small>fiend</small></h1>";
			echo '<form method="POST" action="index.php?pa=2">';
			echo'	<fieldset>	';
			echo '<legend><h2>Form</h2></legend>';
			echo "	<div id='main'>";
			echo "<h1> Error </h1>";
			echo $output;
			echo "</div>";
			echo '     <input type="submit">';
			echo '     <input id="add" type="button" value="Add another text input">';
			echo '     <input type="hidden" name="sub_post" value="TRUE" />';
			echo '</fieldset>';
			echo '   </form>';
		}
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
	}
	?>
	<a href="logout.php">logout</a>
   	<div class = "temp"style="display:none">
     		<input type="text" name="houseNum[]" size="1"placeholder="number"><br>
     		<input type="text" name="street[]" size="10"placeholder="street"> <br>
          <input type="text" name="postCode[]" maxlength="7"size="2"placeholder="postcode"> <br>
          <?php echo genSelectDefault(); ?>
          <a href='#' class='delete'> delete </a>
      </div>
<?php include 'footer.php'; ?>