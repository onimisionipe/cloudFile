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
 * 
 *
 * @author Mathieu Onipe - onimisionipe@gmail.com
 * @version
 * 
 * 
 */
class fileModel extends Model{
    
    public function __construct() {
        parent::__construct();
           
    }
    public function listFiles($directory){
        $files = scandir($directory, SCANDIR_SORT_ASCENDING);
        //state for building files list and properties
        $list = array();
        $setpath = CFactory::getSession();
        $setpath->setSession('cur_path', $directory);
        foreach($files as $file){
            if(is_dir($directory.DS.$file) && ($file!="." && $file!="..")){
                //die($directory.DS.$file);
            $arr = array('filename'=>$file, 'date_mod'=>fileatime($directory.DS.$file), 'size'=>$this->getFolderSize($directory.DS.$file), 'fileext'=>'Folder');
            $list[] = $arr;
        } elseif(is_file($directory.DS.$file) && ($file!="." && $file!="..")) {
            $arr = array('filename'=>$file, 'date_mod'=>fileatime($directory.DS.$file), 'fileext'=>pathinfo($directory.DS.$file,PATHINFO_EXTENSION), 'size'=>filesize($directory.DS.$file));
            $list[] = $arr;
            
        }
        }
        return $list;       
        
    }
    
    public function getFolderSize($path){
        $bytestotal = 0;
        $path = realpath($path);
        if($path !== false){
            
            foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)) as $file){
            $bytestotal+=$file->getSize();
        }
            
        } 
        
        return $bytestotal;
    }
    
    public function getQuota(){
        $path = USER_FILE.CFactory::getUser()->getUser('folder_path');
              
        $quota2 = array();
        //this line took me about 45 min to figure out. php iterator likes to return mixed. so don't assign with variable, assign with mixed or array
        $size[] = $this->getFolderSize($path);
        $quota = QUOTA *1024 *1024;
        $quota = ceil(100/($quota/$size[0]));
        $quota2[] = $size[0];
        $quota2[] = $quota;
        $quota2[] = (QUOTA *1024*1024) - $size[0];
        return $quota2;
        
    }
    
    public function checkQuota(){
        if($this->getQuota()[1]<100){
            return true;
          } else {
              return false;
          }
    }
    
    
    public function upload(){
        $curdir = CFactory::getSession()->getSession('cur_path');
        $files = array();
        
        //rebuild array as php uses not neccessary multi dimensional array for multiple upload
        $file = $_FILES['newfile'];
        if(is_array($file['name'])){
            for($i=0; $i<count($file['name']); $i++){
                $files[] = array('name'=>$file['name'][$i],'type'=>$file['type'][$i],'tmp_name'=>$file['tmp_name'][$i],'error'=>$file['error'][$i],
                    'size'=>$file['size'][$i]);
            }
        } else {
            $files[] = $file;
        }
        
        //now we can do our foreach - thanx stackoverflow
        
        foreach($files as $f){
            $quota = $this->getQuota();
            if($f['size']>=$quota[2]){
                $error = "Not enough space";
                return $error;
            } else{
                move_uploaded_file($f['tmp_name'], $curdir.DS.basename($f['name']));
                          
              
            }
        }
       
       
        
    }
    
    public function delete($filename){
        if(!is_dir($filename)){
        if(unlink($filename)){
            return true;
        } else {
            return "Error Deleting File/Folder";
        }
    } else {
        if($this->deleteDirectory($filename)){
            return true;
        } else {
            
        }
        
    }
    }
    /*
     * recursive function to delete directory
     */
    public function deleteDirectory($filename){
        if(!file_exists($filename)){
            return false;
        }
        
        if(is_file($filename)){
            return unlink($filename);
        }
        $dir = dir($filename);
        while(false !== $entry = $dir->read()){
            if($entry=="." || $entry==".."){
                continue;
            }
            
            $this->deleteDirectory($filename.DS.$entry);
            
        }
        $dir->close();
        return rmdir($filename);
    }
    
    public function bulkDelete($arr){
        foreach($arr as $d){
            if(is_dir(CFactory::getSession()->getSession('cur_path').DS.$d)){
                $this->deleteDirectory(CFactory::getSession()->getSession('cur_path').DS.$d);
            } else {
            unlink(CFactory::getSession()->getSession('cur_path').DS.$d);
        }
        }
        return true;
    }
    
    public function newFolder($data){
        if(!is_dir(CFactory::getSession()->getSession('cur_path').DS.$data)){
        if(mkdir(CFactory::getSession()->getSession('cur_path').DS.$data)){
            return true;
        } else {
            return false;
        }
        } else {
            if(mkdir(CFactory::getSession()->getSession('cur_path').DS.$data."2")){
            return true;
        } else {
            return false;
        }
            
        }
    }
    
    public function open($folder){
        //check if folder is a valid path
        if(is_dir(CFactory::getSession()->getSession('cur_path').DS.$folder)){
            //set current path session
            CFactory::getSession()->setSession('cur_path', CFactory::getSession()->getSession('cur_path').DS.$folder);
            return true;
        } else {
            return false;
        }
    }
    
    public function rename($newname, $oldname,$fileext){
        if($fileext=="Folder") {
        if(rename(CFactory::getSession()->getSession('cur_path').DS.$oldname, CFactory::getSession()->getSession('cur_path').DS.$newname)){
            return true;
        } else {
            return false;
        }
        
        } else {
             if(rename(CFactory::getSession()->getSession('cur_path').DS.$oldname, CFactory::getSession()->getSession('cur_path').DS.$newname.".".$fileext)){
            return true;
        } else {
            return false;
        }
        }
    }
    
    public function copyTo($folder, $files){
        
        //replace 'root' with common user path
        $realpath = array();
        /**
         * echo $realpath[0][0];
        echo "<br/>". $realpath[0][1]();
        die();
         * used a closure for seperating filename and file path to make copying easier...
         */
        foreach($files as $file){
            $realpath[]= array(str_ireplace('root', USER_FILE.CFactory::getUser()->getUser('folder_path'), str_ireplace("/", "\\", $file)),function() use ($file) { $arr = explode("/", $file); return $arr[count($arr)-1]; });
        }
        //call main file copy method
        if($this->copy($folder, $realpath)){
            return true;
        }
        
    }
    
    public function copy($folder, $files){
        $pathtocopy = CFactory::getSession()->getSession('cur_path').DS.$folder;
        foreach($files as $file){
            if(!is_dir($file[0])){
                copy($file[0], $pathtocopy.DS.$file[1]());
            } else {
                //do recursive copying if file is a directory
                $dir = opendir($file[0]);
                @mkdir($pathtocopy.DS.$file[1]());
                while(false !==($file2 = readdir($dir))){
                    if(($file2 != '.') && ($file2 != '..')){
                        if(is_dir($dir.DS.$file2)){
                            //build paths again
                            $realpath2 = array();
                            $scan = scandir($dir.DS.$file2);
                            foreach($scan as $fi){
                                if(($fi != '.') && ($fi != '..')){
                                    $realpath2[] = array($dir.DS.$file2.DS.$fi, function() use($fi) {return $fi;});
                                }
                            }
                            $this->copy($folder.DS.$file[1],$realpath2);
                        } else {
                         
                            copy($file[0].DS.$file2, $pathtocopy.DS.$file[1]().DS.$file2);
                        }
                    }
                }
            } 
        }
        
        return true;
    }
    
}
