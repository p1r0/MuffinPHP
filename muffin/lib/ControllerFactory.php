<?php
/**
 * Factory de controladores
 *
 */
class ControllerFactory
{
	/**
	 * Devuelve una instancia del controlador pedido.
	 *
	 * @param String $controller el nombre del Controlador sin la palabra Controller.
	 * @return Controller Una instancia del controlador pedido.
	 */
	public static function &getController($controller)
	{
		$className = $controller."Controller";
		$class = new $className;
		return $class;
	}	
}
?>