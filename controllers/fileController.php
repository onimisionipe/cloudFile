<?php

/*
 * Copyright (C) 2014
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

/**
 * @author Mathieu Onipe - onimisionipe@gmail.com
 * @version
 * 
 * 
 */
class fileController extends Controller {
    private $userRoot;
    public $error;
    public $message;
    public $curfolder;
    public $pathroot;
    
    public function __construct() {
        parent::__construct();
    }
    
    //default method that would called when view is loaded.
    public function index(){
       
        $user = CFactory::getUser();
        if(!$user->getUser('email')){
            Redirect::relocate('index');
        }
        
        //check if current path is set. if not, set to user's root
          $session = CFactory::getSession();
        if(!($session->getSession('cur_path'))){
            $path = USER_FILE.$user->getUser('folder_path');
            $session->setSession('cur_path',$path);
            $this->pathroot = true;
            
        } 
                
        $this->setTitle(P_NAME.'- File Manager');
        $this->assign('logout', 'Logout');
            $this->assign('logoutlink', HTTP_SERVER.'/logout');
            $this->assign('filemgr', HTTP_SERVER.'/file');
            $this->assign('filelink', 'My Files');
            $this->assign('filelink2', 'My Files - <small>User File Manager</small>');
            $this->assign('description', '<small>Manage Your Files Here...</small>');
            $this->assign('usermessage', '<small>Hello</small> '.$user->getUser('fullname'));
            
            $this->assign('welcome', 'Hi! '. $user->getUser('fullname'));
            $this->setTitle('Hey '. $user->getUser('fullname').' - '.P_NAME);
            $this->setHead('<link rel="stylesheet" href="'.HTTP_SERVER.'/views/templates/default/css/file.css" type="text/css" media="screen" />');
            $this->setNav(ROOT.DS.'views'.DS.'templates'.DS.TEMPLATE.DS.'nav-home.tpl');
            
            $this->assign('SESSION', CFactory::getUser()->getSessionId());
            //get user root dir. list files in user root dir
            
            $this->userRoot = USER_FILE.$user->getUser('folder_path');
            $userfiles = $this->loadModel('file');
            $quota = $userfiles->getQuota();
                                  
            $list = $userfiles->listFiles(CFactory::getSession()->getSession('cur_path'));
           
            //set cur path
            $curpath = USER_FILE.$user->getUser('folder_path');
            $curpath2 = CFactory::getSession()->getSession('cur_path');
            $curpath3 = str_replace($curpath,"root", $curpath2);
                        
            $curpath3 = str_replace("\\", "/", $curpath3);    
            $listpath = explode("/", $curpath3);
            $buildpaths = array();
            
            foreach($listpath as $li){
                $buildpaths[] = array("foldername"=>$li, "path1"=>  str_replace("/","-",stristr($curpath3, $li,true)));                
            }
            $this->assign('curpath', $buildpaths);
            $this->assign('curpath2',$curpath3."/");
            $this->assign('list', $list);
            $this->assign('quota', $quota);
            $this->assign('limit', QUOTA."MB");
            
            //set error and message
            if(isset($this->error)){
                $this->assign('error', $this->error);
                
            }
            
             if(isset($this->pathroot)){
                $this->assign('pathroot', 'true');
                
            }
            if(isset($this->message)){
                $this->assign('success', $this->message);
                
            }
            
            $this->loadView("file.tpl");
            
        
    }
    
    public function upload(){
        $user = CFactory::getUser();
        if(!$user->getUser('email')){
            Redirect::relocate('index');
        }
        
        if(isset($_FILES['newfile'])){
            $upload = $this->loadModel('file');
            $result = $upload->upload();
            if($result!== true){
                $this->error = $result;
                $this->index();
            } else {
                $this->message = "File(s) Uploaded successfully";
                $this->index();
            }
            
        } else{
            $this->index();
        }
        
            }
     public function delete($file){
         $user = CFactory::getUser();
        if(!$user->getUser('email')){
            Redirect::relocate('index');
        }
         //build path from current directory
         $delete = $this->loadModel('file');
         $dodelete = $delete->delete(CFactory::getSession()->getSession('cur_path').DS.$file);
         if($dodelete === true){
             $this->message = "File/Folder has been successfully deleted";
             $this->index();
         } else {
             $this->error = $dodelete;
             $this->index();
         }
         
     }
     
     public function bulkdelete(){
         $user = CFactory::getUser();
        if(!$user->getUser('email')){
            Redirect::relocate('index');
        }
         if(CFactory::getRequest()->post('file')){
             $files = CFactory::getRequest()->post('file')['file'];
             $bulkdelete = $this->loadModel('file');
             $done = $bulkdelete->bulkDelete($files);
             if($done===true){
                 $this->message = "File(s) have been deleted successfully";
                 $this->index();
             } else{
                 $this->error = "Error deleting file(s), please try again";
                 $this->index();
             }
         }else{
             $this->index();
         }
     }
  
     
     
     public function newfolder(){
         $user = CFactory::getUser();
        if(!$user->getUser('email')){
            Redirect::relocate('index');
        }
        
        if(CFactory::getRequest()->post('newfolder')){
            $new = $this->loadModel('file');
            $done = $new->newFolder(CFactory::getRequest()->post('newfolder')['newfolder']);
            if($done===true){
                $this->message = CFactory::getRequest()->post('newfolder')['newfolder']." folder has been created";
                $this->index();
            } else{
                $this->error = "Error Creating Folder, Please try again";
                $this->index();
            }
        }else {
            $this->index();
        }
        
     }
     
     public function open($folder){
          $user = CFactory::getUser();
        if(!$user->getUser('email')){
            Redirect::relocate('index');
        }
        
        if(isset($folder)){
            $open = $this->loadModel('file');
            //let the model check for valid folder, and set th current dir to the folder.
            $open2 = $open->open($folder);
            if($open2===true){
                $this->index();
            } else {
                $this->error="Error Opening Folder. Please contact administrator to resolve this";
                $this->curfolder = $folder;
                $this->index();
            }
            
        } else {
            $this->index();
        }
        
     }
     
     public function loadpath($thepath){
          $user = CFactory::getUser();
        if(!$user->getUser('email')){
            Redirect::relocate('index');
        }
         //reformat path
         $newpath = str_ireplace("-", DS, $thepath);
         $newpath = str_ireplace("root", USER_FILE.CFactory::getUser()->getUser('folder_path'), $newpath);
         //set new path      
         CFactory::getSession()->setSession('cur_path', $newpath);
         $this->index();
         
         
     }
     
     public function rename(){
          $user = CFactory::getUser();
        if(!$user->getUser('email')){
            Redirect::relocate('index');
        }
        
        if(CFactory::getRequest()->post('rename')){
            $rename = $this->loadModel('file')->rename(CFactory::getRequest()->post('rename')['rename'], CFactory::getRequest()->post('oldname')['oldname'],CFactory::getRequest()->post('fileext')['fileext']);
            
            if($rename===true){
                $this->message = "File has been renamed successfully";
                $this->index();
            } else{
                $this->error = "Error renaming file. please try again";
                $this->index();
            }
            
        } else {
            $this->index();
        }
     }
     
     public function copyto($folder){
        $user = CFactory::getUser();
        if(!$user->getUser('email')){
            Redirect::relocate('index');
        }
       if(CFactory::getRequest()->post('folder')['folder']){
           $copy = $this->loadModel('file')->copyTo(CFactory::getRequest()->post('folder')['folder'],CFactory::getRequest()->post('filestocopy')['filestocopy']);
           
           if($copy === true){
               $this->message = "Files has been copied successfully";
               $this->index();
           } else {
               $this->error = "Error copying files.. please try again";
               $this->index();
           }
       } else {
           $this->index();
       }
     }
     
     
         
        
        }
        
        
    

