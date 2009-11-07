<?php

/**
 * Representa un Modelo
 *
 */
class Model
{
	protected $lastError = "";
	protected $logger;
	protected $validations = null;
	
	/**
	 * Constructor
	 *
	 */
	public function __construct()
	{
		$this->logger = new Logger(get_class($this));
		//Los models
		if(isset($this->defaultUses))
		{
			foreach($this->defaultUses as $model)
			{
				$varName = $model;
				$varName[0] = strtolower($varName[0]);
				$this->$varName = ModelFactory::getModel($model);
			}
		}
		
		if(isset($this->uses))
		{
			foreach($this->uses as $model)
			{
				$varName = $model;
				$varName[0] = strtolower($varName[0]);
				$this->$varName = ModelFactory::getModel($model);
			}
		}
	}
	
	/**
	 * Busca y trae todos los registros de la tabla asociada
	 * al modelo.
	 *
	 * Ejemplo;
	 * <code>
	 * $modelo->findAll(array("conditions"=>" id = 1", "order" => "title"));
	 * </code>
	 * 
	 * @param Array $options Las opciones disponibles son "contitions" y "order".
	 * 				<br>La primera es para usar como WHERE y la segunda como ORDER BY.
	 * @return Array Todos los registros de la tabla con sus valores, 
	 * 				 indexado por el nombre de la columna
	 * 
	 * 
	 */
	public function findAll($options = null)
	{
		$ret = array();
		
		$table = isset($this->table) ? $this->table : str_replace("Model", "", get_class($this));
		$sql = isset($this->sql) ? $this->sql : "select * from $table where 1  = 1  ";
		
		if(isset($options["conditions"]))
		{
			$sql .= " and ".$options["conditions"];
		}
		
		if(isset($options["order"]))
		{
			$sql .= " order by ".$options["order"];
		}
		
		if(isset($options["limit"]))
		{
			$sql .= " limit ".$options["limit"];
		}
		
		$this->logger->debug($sql);
		
	//print "<br>SQL: ".$sql."<br>";
		
		$con = $_SESSION[APP_NAME]["conn"];
		$Conn1 = $con->abrirconexion();
		
		$rs = &$Conn1->Execute($sql);
		$con->matarconexion($Conn1->_resultid);
		
		if(!$rs)
		{
			$ret = null;
			//exit("SQL; ".$sql);
		}
		else
		{
			if($rs->RecordCount() > 0)
			{
				$ret = array();
				$rs->moveFirst();
				while(!$rs->EOF)
				{
					$ret[] = $rs->fields;
					$rs->moveNext();
				}
			}
		}
		
		return $ret;
	}
	
	public function count($options)
	{
		$table = isset($this->table) ? $this->table : str_replace("Model", "", get_class($this));
		$sql = "select count(*) as count from {$table} where 1 = 1";

		if(isset($options["conditions"]))
		{
			$sql .= " and ".$options["conditions"];
		}
		
		$this->logger->debug("SQL: ", $sql);
		
		//print "<br>SQL: ".$sql."<br>";
		
		$con = $_SESSION[APP_NAME]["conn"];
		$Conn1 = $con->abrirconexion();
		
		$rs = &$Conn1->Execute($sql);
		$con->matarconexion($Conn1->_resultid);
		
		if(!$rs)
		{
			$ret = null;
			//exit("SQL; ".$sql);
		}
		else
		{
			if($rs->RecordCount() > 0)
			{
				$ret = array();
				$rs->moveFirst();
				$ret = $rs->fields["count"];
			}
		}
		
		return $ret;
	}
	
	public function save($data)
	{
		throw new Exception("Not yet implemented. Must be implemented in child classes.");
	}
	
	public function validate($data, &$errors)
	{
		$errors = array();
		
		if($this->validations != null)
		{
			foreach($data as $key => $value)
			{
				if(isset($this->validations[$key]))
				{
					if(strtolower($this->validations[$key]) == "notnull")
					{
						if(!$this->validateNotNull($value))
						{
							$errors[$key] = $this->formatLabel($key)." no puede ser vac&iacute;o.";
						}
					}
				}
			}	
		}
		
		return count($errors)>0 ? false : true;
	}
	
	protected function validateNotNull($val)
	{
		if(trim($val) == "")
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	protected function formatLabel($name)
	{
		/* @TODO Revisar esto. Mover a un helper */
		$label = "";
		
		$arPalabreas = split("_", $name);
		
		foreach($arPalabreas as $palabra)
		{
			if($label != "")
			{
				$label .= " ";
			}
			
			$palabra[0] = strtoupper($palabra[0]);  
			$label .= $palabra;
		}
		
		return "&quot;".$label."&quot;";
	}
	
	public function getLastError()
	{
		return $this->lastError;
	}
	
	protected function setLastError($errMsg)
	{
		$this->lastError = $errMsg;
	}
}

?>