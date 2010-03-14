<?php
class AclHelper extends Helper
{
	public function getModulesList()
	{
		$arModules = array();
		$ann = HelperFactory::getHelper("Annotations");
		
		$ctls = $this->getControllers();

		foreach($ctls as $controller)
		{
			
			$rc = new ReflectionClass($controller);    
			$annotations = $ann->parse($rc->getDocComment());	
			if($annotations !== false)
			{
				if(isset($annotations["@useAcl"]) && $annotations["@useAcl"] == "true")
				{	
					$data = array("name"=>$rc->getName(),
								  "friendlyName"=>$this->getModuleName($rc->getName(), $annotations), 
								  "methods"=>$this->getControllerActions($controller));
					$arModules[$rc->getName()] = $data; 			
				}
			}
		}
		
		return $arModules;
	}	
	
	public function getControllerActions($controller)
	{
		$arMethods = array();
		$ann = HelperFactory::getHelper("Annotations");
		$rc = new ReflectionClass($controller);  
		$methods = $rc->getMethods();
		
		if(is_array($methods))
		{
			foreach($methods as $method)
			{
				if(substr($method->getName(), -strlen("Action")) == "Action")
				{
					$annotations = $ann->parse($method->getDocComment());
					$data = array();
					if($annotations !== false)
					{
						if(isset($annotations["@useAcl"]) && $annotations["@useAcl"] != "false")
						{			
							$data["friendlyName"] = $this->getMethodName($method->getName(), $annotations);
							$data["name"] =	$method->getName();
							$arMethods[$method->getName()] = $data; 	
						}
						else if(!isset($annotations["@useAcl"]))
						{
							$data["friendlyName"] = $this->getMethodName($method->getName(), $annotations);
							$data["name"] =	$method->getName();
							$arMethods[$method->getName()] = $data;
						}
					}
					else
					{
						$data["friendlyName"] = $this->getMethodName($method->getName(), $annotations);
						$data["name"] =	$method->getName();
						$arMethods[$method->getName()] = $data;
					}
				}
			}
		}
		
		return $arMethods;
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
	
	protected function getMethodName($module, $annotations)
	{
		if(isset($annotations["@aclFriendlyName"]))
		{
			return $annotations["@aclFriendlyName"];					
		}
		else
		{
			return str_replace("Action", "", $module);
		}
	}
}
?>