<?php
class ConfigManager
{
	private $debugLevel = 0;
	private $dbConnectionString = "";
	
	private static $instance = null;
	
	private $values = array();
	
	private function __construct()
	{
		
	}
	
	public static function &getInstance()
	{
		if(ConfigManager::$instance == null)
		{
			ConfigManager::$instance = new ConfigManager();
		}
		
		return ConfigManager::$instance;
	}
	
	public function getDebugLevel()
	{
		return $this->debugLevel;
	}
	
	public function setDebugLevel($level)
	{
		$this->debugLevel = $level;
	}
	
	public function getDbConnectionString()
	{
		return $this->dbConnectionString;
	}
	
	public function setDbConnectionString($dbConnectionString)
	{
		$this->dbConnectionString = $dbConnectionString;
	}
	
	public function setValue($key, $value)
	{
		$this->values[$key] = $value;
	}
	
	public function getValue($key)
	{
		return $this->values[$key];
	}
	
	public function valueExists($key)
	{
		return isset($this->values[$key]);	
	}
}
?>