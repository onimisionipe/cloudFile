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
 * Description of model - base Model
 *
 * @author Mathieu Onipe - onimisionipe@gmail.com
 * @version 
 * mysql:host=localhost;dbname=testdb;charset=utf8'
 * 
 * 
 */
class Model {
    protected $dsn;
    protected $db;
    
    public function __construct(){
        $this->dsn = 'mysql:host='.DB_SERVER.';dbname='.DB.';charset='.DB_CHARSET;
        
     }
     public function connectDB() {
         try{
             $this->db = new PDO($this->dsn, DB_USER, DB_PASSWD);
             $this->db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
         return $this->db;
             
         } catch (PDOException $ex) {
             if(DEV==1){
                die($ex);
              }
             
         }
         
         
     }
     
      function doQuery(){
          $q = $this->connectDB();
          return $q;        
          
     
}


}