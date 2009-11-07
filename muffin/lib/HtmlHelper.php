<?php
/**
 * HTML Helper.
 * 
 * This class is in charge of resolving path for differnt types
 * of files within the application with other HTML related stuff.
 * 
 * The paths are resolved according to the directory setting in 
 * config/conf.php
 *
 */
class HtmlHelper extends Helper
{
	/**
	 * Returns the URL for an image using the current configuration
	 *
	 * @param String $img Image path from the image directory 
	 * @return String Absolute URL for the image
	 */
	public function getImage($img)
	{
		return IMGS_PATH."/".$img;
	}
	
	/**
	 * Returns the URL for a style sheet using the current configuration
	 *
	 * @param String $css Style Sheet file path from the CSS directory 
	 * @return String Absolute URL for the CSS file
	 */
	public function getCss($css)
	{
		return CSS_PATH."/".$css;
	}
	
	/**
	 * Returns the URL for a JavaScript file using the current configuration
	 *
	 * @param String $js JS file path from the JS directory 
	 * @return String Absolute URL for the JS file
	 */
	public function getJs($js)
	{
		return JS_PATH."/".$js;
	}
	
	/**
	 * Returns the URL for a Flash file using the current configuration
	 *
	 * @param String $flash flash file path from the flash directory 
	 * @return String Absolute URL for the flash file
	 */
	public function getFlash($flash)
	{
		return FLASH_PATH."/".$flash;
	}
	
	/**
	 * Returns the URL for a any resource file stored in other using the current configuration
	 *
	 * @param String $file file path from the flash directory 
	 * @return String Absolute URL for the file
	 */
	public function getOther($file)
	{
		return OTHER_PATH."/".$file;
	}
	
	/**
	 * Return a links for the parametes
	 * 
	 * @param Array $params The parameter from which to build the link.
	 * 		The paremeters are as follows:
	 * 			'controller' the controller name
	 * 			'title' the label to be shown for the anchor
	 * 			'options' array with html options
	 * @return unknown_type
	 */
	public function link($params)
	{
		$href = HelperFactory::getHelper("Http")->getControllerUrl($params);
		
		$htmlOptions = $this->parseOptionsHTML($params);
		
		$link = '<a href="'.$href.'"';
		
		if(isset($params["class"]))
		{
			$link .= ' class="'.$params["class"].'"';
		}
		
		$link .= $htmlOptions.' >'.$params["title"].'</a>';
		
		return $link;
		
	}
	
	public function getUrl($target)
	{
		return APP_PATH."/".$target;
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