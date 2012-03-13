<?php 
 	ini_set('display_errors', 1);
    error_reporting(E_ALL | E_STRICT);
    include 'genTime.php';
    $timeHtml = genSelectDefault();
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
		$(function(){
			var counter = 1;
			var limit = 3;
			var template = $('.entry').clone();
			var main = $('#main');
			$('<a>', {
			    text: 'delete', 
			    class: 'delete', 
			    href: '#'
			}).appendTo(template);

			$("a.delete").live("click", function() { 
			  $(this).parent().remove();
			  return false;
			})
			$('#add').click(function() {
				main.append(template.clone());
				return false;
			}); 
		})
	</script>
</head>
<body>
<form method="POST" action="get.php">
     <div id="main">
     	<div class = "entry">
     		<input type="text" name="houseNum[]" size="1"placeholder="number"><br />
     		<input type="text" name="street[]" size="10"placeholder="street"> <br />
          <input type="text" name="postCode[]" maxlength="7"size="2"placeholder="postcode"> <br>
          <?php echo $timeHtml ?>
	      </div>
     </div>
     <input id="add" type="button" value="Add another text input">
     <input type="submit">
</form>
</body>
</html>