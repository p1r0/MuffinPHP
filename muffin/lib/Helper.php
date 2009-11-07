<?php
class Helper
{
	protected $controler = null;
	
	public function  startUp(&$controller)
	{
		$this->controler = $controller;
	}
}
?>