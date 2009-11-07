<?php
class FilterFactory
{
	public static function &getFilter($filter)
	{
		$className = $filter."Filter";
		$class = new $className;
		return $class;
	}	
}
?>