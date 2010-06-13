<?php
	include (realpath(dirname(__FILE__)."/config/conf.php"));

	$dispatcher = new DefaultDispatcher();
	$dispatcher->dispatch();
	
?>
