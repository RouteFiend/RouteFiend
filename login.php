<?php include 'header.php'; ?>
<script type="text/javascript">
$(".alert").alert();
</script>
<div id="top"></div>
<div class="container" id="loginCont">
    <div class="inner">

        <form class="form-inline" method="POST" action="index.php" autocomplete="on">
           <fieldset>	
            <legend><h1 id="logo">route<small>fiend</small></h1></legend>


              <?php if($_GET['login_err']) { ?>
              <div class="alert alert-error fade in"><i class="icon-exclamation-sign"></i>
                <a class="close" data-dismiss="alert">×</a>
                <strong>Error: </strong> Login Incorrect
            </div>
            <?php
        }
        if($_GET['sign_up']) { ?>
        <div class="alert alert-info fade in"><i class="icon-cog"></i>
            <a class="close" data-dismiss="alert">×</a>
            <strong>Info: </strong> Sign ups not implemented
        </div>

        <?php }
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

<a data-toggle="modal" href="#myModal" >Forgotten Password?</a> <br>

<div class="form-actions">
  <a href="index.php?sign_up=1" class="btn" id="reg"><i class="icon-chevron-left"></i> Sign up</a> 

  <button type="submit" class="btn btn-inverse" id="sign">Login <i class="icon-chevron-right"> </i></button>   

  <input type="hidden" name="sub_login" value="TRUE" />
</div>
</fieldset>
</form>
</div>
</div>
<div class="modal hide fade" id="myModal">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>
        <h3>Forgotten Password?</h3>
    </div>
    <div class="modal-body">
        <p>Use the test account:</p>
        <p>Email: <b>route@fiend.com</b></p>
        <p>Password: <b>test</b></p>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">Close</a>
    </div>
</div>

<?php include 'footer.php'; ?>