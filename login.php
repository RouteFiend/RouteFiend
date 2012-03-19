<?php include 'header.php'; ?>

		 <div class="container" id="loginCont">
		 	<div class="inner">

		      <form class="form-inline" method="POST" action="index.php">
		      	<fieldset>	
		      				 			 	<legend><h1 id="logo">route<small>fiend</small></h1></legend>


	<?php if($_GET['login_err']) {
		echo ' 
    <div class="alert alert-error"><i class="icon-exclamation-sign"></i>
    <a class="close" data-dismiss="alert">×</a>
        <strong>Error: </strong> Login Incorrect
    </div>';
	}
    if($_GET['sign_up']) {
  echo ' 
    <div class="alert alert-info"><i class="icon-cog"></i>
    <a class="close" data-dismiss="alert">×</a>
        <strong>Info: </strong> Sign ups not implemented
    </div>';

    }
	?>
	<div class="control-group">
            <div class="controls">
              <div class="input-prepend">

                <span class="add-on"><i class="icon-envelope"></i></span><input name="email"class="input-medium" id="d" size="16" type="text"placeholder="email">
              </div>
            </div>
        </div>
	<div class="control-group">

            <div class="controls">
              <div class="input-prepend">
                <span class="add-on"><i class="icon-key"></i></span><input name="password" class="input-medium" id="prependedInput" size="16" type="password"placeholder="password">
              </div>
            </div>
        </div>
                  <div class="form-actions">
        			        			<a href="index.php?sign_up=1" class="btn" id="reg"><i class="icon-chevron-left"></i> Sign up</a> 

        			<button type="submit" class="btn btn-inverse" id="sign">Login <i class="icon-chevron-right"> </i></button>   

        		<input type="hidden" name="sub_login" value="TRUE" />
        	</div>
</fieldset>
        </form>
          </div>
      </div>
	 
<?php include 'footer.php'; ?>