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
class recoverModel extends Model{
    
    private $email;
    
    public function __construct() {
        parent::__construct();
        
        $this->email= htmlspecialchars($_POST['email']);
       
    }
    public function doRegister(){
        $q = $this->doQuery();
        
        //check for unique email
        $stmt = $q->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->bindParam(':email', $this->email);
                
        $stmt->execute();
        if($stmt->rowCount()==1){
            $result = $stmt->fetchAll();
            $to = $result[0]['email'];
            $fullname = $result[0]['fullname'];
            $password = base64_decode($result[0]['password_encode']);
            $body = "<p>Hello ".$fullname." <br/> Here is your password. please you are advised to delete this email because of security risk<br/><br/> password: ".$password."</p>";
        
            //send email
            $mail = new Email($to, $body);
            $mail->prepareEmail();
            $mail->send();
            
            return true;
        } else {
            return false;
            }
                 
        
    }
    
    
}
