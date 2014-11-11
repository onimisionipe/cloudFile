
<div class="container drop">

    
    <?php if(isset($error)){
    ?>
    <div class="myerror">
        <div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  <strong>Error!</strong> <?php echo $error; ?>
</div>
    </div>
    <?php } ?>
      <form class="form-signin" role="form" action="login/login" method="post">
          
        <h2 class="form-signin-heading">Sign in for Registered users</h2>
        <input type="email" name="email" class="form-control" placeholder="Email address" required autofocus>
        <input type="password" name="password" class="form-control" placeholder="Password" required>
        <br/>
        <br/>
        <a href="<?php echo HTTP_SERVER; ?>/recover">Forgot your password?</a> <br/><br/>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>

    </div> <!-- /container -->