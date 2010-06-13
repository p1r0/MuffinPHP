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
class AjaxHelper extends Helper
{
	public function html2UnicodeJsString($string)
	{
		$in = array("&aacute;", "&eacute;", "&iacute;", "&oacute;", "&uacute;", "&ntilde;",
					"&Aacute;", "&Eacute;", "&Iacute;", "&Oacute;", "&Uacute;", "&Ntilde;");

		$out = array("\u00e1", "\u00e9", "\u00ed", "\u00f3", "\u00fa", "\u00f1",
					 "\u00c1", "\u00c9", "\u00cd", "\u00d3", "\u00da", "\u00d1");
		
		return str_replace($in, $out, $string);
	}
	
	public function getJson($obj)
	{
		if(is_array($obj))
		{
			foreach($obj as $key => $value)
			{
				if(is_string($value))
				{
					$obj[$key] = $this->html2UnicodeJsString($value);	
				}
			}
		}
		else
		{
			$obj = $this->html2UnicodeJsString($obj);
		}
		
		//return str_replace("\\\\", "\\", json_encode($obj));
		return json_encode($obj);
	}
}
?>