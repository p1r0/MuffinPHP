<?php
class _404Controller extends Controller 
{
	var $defaultHelpers = array("Html", "Mesas");
	
	public function render($action)
	{
		parent::render($action, false);
	}
}
?>