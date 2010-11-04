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
 */
class HttpHelper extends Helper 
{
	
	public $defaultUrlPrefix = "";
	public $locale = "";
	
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
	
	public function getControllerUrl($params, $prefix = "")
	{
		$app_path = APP_PATH;
		$configManager = ConfigManager::getInstance();
		if($configManager->valueExists('global.app_path'))
		{
			$app_path = $configManager->getValue('global.app_path');
		}
		$href = "#";
		
		if(!MOD_REWRITE)
		{
			if(isset($params["controller"]))
			{
				$href = $app_path."/index.php?opcion=".$params["controller"];
				if(isset($params["action"]))
				{
					$href .= "&action=".$params["action"];
				}
			}
		}
		else
		{
			$href = $app_path;
			
			if($this->locale != '')
			{
				$href .= "/".$this->locale;
			}
			
			if($prefix != "")
			{
				$href .= "/".$prefix;
			}
			else if($this->defaultUrlPrefix != "")
			{
				$href .= "/".$this->defaultUrlPrefix;
			}
			
			if(isset($params["controller"]))
			{
				$href .= "/".$params["controller"];
				if(isset($params["action"]))
				{
					$href .= "/".$params["action"];
				}
				
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
		
		return $href;
	}
	
	public function redirect($target)
	{
		header("Location: $target");
		exit();	
	}
}
?>