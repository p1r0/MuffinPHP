<?php
class ViewCreator
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
		$this->createIndex();
		$this->createAdd();
		$this->createEdit();
	}
	
	public function createIndex()
	{
		$rowCode = $this->getRowCode();
		$rowHeaderCode = $this->getRowHeaderCode();
		
		$filename = dirname(__FILE__)."/indexview.php.tpl";
		$handle = fopen($filename, "r");
		$contents = fread($handle, filesize($filename));
		fclose($handle);
		
		$contents = str_replace(array('{ControllerName}',
									  '{ControllerNameLc}', '{ModelName}', '{ModelNameLc}',
									  '{RowCode}', '{RowHeaderCode}'), 
								array($this->controllerName,
									  $this->controllerNameLc, $this->modelName, $this->modelNameLc,
									  $rowCode, $rowHeaderCode), 
								$contents);
								
		$folderName = strtolower($this->controllerNameLc);								
		mkdir(VIEWS_FOLDER."/{$folderName}");
		$fh = fopen(VIEWS_FOLDER."/{$folderName}/IndexView.php", "w+");
		fwrite($fh, $contents);
		fclose($fh);
	}
	
	public function createAdd()
	{
		$formCode = $this->getFormCode();
		
		$filename = dirname(__FILE__)."/addview.php.tpl";
		$handle = fopen($filename, "r");
		$contents = fread($handle, filesize($filename));
		fclose($handle);
		
		$contents = str_replace(array('{ControllerName}',
									  '{ControllerNameLc}', '{ModelName}', '{ModelNameLc}',
									  '{FormCode}'), 
								array($this->controllerName,
									  $this->controllerNameLc, $this->modelName, $this->modelNameLc,
									  $formCode), 
								$contents);
								
		$folderName = strtolower($this->controllerNameLc);								
		@mkdir(VIEWS_FOLDER."/{$folderName}");
		$fh = fopen(VIEWS_FOLDER."/{$folderName}/AddView.php", "w+");
		fwrite($fh, $contents);
		fclose($fh);
	}
	
	public function createEdit()
	{
		$formCode = $this->getFormCode();
		
		$filename = dirname(__FILE__)."/editview.php.tpl";
		$handle = fopen($filename, "r");
		$contents = fread($handle, filesize($filename));
		fclose($handle);
		
		$contents = str_replace(array('{ControllerName}',
									  '{ControllerNameLc}', '{ModelName}', '{ModelNameLc}',
									  '{FormCode}'), 
								array($this->controllerName,
									  $this->controllerNameLc, $this->modelName, $this->modelNameLc,
									  $formCode), 
								$contents);
								
		$folderName = strtolower($this->controllerNameLc);								
		@mkdir(VIEWS_FOLDER."/{$folderName}");
		$fh = fopen(VIEWS_FOLDER."/{$folderName}/EditView.php", "w+");
		fwrite($fh, $contents);
		fclose($fh);
	}
	
	protected function getFormCode()
	{
		$code = "";
		
		foreach($this->modelColums as $key => $data)
		{
			$code .= $this->getFormFieldCode($key, $data);
		}
		
		return $code;
	}
	
	protected function getFormFieldCode($name, $data)
	{
		if($name != "active" && $data['autoincrement'] != 1)
		{
			$label = $name;
			$label[0] = strtoupper($label[0]);
			if($data['type'] == 'string' && $data['length'] > 500)
			{
				return '<label for="'.$name.'">'.$label.':</label>
	<div>
		<?php echo $form->fieldArea("'.$name.'", array("options"=>array())) ?>
	</div>
	';
			}
			else
			{
				return '<label for="'.$name.'">'.$label.':</label>
	<div>
		<?php echo $form->field("'.$name.'", array("options"=>array("type"=>"text"))) ?>
	</div>
	';
			}
		}
	}
	
	protected function getRowCode()
	{
		$code = "";

		$first = true;
		
		foreach($this->modelColums as $key => $data)
		{
			$code .= $this->getRowCodeForColumn($key, $data, $first);
			$first = false;
		}
		
		$code .= $this->getRowCodeForActions();
		
		return $code;
	}
	
	protected function getRowHeaderCode()
	{
		$code = "";

		$first = true;
		
		foreach($this->modelColums as $key => $data)
		{
			$code .= $this->getRowHeaderCodeForColumn($key, $data, $first);
			$first = false;
		}
		
		$code .= '
			<td class="theader" align="center">Actions</td>';
		
		return $code;
	}
	
	protected function getRowHeaderCodeForColumn($name, $data, $first)
	{
		if($name != "active")
		{
			$name[0] = strtoupper($name[0]);
			return '
			<td class="theader"  width="200">'.$name.'</td>';	
		}
	}
	
	protected function getRowCodeForColumn($name, $data, $first)
	{
		if($name != "active")
		{
			if($first)
			{
				return '
					<td class="trow"><?php echo $'.$this->modelNameLc.'[\''.$name.'\']?></td>';
			}
			else
			{
				return '
					<td class="tmiddlecell trow"><?php echo $'.$this->modelNameLc.'[\''.$name.'\']?></td>';	
			}
		}
	}
	
	protected function getRowCodeForActions()
	{
		return '
					<td class="tmiddlecell trow" align="center">
							<a href="<?php echo $http->getControllerUrl(array("controller"=>"'.$this->controllerName.'", 
																			  "action"=>"edit",
																			  "params"=>array($'.$this->modelNameLc.'[\'id\']))); ?>">Edit</a> |
							<a href="<?php echo $http->getControllerUrl(array("controller"=>"'.$this->controllerName.'", 
																			  "action"=>"remove",
																			  "params"=>array($'.$this->modelNameLc.'[\'id\']))); ?>">Remove</a>
					</td>';
	}

}
?>