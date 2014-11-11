
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
                   
                <form name="recover" class="form-signin" action="recover/recover" method="post" role="form">
                  <h2 class="form-signin-heading">Enter Your email address to recover <span class="subtext">your password</span></h2>
                 <input type="email" class="form-control" name="email" placeholder="Email address" required><br/>
        
        
        <br/>
        
        <button class="btn btn-lg btn-primary btn-block chncolor" type="submit">Recover</button>
      </form>  
        
    <?php } ?>
    </div> <!-- /container -->