<?php
/**
 * 
 *  Copyright 2009 BinarySputnik Co - http://binarysputnik.com
 * 
 * 
 *  This file is part of MuffinPHP.
 *
 *  MuffinPHP is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Lesser General Public License as published by
 *  the Free Software Foundation, version 3 of the License.
 *
 *  MuffinPHP is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Lesser General Public License for more details.
 *
 *  You should have received a copy of the GNU Lesser General Public License
 *  along with Foobar.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

/**
 * Singleton class to handle the runtime configuration of 
 * the site.
 * 
 * @author Tabaré Caorsi <tcaorsi@binarysputnik.com>
 *
 */
class ConfigManager
{
	private $debugLevel = 0;
	private $dbConnectionString = "";
	
	private static $instance = null;
	
	private $values = array();
	
	private function __construct()
	{
		
	}
	/**
	 * Get the current instance of the ConfigManager or a new one if there is no
	 * instance alive.
	 * @return ConfigManager
	 */
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