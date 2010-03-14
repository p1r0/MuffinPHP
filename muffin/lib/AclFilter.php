<?php
class AclFilter extends Filter
{
	public function apply($controller, $get, $action = null)
	{
		if(SessionHelper::hasValue("user"))
		{
			$aclIo = AclIo::getInstance();
			$user = SessionHelper::getValue("user");
			$aclIo->load($user->id);
			$acl = HelperFactory::getHelper("Acl");
			$modules = $acl->getModulesList();
			
			if(isset($modules[get_class($controller)]) && isset($modules[get_class($controller)]["methods"][$action]))
			{
				$authorized = false;
				foreach($aclIo->permissions as $permission)
				{
					if($permission["controller"] == get_class($controller) && 
					   $permission["method"] == $action)
					{
						$authorized = true;
						break;
					}
				}
				
				if(!$authorized)
				{
					$http = HelperFactory::getHelper("http");
			
					$url = $http->getControllerUrl(array("controller"=>"Acl",
														 "action"=>"error"));
					
					header("Location: $url");
					exit();	
				}
			}
			
			return true;
		}
		
		return true;
	}	
}
?>