<?php

define("CLASSPATH", realpath(dirname(__FILE__)."/../.."));
define("DOCTRINE_FOLDER", CLASSPATH."/3rdParty/Doctrine-1.1.0/lib");
define("MODELS_FOLDER", CLASSPATH."/models");
define("CONTROLLERS_FOLDER", CLASSPATH."/controllers");
define("VIEWS_FOLDER", CLASSPATH."/views");

require_once(DOCTRINE_FOLDER.'/Doctrine.php');

require_once(CLASSPATH.'/config/db.conf.php');

require_once('CRUD/ControllerCreator.php');
require_once('CRUD/ViewCreator.php');

spl_autoload_register(array('Doctrine', 'autoload'));
$manager = Doctrine_Manager::getInstance();

$conn = Doctrine_Manager::connection("{$db_conn_type}://{$db_user}:{$db_pass}@{$db_host}/{$db_name}", 'doctrine');

$manager->setAttribute(Doctrine::ATTR_MODEL_LOADING, Doctrine::MODEL_LOADING_CONSERVATIVE);
Doctrine::loadModels(MODELS_FOLDER);
$modelName = $argv[1];

$table = Doctrine::getTable($modelName);

$columns = $table->getColumns();
$colName = $table->getColumnNames();
/*foreach ($columns as $column)
{
    print_r($column);
}

exit();*/

$controllerCreator = new ControllerCreator($columns, $modelName);
$controllerCreator->create(); 

$viewCreator = new ViewCreator($columns, $modelName);
$viewCreator->create();

?>