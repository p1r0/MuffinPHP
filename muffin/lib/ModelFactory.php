<?php
/**
 * Factory de Modelos
 *
 */
class ModelFactory
{
	/**
	 * Devuelve una instancia del modelo pedido.
	 *
	 * @param String $model el nombre del Medelo sin la palabra Model.
	 * @return Model Una instancia del modelo pedido.
	 */
	public static function &getModel($model)
	{
		$className = $model."Model";
		$class = new $className;
		return $class;
	}
}
?>