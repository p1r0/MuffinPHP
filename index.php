<?php

	include (realpath(dirname(__FILE__)."/config/conf.php"));
	
	$helper = HelperFactory::getHelper("Http");
	
	$conf = $helper->parseGet($_GET);
	
	try
	{
		$controller = ControllerFactory::getController($conf["controller"]);
		$controller->applyFilters();
		$action =  $conf["action"]."Action";
		$controller->startUp($conf);
		call_user_func_array(array($controller, $action), $conf["param"]);
		$controller->render($conf["action"]);
	}
	catch (Exception  $e)
	{
		$controller = ControllerFactory::getController("_404");
		$controller->startUp();
		$controller->render("index");
	}

	

	
?>
