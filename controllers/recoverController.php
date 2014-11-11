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
 * @author Mathieu Onipe - onimisionipe@gmail.com
 * @version
 * 
 * 
 */
class recoverController extends Controller {
    
    public function __construct() {
        parent::__construct();
    }
    
    /*
     * check or validate data...and filter data
     */
    public function index(){
        $user = CFactory::getUser();
        if($user->getUser('email')){
            Redirect::relocate('file');
        }
        $this->setHead('<link rel="stylesheet" href="'.HTTP_SERVER.'/views/templates/default/css/login.css" type="text/css" media="screen" />');
        $this->setTitle(P_NAME.'- Recover Password');
        $this->loadView("recover.tpl");
        
    }
    
    public function recover(){
        if(isset($_POST['email'])){
            foreach($_POST as $key=>$value){
                if(strlen(trim($value))<1){
                    $this->assign('error', 'Please enter a value');
                    $this->setHead('<link rel="stylesheet" href="'.HTTP_SERVER.'/views/templates/default/css/login.css" type="text/css" media="screen" />');
                    $this->setTitle(P_NAME.'- Please enter a value');
                    $this->loadView("recover.tpl");
                } 
            }
                    $result = $this->loadModel('recover');
                    
                    if($result->doRegister()=== true) {
                        $this->assign('success', 'Please Check Your email. Thank you');
                        $this->setHead('<link rel="stylesheet" href="'.HTTP_SERVER.'/views/templates/default/css/login.css" type="text/css" media="screen" />');
                        $this->setTitle(P_NAME.'- Password has been emailed to you');
                        $this->loadView("recover.tpl");                       
                        
                    } else {
                        $this->assign('error', 'Oops! This Email address is not registered with us');
                    $this->setHead('<link rel="stylesheet" href="'.HTTP_SERVER.'/views/templates/default/css/login.css" type="text/css" media="screen" />');
                    $this->setTitle(P_NAME.'- This Email address is not registered with us');
                    $this->loadView("recover.tpl");
                        
                    }
                    
                        
                    
                    
                }
            }
        }
        
    

