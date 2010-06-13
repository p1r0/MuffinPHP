<?php

class IndexController extends AppController  
{	
	public function indexAction()
	{
		$this->preview();
				
		$this->expose("pageTitle", tr("New App Home Page!"));

	}
}
?>
