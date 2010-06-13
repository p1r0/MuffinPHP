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
class PaginatorHelper extends Helper
{
	var $data = null;
	
	public function setData($data)
	{
		$this->data = $data;
	}
	
	public function getCounter($str)
	{
	
		$placeHolders = array("%page%", 
							  "%pageCount%",
							  "%from%",
							  "%to%",
							  "%limit%");
		
		$values = array($this->data["current"], 
						$this->data["pageCount"],
						$this->data["from"],
						$this->data["to"],
						$this->data["limit"]);
		
		$strRet = str_replace($placeHolders, $values, $str);
							  
		return $strRet;
	}
	
	public function getNext($strOn, $strOff, $options)
	{
		if($this->data['nextPage'])
		{
			$page = $this->data["current"]+1;
	
			$link = $this->getPageLink($strOn, $options, $page);
		}
		else
		{
			$link = "<span class='{$options["class"]}'>".$strOff."</span>";
		}								
						
		return $link;
	}
	
	public function getPrev($strOn, $strOff, $options)
	{	
		if($this->data['prevPage'])
		{
			$page = $this->data["current"]-1;
	
			$link = $this->getPageLink($strOn, $options, $page);
		}
		else
		{
			$link = "<span class='{$options["class"]}'>".$strOff."</span>";
		}								
						
		return $link;
	}
	
	public function getNumbers($options)
	{
		$str = "";
		
		for($i=1; $i<= $this->data["pageCount"]; $i++)
		{
			if($this->data['current'] != $i)
			{
				$num = $this->getPageLink($i, $options, $i);
			}	
			else
			{
				$num = " <span class='{$options["class"]}'>{$i}</span> ";
			}
			
			if($str != "")
			{
				$str .= " <span class='{$options["class"]}'>|</span> ".$num;
			}
			else
			{
				$str = $num;
			}
		}
		
		return $str;
			
	}
	
	protected function getPageLink($str, $options, $page)
	{
		$html = HelperFactory::getHelper("Html");
		
		$params = array("page:".$page);
	
		$params = array_merge($this->controler->getPassedArgs(), $params);
		
		$link = $html->link(array(
							"controller" => str_replace("Controller", "", get_class($this->controler)),
							"class" => $options["class"],
							"title" => $str,
							"action" => $this->controler->getAction(),
							"params" => $params
							));
							
		return $link;
	}
}
?>