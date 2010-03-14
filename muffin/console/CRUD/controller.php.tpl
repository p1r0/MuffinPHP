<?php
class {ControllerName}Controller extends AppController  
{	
	var $helpers = array({Helpers});
	protected $errors = array();	
	
	public function indexAction()
	{
		$this->preview();
	
		{LoadCode}		

		$this->expose("pageTitle", "{ControllerName}");
		$this->expose("{ControllerNameLc}", ${ControllerNameLc});
	}
	
	public function removeAction($id)
	{
		$url = $this->http->getControllerUrl(array("controller"=>"{ControllerName}"));

		${ControllerNameLc}Tbl = Doctrine::getTable('{ModelName}');
		${ModelNameLc} = ${ControllerNameLc}Tbl->findOneById($id);
		${ModelNameLc}->active = false; 
		${ModelNameLc}->save();
		
		header("Location: $url");
		exit();	
	}
	
	public function addAction()
	{
		$this->preview();
		if($this->data != null)
		{
			$this->validate();
			if($this->isValid)
			{
				{SaveCode}
			}
		}
		$this->expose("pageTitle", "{ControllerName}");
	}
	
	public function editAction($id)
	{
		$this->preview();
		${ControllerNameLc}Tbl = Doctrine::getTable('{ModelName}');
		${ModelNameLc} = ${ControllerNameLc}Tbl->findOneById($id);
		
		if($this->data != null)
		{
			$this->validate();
			if($this->isValid)
			{
				{EditSaveCode}
				
				$url = $this->http->getControllerUrl(array("controller"=>"{ControllerName}"));
				header("Location: $url");
				exit();	
			}
		}
		else
		{
			$this->isEdit = true;
			$this->data = ${ModelNameLc}->toArray();
		}
		$this->expose("pageTitle", "{ControllerName}");
	}
	
	private function validate()
	{
	}
}
?>