<?php
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