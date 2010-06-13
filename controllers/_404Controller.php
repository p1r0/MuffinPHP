<?php
class _404Controller extends Controller 
{
	var $defaultHelpers = array("Html");
	
	public function render($action)
	{
		parent::render($action, false);
	}
}
?>