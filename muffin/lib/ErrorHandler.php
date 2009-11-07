<?php
class ErrorHandler
{
	public static function handleError($errno, $errstr, $errfile, $errline)
	{
		echo "<b>My ERROR</b> [$errno] $errstr<br />\n";
        echo "  Fatal error on line $errline in file $errfile";
        echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
        echo "Aborting...<br />\n";
        echo "<pre>";
        debug_print_backtrace();
        exit(1);
	}
	
	public static function displayError($errorStr)
	{
		echo $errorStr;
		echo "Here you have the backtrace: <br><pre>";
		debug_print_backtrace();
		exit(1);
	}
}
?>