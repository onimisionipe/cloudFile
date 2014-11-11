<?php

define('DS', DIRECTORY_SEPARATOR);
define('SITE','cloudfile');
define('ROOT', dirname(dirname(__FILE__)).DS.SITE);


$url = isset($_GET['url']) ? $_GET['url'] : NULL;

//call init(config file) and our router
require_once(ROOT.DS.'config'.DS.'init.php');
require_once(ROOT.DS.'config'.DS.'router.php');
