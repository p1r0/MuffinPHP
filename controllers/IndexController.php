<?php

class IndexController extends AppController  
{	
	public function indexAction()
	{
		parent::indexAction();
		
		$this->expose("pageTitle", "Inicio");
	}
}
?>