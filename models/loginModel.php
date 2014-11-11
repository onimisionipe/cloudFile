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
 * @version 1.1
 * 
 * 
 */
class loginModel extends Model{
    private $email;
    private $password;
    public function __construct() {
        parent::__construct();
        
        $this->email= htmlspecialchars($_POST['email']);
        $this->password = md5(htmlspecialchars($_POST['password']));
        
       
        
    }
    public function doLogin(){
        $q = $this->doQuery();
        $stmt = $q->prepare('SELECT * FROM users WHERE email = :email AND password = :pass');
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':pass', $this->password);
        
        $stmt->execute();
        if($stmt->rowCount()==1){
          $res = $stmt->fetchAll();
          
          $sess = CFactory::getUser();
          
          $sess->setUser($res);
          CFactory::getSession()->setSession('expire', time()+EXPIRE*60);
          
          //update last login
          
          $q2 = $this->doQuery();
          $stmt2 = $q2->prepare('UPDATE users SET last_login = NOW() WHERE user_id = :user_id');
          $stmt2->bindParam(':user_id', $sess->getUser('user_id'));
          $stmt2->execute();
           
          //redirect after successful log in
           return true;      
          
        } else {
                        
            return false;
        }   
        
        
    }
}
