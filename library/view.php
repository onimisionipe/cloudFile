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
 * Description of view - base view
 *
 * @author Mathieu Onipe - onimisionipe@gmail.com
 * @version 
 * 
 * 
 */
class View {
    public $data = array();
    public $head = array();
    public $tools = array();
    public $icons = array();
    public $nav;
    
    public function __construct(){
        $this->data['title'] = P_NAME;
        $this->data['title_fancy'] = P_NAME_FANCY;
        $this->data['icon'] = ICON;
        $this->assign("heading", P_NAME_FANCY);
        $this->data['meta-description'] = '';
        $this->data['copyright'] = '&copy '.date(Y).' '.P_NAME. ' '.AUTHOR;
        $this->data['author'] = AUTHOR;
        $this->data['logo'] = HTTP_SERVER.'/images/'.LOGO;
        //default navigation
        $this->nav = ROOT.DS.'views'.DS.'templates'.DS.TEMPLATE.DS.'nav.tpl';
        

        //icons
        $this->icons['mainicon'] = '<link rel="icon" href="'.HTTP_SERVER.'/images/'.ICON.'">';
        
        //head
        $this->head['bootstrapcss'] = '<link rel="stylesheet" href="'.HTTP_SERVER.'/tools/bootstrap/css/bootstrap.min.css"/>';
        $this->head['main'] = '<link rel="stylesheet" href="'.HTTP_SERVER.'/views/templates/default/css/main.css" type="text/css" media="screen" />';
        
//tools
        $this->tools['jquery'] = '<script src ="'.HTTP_SERVER.'/tools/bootstrap/js/jquery.min.js"></script>';
        $this->tools['bootstrap'] = '<script src ="'.HTTP_SERVER.'/tools/bootstrap/js/bootstrap.min.js"> </script>';
                
        //set data for headers, icons and tools
        $this->data['head'] = $this->head;
        $this->data['tools'] = $this->tools;
        $this->data['icons'] = $this->icons;
        
        //set the root link
        $this->data['APP_URL']=HTTP_SERVER;
        
    }
    
    public function assign($field, $val){
        if($field == ''){
            $this->data= $val;
            
        } else {
            $this->data[$field] = $val;
        }
    }
    
    public function setTitle($title){
        $this->data['title'] = $title;
        
    }
    
    public function setHead($val){
        $this->head['head'] = $val;
        $this->data['head'] = $this->head;
                
    }
    //this method overrides the default navigation set by the constructor
    public function setNav($nav){
        $this->nav = $nav;
    }


    
    public function render($view){
        $header = ROOT.DS.'views'.DS.'templates'.DS.TEMPLATE.DS.'header.tpl';
        $nav = $this->nav;
        $footer = ROOT.DS.'views'.DS.'templates'.DS.TEMPLATE.DS.'footer.tpl';
        if(substr($view, -4) == ".tpl"){
            $file = ROOT.DS.'views'.DS.'templates'.DS.TEMPLATE.DS.$view;
        }
        
        ob_start('ob_gzhandler');
        extract($this->data);
        include($header);
        include($nav);
        include($file);
        include($footer);
       return ob_get_flush();
        
    }
}
