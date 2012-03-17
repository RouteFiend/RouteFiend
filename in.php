<?php 

 	ini_set('display_errors', 1);
    error_reporting(E_ALL | E_STRICT);
    session_start();
   	echo $_SESSION['user_id'];
    include 'genTime.php';
    $timeHtml = genSelectDefault();
    function isPost($postcode) {
		$postcode = strtoupper($postcode);
		$postcode = preg_replace('/[^A-Z0-9]/', '', $postcode);
		$postcode = preg_replace('/([A-Z0-9]{3})$/', ' \1', $postcode);
		$postcode = trim($postcode);

		if (preg_match('/^[a-z](\d[a-z\d]?|[a-z]\d[a-z\d]?) \d[a-z]{2}$/i', $postcode)) {
			return true;
		} else {
			return false;
		}

	}
	if (isset($_POST['submitted']))
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
		$output = '
	<form method="POST" action="in.php">
     <div id="main">
     	<div class = "entry">
     		<input type="text" name="houseNum[]" size="1"placeholder="number"><br />
     		<input type="text" name="street[]" size="10"placeholder="street"> <br />
          <input type="text" name="postCode[]" maxlength="7"size="2"placeholder="postcode"> <br>'.$timeHtml.'
	      </div>
     </div>
     <input id="add" type="button" value="Add another text input">
     <input type="submit">
     <input type="hidden" name="submitted" value="TRUE" />
</form>';
	}
 ?>
<html>
<head>
	<title></title>
	<style type="text/css">
	body{
		font-size: 14px;
	}
	.entry{
		margin-bottom:15px;
		border: thin solid black;
		width: 250px;
		padding: 10px;
	}
	</style>
	<script src="jquery.js"></script>
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

			var $clone = $('.temp').clone();
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
</head>
<body>

	<?php 
	if (isset($_POST['submitted'])){
		if(!$valid){
			echo '<form method="POST" action="in.php">';
			echo "	<div id='main'>";
			echo "<h1> Error </h1>";
			echo $output;
			echo "</div>";
			echo '     <input type="submit">';
			echo '     <input id="add" type="button" value="Add another text input">';
			echo '     <input type="hidden" name="submitted" value="TRUE" />';
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
</body>
</html>