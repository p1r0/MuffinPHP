<?php
/**
 * Factory de Helpers
 *
 */
class HelperFactory
{
	/**
	 * Devuelve una instancia del helper pedido.
	 *
	 * @param String $helper el nombre del Helper sin la palabra Helper.
	 * @return Helper Una instancia del helper pedido.
	 */
	public static function &getHelper($helper)
	{
		$className = $helper."Helper";
		$class = new $className;
		return $class;
	}	
}
?>