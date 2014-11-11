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
 * Description of loginModel
 *
 * @author Mathieu Onipe - onimisionipe@gmail.com
 * @version
 * 
 * 
 */
class registerModel extends Model{
    private $fullname;
    private $location;
    private $email;
    private $password;
    private $password_encode;
    public function __construct() {
        parent::__construct();
        
        $this->email= htmlspecialchars($_POST['email']);
        $this->password = md5(htmlspecialchars($_POST['password']));
        $this->location= htmlspecialchars($_POST['location']);
        $this->fullname= htmlspecialchars($_POST['fullname']);
        $this->password_encode= base64_encode(htmlspecialchars($_POST['password']));
       
        
    }
    public function doRegister(){
        $q = $this->doQuery();
        
        //check for unique email
        $stmt = $q->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->bindParam(':email', $this->email);
                
        $stmt->execute();
        if($stmt->rowCount()==1){
            return false;
        }
         $q2 = $this->doQuery();
        $stmt2 = $q2->prepare("INSERT INTO users(fullname, email, password, password_encode, location, group_id, folder_path, last_login) VALUES(:fullname, :email, :password, :password_encode, :location, :group_id, :folder_path, :last_login)");
        $stmt2->execute(array(':fullname'=>$this->fullname, ':email'=>$this->email, ':password'=>$this->password, ':password_encode'=>$this->password_encode, ':location'=>$this->location, ':group_id'=>2, ':folder_path'=>$this->generateFolderPath(), ':last_login'=>'never'));
         return true;       
        
    }
    
    public function generateFolderPath(){
        //create an md5 hash as folder path for users
        $first = $this->email;
        $second = SECRET;
        $build = md5($first.$second);
        
        if(mkdir(USER_FILE.$build)){        
        return $build;
    } else {
        if(DEV==1){
            die("error creating user root folder");
        }
    }
    }
}
