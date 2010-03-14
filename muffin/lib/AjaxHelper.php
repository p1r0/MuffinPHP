<?php
class AjaxHelper extends Helper
{
	public function html2UnicodeJsString($string)
	{
		$in = array("&aacute;", "&eacute;", "&iacute;", "&oacute;", "&uacute;", "&ntilde;",
					"&Aacute;", "&Eacute;", "&Iacute;", "&Oacute;", "&Uacute;", "&Ntilde;");

		$out = array("\u00e1", "\u00e9", "\u00ed", "\u00f3", "\u00fa", "\u00f1",
					 "\u00c1", "\u00c9", "\u00cd", "\u00d3", "\u00da", "\u00d1");
		
		return str_replace($in, $out, $string);
	}
	
	public function getJson($obj)
	{
		if(is_array($obj))
		{
			foreach($obj as $key => $value)
			{
				if(is_string($value))
				{
					$obj[$key] = $this->html2UnicodeJsString($value);	
				}
			}
		}
		else
		{
			$obj = $this->html2UnicodeJsString($obj);
		}
		
		return str_replace("\\\\", "\\", json_encode($obj));
	}
}
?>