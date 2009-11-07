<?php
class AuthFilter extends Filter
{
	
	public function apply($controller, $get)
	{
		if(SessionHelper::hasValue("user"))
		{
			return true;
		}
		
		if(get_class($controller) != "LoginController")
		{
			$http = HelperFactory::getHelper("http");
			
			$http->redirect($http->getControllerUrl(array("controller"=>"Login",
												 "action"=>"index",
												 "params"=>array(base64_encode(APP_PATH.$_SERVER['REQUEST_URI'])))));
			
		}
		else
		{
			return true;
		}
	}
	
}
?>