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
 * Represents a model.
 *
 */
class Model
{
	protected $lastError = "";
	protected $logger;
	protected $validations = null;
	protected $dataObject = null;
	
	/**
	 * Constructor
	 *
	 */
	public function __construct($dataObject = null)
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
		
		if($dataObject == null)
		{
			$dataObject = str_replace('Model', "", get_class($this));
			$this->dataObject = $dataObject;
		}
		else if($dataObject != "")
		{
			$this->dataObject = $dataObject; 
		}
	}
	
	public function save(array $data)
	{
		if($this->exists($data))
		{
			echo "will update";
		}
		else 
		{
			echo "will insert";
			$this->add($data);
		}
	}
	
	public function add(array $data)
	{
		include_once('data_objects/'.$this->dataObject.'.php');
		$obj = new $this->dataObject();
		
		foreach($data as $key => $value)
		{
			$obj->$key = $value;
		}
		
		$obj->save();
	}
	
	public function update(array $data)
	{
		
	}
	
	public function exists(array $data)
	{
		//if($this->dataObject != null)
		//{
		//	include_once('data_objects/'.$this->dataObject.'.php');
		//}
		
		$table = Doctrine::getTable($this->dataObject);

		$columns = $table->getColumns();
		//$colName = $table->getColumnNames();
		
		$q = Doctrine_Query::create()
			    ->select('*')
			    ->from($this->dataObject);
		
		foreach ($columns as $colName => $column)
		{
			if(isset($column['primary']) && $column['primary'] == 1)
			{
				echo $colName.' is PRIMAY<br>';
				if(!isset($data[$colName]))
				{
					return false;
				}
				$q->andWhere("$colName = ?", $data[$colName]);
			}
			else 
			{
				echo $colName.' is NOT PRIMAY<br>';
			}
		}
		
		if($q->count() > 0)
		{
			return true;
		}
		else
		{
			return false;	
		}
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