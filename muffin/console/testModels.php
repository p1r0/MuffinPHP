<?php

define("CLASSPATH", realpath(dirname(__FILE__)."/../.."));
define("DOCTRINE_FOLDER", CLASSPATH."/3rdParty/Doctrine-1.1.0/lib");
define("MODELS_FOLDER", CLASSPATH."/models");

require_once(DOCTRINE_FOLDER.'/Doctrine.php');

spl_autoload_register(array('Doctrine', 'autoload'));
$manager = Doctrine_Manager::getInstance();

$conn = Doctrine_Manager::connection('mysql://root:1234@localhost/demo', 'doctrine');

$manager->setAttribute(Doctrine::ATTR_MODEL_LOADING, Doctrine::MODEL_LOADING_CONSERVATIVE);

Doctrine::loadModels(MODELS_FOLDER);

$user = new User();
$user->username = 'test';
$user->password = '1234';
$user->save();

?>