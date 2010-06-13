<?php
	/**
	 * NOTE: If you are going to use a database MuffinPHP uses Doctrine and you should
	 * add doctrin to the third party folder.
 	 */

	//For Doctrine. Uncomment if you use a DataBase.
	//require realpath(dirname(__FILE__))."/db.conf.php"; 

	//We define all constants needed by MuffinPHP
	
	define("DEBUG_LEVEL", 2);

	define("PROTOCOL", isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on" ? 'https://' : 'http://');
	define("APP_NAME", "MUFFIN APP (CHANGE THIS!)");
	define("CLASSPATH", realpath(dirname(__FILE__)."/.."));
	define("APP_ROOT", PROTOCOL.$_SERVER["HTTP_HOST"]);
        define("APP_PATH", APP_ROOT."");
	define("RESOURCES_PATH", APP_PATH."/resources");
	define("IMGS_PATH", RESOURCES_PATH."/images");
	define("CSS_PATH", RESOURCES_PATH."/css");
	define("JS_PATH", RESOURCES_PATH."/js");
	define("FLASH_PATH", RESOURCES_PATH."/flash");
	define("OTHER_PATH", RESOURCES_PATH."/other");
	define("FW_ROOT", realpath(dirname(__FILE__)."/../muffin/lib"));
	define("MOD_REWRITE", true);
	define("I18N_PATH", CLASSPATH."/i18n");

	//For Doctrine. Uncomment if you use a DataBase.
	/*
	if(!defined("DOCTRINE_FOLDER"))
	{
		define("DOCTRINE_FOLDER", CLASSPATH."/3rdParty/Doctrine-1.1.0/lib");
	}
	*/
	
	//Mandatory includes for MuffinPHP
	set_include_path(get_include_path() . PATH_SEPARATOR . FW_ROOT);
	set_include_path(get_include_path() . PATH_SEPARATOR . FW_ROOT."/Exceptions");
	set_include_path(get_include_path() . PATH_SEPARATOR . CLASSPATH."/controllers");
	set_include_path(get_include_path() . PATH_SEPARATOR . CLASSPATH."/helpers");
	set_include_path(get_include_path() . PATH_SEPARATOR . CLASSPATH."/managers");
	set_include_path(get_include_path() . PATH_SEPARATOR . CLASSPATH."/components");
	set_include_path(get_include_path() . PATH_SEPARATOR . CLASSPATH."/filters");
	set_include_path(get_include_path() . PATH_SEPARATOR . CLASSPATH."/dispatchers");
	//For Doctrine. Uncomment if you use a DataBase.
	//set_include_path(get_include_path() . PATH_SEPARATOR . CLASSPATH."/models");

	//Some extra useful includes - You can uncomment the ones you need or add new ones
	//set_include_path(get_include_path() . PATH_SEPARATOR . CLASSPATH."/components/plogger"); //Logger class
	//set_include_path(get_include_path() . PATH_SEPARATOR . CLASSPATH."/components/phpMailer_v2.3"); //PHP Mailer

	//Doctrine include. Uncomment if you use a DataBase.
	//require_once(DOCTRINE_FOLDER.'/Doctrine.php');

	//This is used for class loading DO NOT REMOVE!!
	require_once('FileSystem.php');
	
	//Autoloaders registrations

	//For Doctrine. Uncomment if you use a DataBase.
	//spl_autoload_register(array('Doctrine', 'autoload'));
	spl_autoload_register(array('FileSystem', 'autoload'));
	
	//For Doctrine. Uncomment if you use a DataBase.
	//Doctrine configuration. This works fine for most projects but you can change it as needed to suit your needs
	/*$con = Doctrine_Manager::connection("{$db_conn_type}://{$db_user}:{$db_pass}@{$db_host}/{$db_name}");
	Doctrine_Manager::getInstance()->setAttribute(Doctrine::ATTR_MODEL_LOADING, Doctrine::MODEL_LOADING_CONSERVATIVE);
	$con->setCharset('utf8');
	$con->setAttribute(Doctrine::ATTR_USE_NATIVE_ENUM, true);
	
	Doctrine::loadModels(CLASSPATH.'/models');
	*/
	$configManager = ConfigManager::getInstance();
	$configManager->setDebugLevel(2);
	
	session_start();
?>
