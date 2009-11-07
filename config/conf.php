<?php

	require realpath(dirname(__FILE__))."/db.conf.php"; 

	//DEFINO CONSTANTES
	
	define("DEBUG_LEVEL", 2);

	define("APP_NAME", "app_name");
	define("CLASSPATH", realpath(dirname(__FILE__)."/.."));
    define("APP_ROOT", "http://".$_SERVER["HTTP_HOST"]);
    define("APP_PATH", APP_ROOT);
	define("RESOURCES_PATH", APP_PATH."/resources");
	define("IMGS_PATH", RESOURCES_PATH."/images");
	define("CSS_PATH", RESOURCES_PATH."/css");
	define("JS_PATH", RESOURCES_PATH."/js");
	define("FLASH_PATH", RESOURCES_PATH."/flash");
	define("FW_ROOT", realpath(dirname(__FILE__)."/../muffin/lib"));
	define("MOD_REWRITE", true);
	
	if(!defined("DOCTRINE_FOLDER"))
	{
		define("DOCTRINE_FOLDER", CLASSPATH."/3rdParty/Doctrine-1.1.0/lib");
	}
	
	
	//Seteo el include path
	set_include_path(get_include_path() . PATH_SEPARATOR . FW_ROOT);
	set_include_path(get_include_path() . PATH_SEPARATOR . CLASSPATH."/controllers");
	set_include_path(get_include_path() . PATH_SEPARATOR . CLASSPATH."/helpers");
	set_include_path(get_include_path() . PATH_SEPARATOR . CLASSPATH."/managers");
	set_include_path(get_include_path() . PATH_SEPARATOR . CLASSPATH."/models");
	set_include_path(get_include_path() . PATH_SEPARATOR . CLASSPATH."/components");
	set_include_path(get_include_path() . PATH_SEPARATOR . CLASSPATH."/filters");
	set_include_path(get_include_path() . PATH_SEPARATOR . CLASSPATH."/components/plogger");
	set_include_path(get_include_path() . PATH_SEPARATOR . CLASSPATH."/components/phpMailer_v2.3");

	
	require_once(DOCTRINE_FOLDER.'/Doctrine.php');
	
	//Registro el autoloader
	function autoload($class_name) 
	{
		/**
		 * @todo here I use @include to supress an error that occurred
		 * when the system tryied to include session objects from a differnt
		 * app in the same server.
		 */
		
		@include_once ($class_name.'.php');
	}
	spl_autoload_register(array('Doctrine', 'autoload'));
	spl_autoload_register("autoload");
	
	Doctrine_Manager::connection('mysql://root:1234@localhost/demo');
	Doctrine_Manager::getInstance()->setAttribute(Doctrine::ATTR_MODEL_LOADING, 
												  Doctrine::MODEL_LOADING_CONSERVATIVE);
	Doctrine::loadModels(CLASSPATH.'/models');
	
	session_start();
	
?>