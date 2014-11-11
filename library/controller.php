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
 * Description of Controller  - Base Controller class. Other controllers will derive from this
 *
 * @author Mathieu Onipe - onimisionipe@gmail.com
 * @version
 * 
 * 
 */
class Controller {
    protected $view;
    protected $model;
    protected $view_name;
    
    /*
     * 
     */
    public function __construct(){
        $this->view_name = '';
        $this->view = new View();
        
    }
    /*
     * This method assigns data to the view
     * 
     */
    
    public function assign($field, $val) {
        $this->view->assign($field,$val);
        
    }
    
    public function setHead($val){
         $this->view->setHead($val);
    }
    
    public function setTitle($val){
         $this->view->setTitle($val);
    }
    
    public function loadModel($model) {
        $modelName = $model.'Model';
        return new $modelName;
        
    }
    
    public function setNav($nav){
        $this->view->setNav($nav);
    }
    
    public function loadView($view){
        if(file_exists(ROOT.DS.'views'.DS.'templates'.DS.TEMPLATE.DS.$view)){
            $this->view_name = $view;
        }
    }
    
    public function __destruct() {
        if(!empty($this->view_name)){
            $this->view->render($this->view_name);
        }
    }
    
}
?>