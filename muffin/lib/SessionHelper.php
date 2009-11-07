<?php
class SessionHelper extends Helper
{
	public static function getValue($key)
	{
		if(isset($_SESSION[APP_NAME][$key]))
		{
			return $_SESSION[APP_NAME][$key]; 
		}
		else
		{
			throw new Exception("Session value not found for key '$key'");
		}
	}
	
	public static function hasValue($key)
	{
		return isset($_SESSION[APP_NAME][$key]);
	}
	
	public static function setValue($key, $value)
	{
		$_SESSION[APP_NAME][$key] = $value;
	}
	
	public static function deleteValue($key)
	{
		if(isset($_SESSION[APP_NAME][$key]))
		{
			unset($_SESSION[APP_NAME][$key]); 
		}
		else
		{
			throw new Exception("Session value not found for key '$key'");
		}
	}
}
?>