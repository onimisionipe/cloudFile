<script type="text/javascript">
    window.onload = function(){
     //check if localstorage var is set 
     if(sessionStorage['<?php echo $SESSION; ?>'] !== undefined){
          $('a.copybutton').css("display","none");
          
            var clipboard = '<a style="pull-right" onclick="clearClipBoard()">Clear <span class="badge">'+JSON.parse(sessionStorage['<?php echo $SESSION; ?>']).length+'</span>files in clipboad</a>';
                $('.controls').append(clipboard);
                 $('.filerow').each(function(){
           if($(this).find(".extension").text()== "Folder"){
               var paste = '   <a onclick=copyTo("'+$(this).find("input").attr("value")+'")><span style="font-size:13px;" class="label label-danger">Paste</span></a>';
               $(this).find(".realfiles").append(paste);
               
               
           }
    })          
     
     $('a').tooltip();
        
    } else {
        sessionStorage.clear();
    }
     }
  function clearClipBoard(){
       sessionStorage['<?php echo $SESSION; ?>'] = null;
       delete sessionStorage['<?php echo $SESSION; ?>'];
       window.location = "<?php echo $APP_URL; ?>/file";
   }
</script>

<script type="text/javascript">
    
    var stateofcheck=0;
   function checkAll(){
       if(stateofcheck==0){
       $('.checkme').each(function(){
           this.checked=true;
    });
    stateofcheck=1;
        } else {
        $('.checkme').each(function(){
           this.checked=false;
    });
    stateofcheck=0;
        }
                         
   }
   
   function deleteFiles(){
       var check=0;
       
       //check if files are selected
     $('.checkme').each(function(){
           if(this.checked==true){
               check++;
           }  
   });
   
   if(check==0){
       alert("Select File(s)")
   } else{
       $('form.mainform').attr("action","<?php echo $APP_URL;?>/file/bulkdelete");
       $('form.mainform').submit();
       
   }
   }
   
   function renamePopup(filename,fileext){
       $('form.renameform').attr("action","<?php echo $APP_URL; ?>/file/rename");
       $('input.oldname').attr("value",filename);
        $('input.fileext').attr("value",fileext);
       $('label.oldnamedisplay').text("Oldname:"+filename);
       $('form.renameform input:first').focus();
       $('.popmodal').modal();
      
       
       
   }
   
   function copyFiles(){
       var check=0;
       var files = [];
       var curpath = "<?php echo $curpath2;?>";
       
      
       //check if files are selected
     $('.checkme').each(function(){
           if(this.checked==true){
               
               files[files.length]=curpath+this.value;
               check++;
           }  
   });
   sessionStorage['<?php echo $SESSION; ?>']= JSON.stringify(files);
   $('a.copybutton').css("display","none");
   var clipboard = '<a style="pull-right" onclick="clearClipBoard()">Clear <span class="badge">'+files.length+'</span>files in clipboad</a>';
   $('.controls').append(clipboard);
   //alert(sessionStorage["filestocopy"]);
   if(check==0){
       alert("Select File(s)");
   } else{
       $('.filerow').each(function(){
           if($(this).find(".extension").text()== "Folder"){
               var paste = '   <a onclick=copyTo("'+$(this).find("input").attr("value")+'")><span style="font-size:13px;" class="label label-danger">Paste</span></a>';
               $(this).find(".realfiles").append(paste);
               
               
           }
    })
   }
   }
   
   function copyTo(folder){
       //populate and submit form with values from localstorage
       var files = JSON.parse(sessionStorage['<?php echo $SESSION; ?>']);
       $('form.mainform').attr("action","<?php echo $APP_URL;?>/file/copyto/"+folder);
       $('form.mainform').append('<input type="hidden" name="folder" value="'+folder+'" />');
       for(var i=0; i<files.length; i++){
           $('form.mainform').append('<input type="hidden" name=filestocopy[] value="'+files[i]+'" />');
       }
       $('form.mainform').submit();
       
       
   }
   
 
</script>

<div class="container drop">
     <div class="modal fade popmodal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <form class="renameform" action="<?php echo $APP_URL; ?>/file/newfolder" method="post">
            <label class="oldnamedisplay">Rename File or Folder:</label>
            <label></label><br/>
            <input type="text" name="rename" placeholder="New Name" required />
            <input class="oldname" type="hidden" name="oldname" value="" />
            <input class="fileext" type="hidden" name="fileext" value="" />
            <input type="submit" value="Rename" class="btn btn-success" />
        </form>
    </div>
  </div>
</div>
    
    <div class="row">
        <div class="semi-jumbo col-md-12">
            <br/><h4 class="pull-right"> <?php echo $usermessage; ?></h4> <br/>
            <h1><?php echo $filelink2; ?> </h1> 
            <h4>
               <?php echo $description; ?> 
            </h4>
            <div class="progress">
                <?php if($quota[1]<50) {
                ?>
                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $quota[1];?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $quota[1]."%";?>;">
    <?php echo $quota[1]."%";?> , You have used <?php echo round($quota[0]/(1024*1024),2); ?>MB out of <?php echo $limit; ?>
    
  </div>
                <?php }elseif($quota[1]<75){
                ?>
                <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="<?php echo $quota[1];?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $quota[1]."%";?>;">
    <?php echo $quota[1]."%";?> , You have used <?php echo round($quota[0]/(1024*1024),2); ?>MB out of <?php echo $limit; ?>
    
  </div>
                <?php }elseif($quota[1]<100){
                ?>
                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="<?php echo $quota[1];?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $quota[1]."%";?>;">
    <?php echo $quota[1]."%";?> , You have used <?php echo round($quota[0]/(1024*1024),2); ?>MB out of <?php echo $limit; ?>
    
  </div>
                <?php } ?> ?>
</div>
            <form name="upload" class="upload" method="post" action="<?php echo $APP_URL; ?>/file/upload" enctype="multipart/form-data">
                <Label>Upload File(s):</Label><input type="file" name="newfile[]" multiple required />
                <input type="submit" name="fileupload" value="Upload" class="btn btn-primary"/>
            </form>
        </div>
        <div class="modal fade filemanagermodal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <form class="modalform" action="<?php echo $APP_URL; ?>/file/newfolder" method="post">
            <label>New Folder Name:</label>
            <input type="text" name="newfolder" placeholder="Folder Name" required />
            <input type="submit" value="Create Folder" class="btn btn-success" />
        </form>
    </div>
  </div>
</div>
        <div class="controls col-md-12">
            
            <a class="pull-left" onclick="deleteFiles();"><span class="glyphicon glyphicon-remove-circle"></span><br/>Delete</a>        
            <a class="pull-left" data-toggle="modal" data-target=".filemanagermodal"><span class="glyphicon glyphicon-folder-close"></span><br/>New Folder</a>        
            <a class="pull-left copybutton" onclick="copyFiles();"><span class="glyphicon glyphicon-transfer"></span><br/>Copy</a>        
        </div>
    </div>
    <div class="files col-md-12">
        
        
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
    <?php }
    ?>
    <div class="path">
    <?php 
    foreach($curpath as $path){
    ?>
    
    <a href="<?php echo $APP_URL ?>/file/loadpath/<?php echo $path['path1'].$path['foldername'];?>"><?php echo $path['foldername']; ?> </a>/
    <?php }
    ?>
    </div>
    <form name="files" class="mainform" action="" method="post">
        <div class="table-responsive">
    <table class="filetable table-striped" border="0">
        <tr>
            <td><a onclick="checkAll();">Select all</a></td><td class="fileimg">Type</td><td class="filename">Name</td><td>Last Accessed</td><td>Mime Type</td> <td>Size</td> <td>Operations</td>
        </tr>
        <?php 
        foreach($list as $file) {
        ?>
        <tr class="filerow">
            <td><input class="checkme" type="checkbox" name="file[]" value="<?php echo $file['filename']; ?>"/></td><td><div class="extension"><?php echo $file['fileext']; ?></div></td><td class="realfiles"><a data-toggle="tooltip" data-placement="top" data-title="Click to Open(folder) or Download" href="<?php echo $APP_URL; ?>/file/<?php echo ($file['fileext']=='Folder')? 'open':'download'; ?>/<?php echo $file['filename']; ?>"><?php echo $file['filename']; ?></a></td><td><?php echo date("Y-m-d h:i:sa",$file['date_mod']); ?></td><td><?php echo $file['fileext']; ?> File</td><td><?php echo round($file['size']/1048576, 3); ?>MB</td><td><a title="Delete file" href="<?php echo $APP_URL; ?>/file/delete/<?php echo $file[filename];?>"><span class="glyphicon glyphicon-remove"></span>Delete</a> | <a title="Rename File" onclick="renamePopup('<?php echo $file[filename]; ?>','<?php echo $file[fileext]; ?>')"><span class="glyphicon glyphicon-edit"></span>Rename</a> | <a title="Share File" href="<?php echo $APP_URL; ?>/file/share/<?php echo $file[filename];?>"><span class="glyphicon glyphicon-share"></span> Share</a> | <a title="Download File" href="<?php echo $APP_URL; ?>/file/download/<?php echo $file[filename];?>"><span class="glyphicon glyphicon-download"></span>Download</a></td>
        </tr>
        <?php 
        }
        ?>
        
        
    </table>
    
    
        
    </div>
        </form>
    </div>
    </div> <!-- /container -->