<?php

class LoginController extends AppController  
{	
	
	var $helpers = array("Form", "Http");
	
	
	public function indexAction($page)
	{
		if($this->data != null)
		{
			
			$q = Doctrine_Query::create()->from('User u')
				->where('u.username = ?', $this->data['username']);
			
			$user = $q->fetchOne();
			if($user)
			{
				if($user->password == md5($this->data['password']))
				{
					$page = base64_decode($page);
					SessionHelper::setValue('user', $user);
					
					$this->http->redirect($page);
				}
				else
				{
					exit("ERROR DE LOGIN");
				}
			}
			else
			{
				exit("ERROR DE LOGIN");
			}
		}
		
		$this->expose("pageTitle", "Login");
		$this->expose("form", $this->form);
	}
	
	public function logoutAction()
	{
		SessionHelper::deleteValue('user');
		$this->http->redirect(APP_PATH);
	}
	
	
}
?>