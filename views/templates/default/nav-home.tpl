<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
        <a class="navbar-brand" href="<?php echo HTTP_SERVER;?>"><img src="<?php echo $logo; ?>" /><?php echo $heading; ?></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        
      </ul>
      
      <ul class="nav navbar-nav navbar-right">
          <?php 
        if(isset($logout)){
        ?>
        <li><a href="#"><?php echo $welcome; ?></a></li>
        <li><a href="<?php echo $filemgr; ?>"><?php echo $filelink ?></a></li>
        <li><a href="<?php echo $logoutlink; ?>"><?php echo $logout; ?></a></li>
       <?php  } else {
        ?>
        <li><a onclick="toScroll('login');">Login</a></li>
        <li><a onclick="toScroll('register')">Register</a></li>
        <?php } ?>
        
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<script>
    function toScroll(theclass){
        $('html, body').animate({
        scrollTop: $("."+theclass+"").offset().top-120},1500);
        $("."+theclass+" input:first").focus();
    }
    
    
</script>