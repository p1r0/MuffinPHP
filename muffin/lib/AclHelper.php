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
class AclHelper extends Helper
{
	public function getModulesList()
	{
		$ann = HelperFactory::getHelper("Annotations");
		
		$ctls = $this->getControllers();
		print "<pre>";
		foreach($ctls as $controller)
		{
			
			$rc = new ReflectionClass($controller);    
			$annotations = $ann->parse($rc->getDocComment());	
			if($annotations !== false)
			{
				if(isset($annotations["@useAcl"]) && $annotations["@useAcl"] == "true")
				{
					echo $this->getModuleName($controller, $annotations);				
					$this->getControllerActions($controller);	
				}
			}
		}
		
	}	
	
	public function getControllerActions($controller)
	{
		$rc = new ReflectionClass($controller);  
		$methods = $rc->getMethods();
		
		if(is_array($methods))
		{
			foreach($methods as $method)
			{
				if(substr($method->getName(), -strlen("Action")) == "Action")
				echo $method->getName();
			}
		}
	}
	
	
	
	
	protected function getControllers()
	{
		$controllers = array();
		
		$dir = dir(CLASSPATH."/controllers");
		
		while (($file = $dir->read()) !== false)
		{
			if(substr($file, -4) == ".php")
			{
				$controllers[] = str_replace(".php", "", $file);	
			}
			
		}
		
		$dir->close();
		
		return $controllers;
	}
	
	protected function getModuleName($module, $annotations)
	{
		if(isset($annotations["@aclFriendlyName"]))
		{
			return $annotations["@aclFriendlyName"];					
		}
		else
		{
			return str_replace("Controller", "", $module);
		}
	}
}
?>