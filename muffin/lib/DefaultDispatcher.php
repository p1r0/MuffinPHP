<?php
/**
 * 
 *  Copyright 2009 BinarySputnik Co - http://binarysputnik.com
 * 
 * 
 *  This file is part of MuffinPHP.
 *
 *  MuffinPHP is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Lesser General Public License as published by
 *  the Free Software Foundation, version 3 of the License.
 *
 *  MuffinPHP is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Lesser General Public License for more details.
 *
 *  You should have received a copy of the GNU Lesser General Public License
 *  along with Foobar.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

/**
 * 
 * @author Tabaré Caorsi <tcaorsi@binarysputnik.com>
 *
 */
class DefaultDispatcher extends Dispatcher
{
	public function dispatch()
	{
		$helper = HelperFactory::getHelper("Http");
		$conf = $helper->parseGet($_GET);
		
		try
		{
			$controller = ControllerFactory::getController(ucfirst($conf["controller"]));
			$controller->applyFilters($conf);
			$action =  $conf["action"]."Action";
			$controller->startUp($conf);
			call_user_func_array(array($controller, $action), $conf["param"]);
			$controller->render($conf["action"]);
		}
		catch (Doctrine_Connection_Exception  $e)
		{
			exit($e->getMessage());
			ErrorHandler::displayError("Found a Doctrine connection error.<br>
									 	Make suere that you have started the Doctrine
									 	subsystem.<br>");
		}
		catch (MissingControllerException $e)
		{
			exit("<h1>ERROR</h1><br><h2>Missing Controller</h2>");
		}
		catch (MissingClassException $e)
		{
			exit("<h1>ERROR</h1><br><h2>Missing class</h2>");
		}
		catch (Exception  $e)
		{
			exit($e->getMessage());
			
			$controller = ControllerFactory::getController("_404");
			$controller->startUp();
			$controller->render("index");
		}
		
	}
}
?>