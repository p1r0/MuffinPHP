<?php
/**
 * Helper to handle Java style annotations in the code.
 * 
 * @author pyro
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