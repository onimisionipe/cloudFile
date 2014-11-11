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
 * Description of session
 *
 * @author Mathieu Onipe - onimisionipe@gmail.com
 * @version
 * 
 * 
 */
class Session {
    public function __construct() {
        session_start();
        
    }
    public function setSession($field, $val){
        $_SESSION[$field] = $val;
        
    }
     public function getSession($field){
     if(isset($_SESSION[$field])){
         return $_SESSION[$field];
         
     } else {
         return FALSE;
     }
     }
     
    public function checkSession($field){
         if(isset($_SESSION[$field])){
         return TRUE;
         
     } else {
         return FALSE;
     }
         
     }
     
     public function destroySession(){
        session_unset();
        session_destroy();
        $_SESSION = array();
    }
     
}
