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
 * Description of index
 *
 * @author Adeola Mathieu Onipe - onimisionipe@gmail.com
 * @version
 * 
 * 
 */
class indexController extends Controller{
    
    public function __construct() {
        parent::__construct();
    }


    public function index(){
        $user = CFactory::getUser();
        if($user->getUser('email')){
            $this->assign('logout', 'Logout');
            $this->assign('logoutlink', HTTP_SERVER.'/logout');
            $this->assign('filemgr', HTTP_SERVER.'/file');
            $this->assign('filelink', 'My Files');
            $this->assign('welcome', 'Hi! '. $user->getUser('fullname'));
            $this->setTitle('Hey '. $user->getUser('fullname').' - '.P_NAME);
            $this->setNav(ROOT.DS.'views'.DS.'templates'.DS.TEMPLATE.DS.'nav-home.tpl');
        }
        $arr = array(25, 'developer', 'merlin - second class');
        
        
        $this->assign("somecontent","Some Cool Music the 100 has got");
        $this->assign('details', $arr);
        $this->setNav(ROOT.DS.'views'.DS.'templates'.DS.TEMPLATE.DS.'nav-home.tpl');
        $this->loadView("index.tpl");
        
        
    }
    
    
}
?>