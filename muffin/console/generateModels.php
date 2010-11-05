<?php

define("CLASSPATH", realpath(dirname(__FILE__)."/../.."));
define("DOCTRINE_FOLDER", CLASSPATH."/3rdParty/Doctrine-1.1.0/lib");
define("MODELS_FOLDER", CLASSPATH."/models/data_objects");
define("YML_FOLDER", CLASSPATH."/models/yml");

require_once(DOCTRINE_FOLDER.'/Doctrine.php');

require_once(CLASSPATH.'/config/db.conf.php');
spl_autoload_register(array('Doctrine', 'autoload'));
$manager = Doctrine_Manager::getInstance();

$conn = Doctrine_Manager::connection("{$db_conn_type}://{$db_user}:{$db_pass}@{$db_host}/{$db_name}", 'doctrine');

$manager->setAttribute(Doctrine::ATTR_MODEL_LOADING, Doctrine::MODEL_LOADING_CONSERVATIVE);
$conn->setAttribute(Doctrine::ATTR_USE_NATIVE_ENUM, true);

Doctrine::dropDatabases();
Doctrine::createDatabases();
Doctrine::generateModelsFromYaml(YML_FOLDER.'/db.yml', MODELS_FOLDER);
Doctrine::createTablesFromModels(MODELS_FOLDER);


?>