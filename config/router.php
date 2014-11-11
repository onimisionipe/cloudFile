<?php 

//set error reporting
function setLogging() {
    error_reporting(true);
    if(DEV == 1){
    ini_set('display_errors', 'On');
    
    } else {
        ini_set('display_errors', 'Off');
    }
    ini_set('log_errors', 'On');
    ini_set('error_log', ROOT.DS.'logs'.DS.'error.log');
    
}
//class autoloader for autoloading classes without need for including them manually
function __autoload($classname){
    if(file_exists(ROOT.DS.'controllers'.DS.  strtolower($classname).'.php')){
        require_once ROOT.DS.'controllers'.DS.strtolower($classname).'.php';
    }else if(file_exists(ROOT.DS.'models'.DS.  strtolower($classname).'.php')){
        require_once ROOT.DS.'models'.DS.strtolower($classname).'.php';
        
    }else if(file_exists(ROOT.DS.'library'.DS.  strtolower($classname).'.php')){
        require_once ROOT.DS.'library'.DS.strtolower($classname).'.php';
        
    } else {
        //class not found error
        
        die("Error: class not found ".$classname);
        
    }
    
}

//Main function
function callHook(){
    global $url;
    
    if(!isset($url)){
        $controllerName = DEFAULT_CONTROLLER;
        $action = DEFAULT_ACTION;
    } else {
        $urlArray = array();
        $urlArray = explode("/", $url);
        
        $controllerName = $urlArray[0];
        $action = (isset($urlArray[1]) && $urlArray[1] != '') ? $urlArray[1] : DEFAULT_ACTION;
    }
    $query1 = (isset($urlArray[2]) && $urlArray[2] != '') ? $urlArray[2] : null;
    $query2 = (isset($urlArray[3]) && $urlArray[3] != '') ? $urlArray[3] : null;
    
    //modify the controller class name to fit naming convention
    
    $class = ucfirst($controllerName).'Controller';
    
    //instantiate class
    if(class_exists($class) && (int)method_exists($class, $action)){
        $controller = new $class;
        $controller->$action($query1, $query2);
    } else {
        die("<strong>'$controllerName.php'</strong> containing class <strong>'$class'</strong> might be missing");
    }
    
    
}
setLogging();
callHook();
