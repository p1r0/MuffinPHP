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
 * Helper to handle Java style annotations in the code.
 * 
 * @author Tabaré Caorsi <tcaorsi@binarysputnik.com>
 *
 */
class AnnotationsHelper extends Helper
{
	/**
	 * Parses a doc comment and extracts all the annontations.
	 * 
	 * @param $docComment String the text to be parsed
	 * @return Array with annotations or false if no annotations were found.
	 */
	public function parse($docComment)
	{
		$annotations = array();
		$ret = array();
		if(preg_match_all("/(@[a-z_]+[0-9]*) ([a-z_0-9 ]*)/i", $docComment, $ret))
		{
			foreach($ret[1] as $key=>$value)
			{
				$annotations[$value] = $ret[2][$key]; 
			}
			
			return $annotations;
		}
		else
		{
			return false;
		}
		
	}
}
?>