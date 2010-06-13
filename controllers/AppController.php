<?php
class AppController extends Controller 
{
	var $defaultHelpers = array('Html');
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function preview()
	{
		$this->expose("html", $this->html);	
	}
}
?>
