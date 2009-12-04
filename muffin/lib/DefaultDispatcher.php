<?php
class DefaultDispatcher extends Dispatcher
{
	public function dispatch()
	{
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
		catch (Doctrine_Connection_Exception  $e)
		{
			ErrorHandler::displayError("Found a Doctrine connection error.<br>
									 	Make suere that you have started the Doctrine
									 	subsystem.<br>");
		}
		/*catch (Exception  $e)
		{
			
			
			$controller = ControllerFactory::getController("_404");
			$controller->startUp();
			$controller->render("index");
		}*/
		
	}
}
?>