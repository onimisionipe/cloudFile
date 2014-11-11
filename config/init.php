<?php
//HTTPS 
define('HTTPS_SERVER', 'https://localhost/cloudfile');

//HTTP
define('HTTP_SERVER', 'http://localhost/cloudfile');

//tools like bootstrap etc
define('TOOLS', ROOT.DS.'tools'.DS);

//admin email
define('ADMIN_EMAIL', 'onimisionipe@gmail.com');

//images
define('IMG', ROOT.DS.'images'.DS);

//user root folder
define('USER_FILE', ROOT.DS.'userfile'.DS);

//Project name
define('P_NAME', 'CloudFile');

//Project name
define('P_NAME_FANCY', '<span class="subh">Cloud</span>File');

//author
define('AUTHOR', 'Mathieu Onimisi Onipe');

//project logo
define('LOGO','logo.png');

//project icon
define('ICON','icon.png');

//default controller
define('DEFAULT_CONTROLLER', 'index');

//Default action - for MVC, this is the default method
define('DEFAULT_ACTION', 'index');

//template - set template configuration here..
define('TEMPLATE', 'default');

//development or production flag
define('DEV',1);

//default quota - in Megabyte
define('QUOTA', 50);

//max session time
define('EXPIRE', 5);

define('SECRET', 'bea680ec97e01ec076cd351078514f9f');
//DATABASE CONFIGS

define('DB', 'cloudfile');
define('DB_SERVER', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWD', '');
define('DB_CHARSET', 'utf8');
        