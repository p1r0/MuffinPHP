<?php
class _404Controller extends AppController 
{
	
	public function indexAction()
	{
		$this->preview();
		
		$this->expose("pageTitle", "404");
	}
	
	
}
?>