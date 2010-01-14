<?php
class I18nHelper extends Helper
{
	protected $translationArray = array();
	protected $translationKeys = array();
	
	public static $instance = null;
	
	public static function &getInstance()
	{
		if(I18nHelper::$instance == null)
		{
			I18nHelper::$instance = new I18nHelper();
		}
		
		return I18nHelper::$instance;
	}
	
	protected function __construct()
	{
		
	}
	
	protected function loadTranslationArray()
	{
		if(isset($this->translationArray[1]))
		{
			if(is_array($this->translationArray[1]))
			{
				foreach($this->translationArray[1] as $val)
				{
					$this->translationKeys[$val["msgid"]] = $val["msgstr"];
				}
			}
		}
	}
	
	public function loadPoFile($fileName)
	{
		$parser = new POParser();
		try
		{
			$this->translationArray = $parser->parse($fileName);
			$this->loadTranslationArray();
		}
		catch(Exception $e)
		{
			$this->translationArray = array();
		}
	}
	
	public function tr($string)
	{
		if(isset($this->translationKeys[$string]) && $this->translationKeys[$string] != "")
		{
			return $this->translationKeys[$string];
		}
		else
		{
			return $string;
		}
	}
}
?>