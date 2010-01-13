<?php
class FormHelper extends Helper 
{
	public function create($options = null)
	{
		$str = '<form method="post" ';
		
		if(isset($options["name"]))
		{
			$str .= ' name="'.$options["name"].'" ';
		}
		
		if(isset($options["id"]))
		{
			$str .= ' id="'.$options["id"].'" ';
		}
		
		$str .= $this->parseOptionsHTML($options);
		
		$str .= ">";

		return $str;
	}
	
	public function end($addSendButton = false, $text = "Send", $showCanlcel = true, $cancelText = "Cancel")
	{
		$str = "";
		
		if($addSendButton)
		{
			$str .= '<input type="submit" value="'.$text.'" />';
		}
		
		if($showCanlcel)
		{
			$str .= '<input type="button" value="'.$cancelText.'" onclick="history.go(-1)" />';
		}
		
		$str .= "</form>";
		
		return $str;
	}
	
	public function getCombo($value_id, $label_id, $data, $options = null)
	{
		$str = "<select ";
		
		if(isset($options["name"]))
		{
			$str .= ' name="'.$options["name"].'" ';
		}
		
		if(isset($options["id"]))
		{
			$str .= ' id="'.$options["id"].'" ';
		}
		
		$str .= $this->parseOptionsHTML($options);
		
		$str .= ">";
		
		foreach($data as $option)
		{
			$selected = isset($options["options"]["name"]) && isset($this->controler->data[$options["options"]["name"]]) && $option[$value_id] == $this->controler->data[$options["options"]["name"]] ? "selected" : "";
			if($selected == "")
			{	
				$selected = isset($options["options"]["value"]) && $option[$value_id] == $options["options"]["value"] ? "selected" : "";
			}
			$str .= "<option value='{$option[$value_id]}' {$selected}>{$option[$label_id]}</option>";
		}
		
		$str .= "</select>";
			
		return $str;
	}
	
	public function field($name, $options)
	{
		if((!$this->controler->isValid) || ($this->controler->isEdit))
		{
			$value = 'value="'.$this->controler->data[$name].'"';
		}
		else
		{
			$value = isset($options["value"]) ? $options["value"] :'';
		}
		$str = '<input name="'.$name.'" id="'.$name.'" '.$this->parseOptionsHTML($options).' '.$value.' />';
		
		return $str;
	}
	
	public function fieldCheck($name, $options = null)
	{
		if((!$this->controler->isValid) || ($this->controler->isEdit))
		{
			$value = isset($this->controler->data[$name]) && ($this->controler->data[$name] == true || $this->controler->data[$name] == "on") ? "checked" : "" ;
		}
		else
		{
			$value  =  isset($options["value"]) && ($options["value"] == true || $options["value"]) == "on" ? "checked" : "" ;
		}
		$str = '<input name="'.$name.'" type="checkbox" '.$this->parseOptionsHTML($options).' '.$value.' />';
		
		return $str;
	}
	
	public function fieldArea($name, $options)
	{
		if((!$this->controler->isValid) || ($this->controler->isEdit))
		{
			$value = $this->controler->data[$name];
		}
		else
		{
			$value = isset($options["value"]) ? $options["value"] :'';
		}
		$str = '<textarea name="'.$name.'" id="'.$name.'" '.$this->parseOptionsHTML($options).'>'.$value.'</textarea>';
		
		return $str;
	}
	
	protected function parseOptionsHTML($options)
	{
		$str = "";
		
		if(isset($options["options"]))
		{
			if(is_array($options["options"]))
			{
				foreach($options["options"] as $option => $value)
				{
					$str .= ' '.$option.'="'.$value.'" ';
				}
			}
		}
		
		return $str;
	}
}
?>