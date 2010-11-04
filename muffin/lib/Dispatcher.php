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
 * Dispatcher interface
 * @author Tabaré Caorsi <tcaorsi@binarysputnik.com>
 *
 */
class Dispatcher
{	
	protected $staticRoutes = array();
	
	function dispatch()
	{
		
	}  	
	
	public function addStaticRoute($alias, $controller, $action='')
	{
		$this->staticRoutes[$alias] = array('controller'=>$controller, 'action'=>$action); 
	}
	
	protected function getCotrollerByAlias($alias)
	{
		if(!isset($this->staticRoutes[$alias]))
		{
			return false;
		}
		else
		{
			return $this->staticRoutes[$alias];
		}
	}
}
?>