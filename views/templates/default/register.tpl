
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
    <?php if(isset($success)) {
    ?>
    <div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  <strong>Welldone!</strong> <?php echo $success; ?>
  
</div>
    <?php }else {
    ?>
                   
                <form name= "register" class="form-signin" action="register/register" method="post" role="form">
                  <h2 class="form-signin-heading">Don't have an <span class="subtext">Account?</span></h2>
        <input type="text" class="form-control" name="fullname" placeholder="Full name" required><br/>
        <input type="text" class="form-control" name="location" placeholder="Location (State, city or country)" required><br/>
         <input type="email" class="form-control" name="email" placeholder="Email address" required><br/>
        <input type="password" class="form-control" name="password" placeholder="Password" required>
        
        <br/>
        
        <button class="btn btn-lg btn-primary btn-block chncolor" type="submit">Create Account</button>
      </form>  
        
    <?php } ?>
    </div> <!-- /container -->