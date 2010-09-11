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
 * 
 * @author Tabaré Caorsi <tcaorsi@binarysputnik.com>
 *
 */
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
	
	public static function deleteSession()
	{
		unset($_SESSION[APP_NAME]); 
	}
}
?>