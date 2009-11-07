<?php
class HttpHelper extends Helper 
{
	//@TODO Add parameters parsing for the no MOD_REWRITE version
	
	public function parseGet($get)
	{
		$ar = array();
		
		if(!MOD_REWRITE)
		{
			$ar["controller"] = isset($get["opcion"]) ? $get["opcion"] : "Index";
			$ar["action"] = isset($get["accion"]) ? $get["accion"] : "index";
		}
		else
		{
			$get = isset($get["url"]) ? $get["url"] : "";
			$tmpArr = explode("/", $get);
			$ar["controller"] = isset($tmpArr[0]) && trim($tmpArr[0]) != "" ? $tmpArr[0] : "Index";
			$ar["action"] = isset($tmpArr[1]) && trim($tmpArr[1]) != "" ? $tmpArr[1] : "index";
			$ar["param"] = array();
			for($i=2; $i<count($tmpArr); $i++)
			{
				$ar["param"][] = $tmpArr[$i];
			}
		}
			
		return $ar;
	}
	
	public function getControllerUrl($params)
	{
		$href = "#";
		
		if(!MOD_REWRITE)
		{
			if(isset($params["controller"]))
			{
				$href = APP_PATH."/index.php?opcion=".$params["controller"];
				if(isset($params["action"]))
				{
					$href .= "&action=".$params["action"];
				}
			}
		}
		else
		{
			$href = APP_PATH;
			
			if(isset($params["controller"]))
			{
				$href .= "/".$params["controller"];
				if(isset($params["action"]))
				{
					$href .= "/".$params["action"];
					if(isset($params["params"]))
					{
						if(is_array($params["params"]))
						{
							foreach($params["params"] as $param)
							{
								$href .= "/".$param;
							}
						}
						else
						{
							$href .= "/".$params["params"];
						}
					}
				}
			}
		}
		
		return $href;
	}
	
	public function redirect($target)
	{
		header("Location: $target");
		exit();	
	}
}
?>