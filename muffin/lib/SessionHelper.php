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
 * The SessionHelper is used to manage session values with muffin
 * @author Tabaré Caorsi <tcaorsi@binarysputnik.com>
 * @package MuffinPHP
 * @subpackage Helpers
 */
class SessionHelper extends Helper
{
    /**
     * Returns a value stored in the session identified
     * by $key
     * @param string $key the key of the value to be retrieved
     * @return the value of the key
     * @throws Generic not found Exception
     */
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
	
    /**
     * Returns a true if the value for $key exists in session
     * @param string $key the key of the value to be checked
     * @return boolean
     */
	public static function hasValue($key)
	{
		return isset($_SESSION[APP_NAME][$key]);
	}
	
    /**
     * Sets a value in the session
     * @param string $key the key of the value to be set
     * @param $value the value to be set
     */
	public static function setValue($key, $value)
	{
		$_SESSION[APP_NAME][$key] = $value;
	}
	
    /**
     * Removes a value from the session identified by $key
     * @param string $key the key of the value to be removed
     * @throws Generic not found Exception
     */
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
	
    /**
     * Deletes all values fro the session
     */
	public static function deleteSession()
	{
		unset($_SESSION[APP_NAME]); 
	}
}
?>