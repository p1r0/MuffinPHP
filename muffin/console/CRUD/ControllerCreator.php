<?php
class ControllerCreator
{
	public $helpers = array();
	public $modelName = "";
	public $controllerName = "";
	public $modelColums = array();
	protected $controllerNameLc = "";
	protected $modelNameLc = "";
	
	public function __construct($modelColums, $modelName, $controllerName = "", $helpers = array())
	{
		$this->modelName = $modelName;
	
		if($controllerName == "")
		{
			$this->controllerName = $modelName."s"; 
		}
		else
		{
			$this->controllerName = $controllerName;
		}

		$this->modelColums = $modelColums;
		
		$this->controllerNameLc = $this->controllerName;
		$this->controllerNameLc[0] = strtolower($this->controllerNameLc[0]); 
		
		$this->modelNameLc = $this->modelName;
		$this->modelNameLc[0] = strtolower($this->modelNameLc[0]);
	}
	
	public function create()
	{
		$loadCode = $this->getLoadCode();
		$helpers = $this->getHelpers();
		$saveCode = $this->getSaveCode();
		$editSaveCode = $this->getSaveCode(true);
		
		$filename = dirname(__FILE__)."/controller.php.tpl";
		$handle = fopen($filename, "r");
		$contents = fread($handle, filesize($filename));
		fclose($handle);
		
		$contents = str_replace(array('{ControllerName}', '{LoadCode}',
									  '{ControllerNameLc}', '{ModelName}', '{ModelNameLc}',
									  '{Helpers}', '{SaveCode}', '{EditSaveCode}'), 
								array($this->controllerName, $loadCode,
									  $this->controllerNameLc, $this->modelName, $this->modelNameLc,
									  $helpers, $saveCode, $editSaveCode), 
								$contents);
		
		$fh = fopen(CONTROLLERS_FOLDER."/{$this->controllerName}Controller.php", "w+");
		fwrite($fh, $contents);
		fclose($fh);
	}
	
	protected function getLoadCode()
	{
		$shortAlias = $this->controllerNameLc[0];
		$code = '$q = Doctrine_Query::create()
			    ->select(\''.$shortAlias.'.*\')
			    ->from(\''.$this->modelName.' '.$shortAlias.'\')
			    ->where(\''.$shortAlias.'.active = ?\', true)
			    ->orderBy(\''.$shortAlias.'.id\');
			    
		$'.$this->controllerNameLc.' = $q->execute()->toArray();
		';
		
		return $code;
	}
	
	protected function getSaveCode($isEdit = false)
	{
		if(!$isEdit)
		{
			$code = '$'.$this->modelNameLc.' = new '.$this->modelName.'();';
		}
		else
		{
			$code = '';
		}
		
		foreach($this->modelColums as $key => $data)
		{
			$code .= $this->getSaveCodeForColumn($key, $data);
		}
		
		$code .= '
				$'.$this->modelNameLc.'->save();
		';
		
		return $code;
	}
	
	protected function getSaveCodeForColumn($name, $data)
	{
		if($name != "active" && $data['autoincrement'] != 1)
		{
			return '
				$'.$this->modelNameLc.'[\''.$name.'\'] = $this->data[\''.$name.'\'];';
		}
	}
	
	protected function getHelpers()
	{
		return "'Form'";
	}

}
?>