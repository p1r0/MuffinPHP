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
class I18nHelper extends Helper
{
	protected $translationArray = array();
	protected $translationKeys = array();
	
	public static $instance = null;
	
	public static function &getInstance()
	{
		if(I18nHelper::$instance == null)
		{
			I18nHelper::$instance = new I18nHelper();
		}
		
		return I18nHelper::$instance;
	}
	
	protected function __construct()
	{
		
	}
	
	protected function loadTranslationArray()
	{
		if(isset($this->translationArray[1]))
		{
			if(is_array($this->translationArray[1]))
			{
				foreach($this->translationArray[1] as $val)
				{
					$this->translationKeys[$val["msgid"]] = $val["msgstr"];
				}
			}
		}
	}
	
	public function loadPoFile($fileName)
	{
		$parser = new POParser();
		try
		{
			$this->translationArray = $parser->parse($fileName);
			$this->loadTranslationArray();
		}
		catch(Exception $e)
		{
			$this->translationArray = array();
		}
	}
	
	public function tr($string)
	{
		if(isset($this->translationKeys[$string]) && $this->translationKeys[$string] != "")
		{
			return $this->translationKeys[$string];
		}
		else
		{
			return $string;
		}
	}
}
?>