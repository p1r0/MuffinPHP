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
  * Convenience functions to ease code writing
  */
require_once "convenience.php";

/**
 * The main Controller class of MuffinPHP.
 * @package MuffinPHP
 * @subpackage Core
 * @author Tabaré Caorsi <tcaorsi@binarysputnik.com>
 */
class Controller
{
	/**
	 * All variables that will be exposed to views
	 * @var Array
	 */
	protected $exposedVars = array();
	
    /**
     * $_POST and $_GET merged data.
     * @var Array
     */
	public $data = null;
	
	/**
	 * Setting for Paginator
	 * @var Array
	 */
	protected $paginate = null;
	
    /**
	 * Arguments passed in the url
	 * @var Array
	 */
	protected $passedArgs = array();
	
    /**
	 * Special named arguments passed in the url as
     * <code>name::value</code>
	 * @var Array
	 */
	protected $processedArgs = array();
	
    /**
	 * The action set
	 * @var string
	 */
	protected $action = null;
	
    /**
	 * If using a Form it is can be set to true or false
     * upon validation and will affect the FormHelper 
     * behaviour.
	 * @var boolean
	 */
	public $isValid = true;
	
    /**
	 * If using a Form it is can be set to true or false
     * upon currend state. It will affect the FormHelper
     * behaviour.
	 * @var boolean
	 */
	public $isEdit = false;
	
    /**
	 * The current layout.
	 * @var string
	 */
	protected $layout = "Default";
	
    /**
	 * Array of filters in use
	 * @var Array
	 */
	private $filters = array();
	
    /**
	 * If DoctrinePHP was loaded or not
	 * @var boolean
	 */
	protected static $isDoctrineLoaded = false;
	
    /**
	 * True if the Controller mut render the default layout or not
	 * @var boolean
	 */
	protected $renderDefault = true;
	
    /**
	 * The controller current locale
	 * @var string
	 */
	protected $viewLocale = "";
	
    /**
	 * The controller current view
	 * @var string
	 */
	protected $view = null;
	
    /**
	 * The director where the Controller must look for views
	 * @var string
	 */
	protected $viewBaseDir = null;
	
	/**
	 * Contructor initializes $viewBaseDir and loads all Helpers and
     * models.
	 * Then it initializes i18n support.
	 */
	public function __construct()
	{
		$this->viewBaseDir = CLASSPATH."/views/";
		
		//Los models
		if(isset($this->defaultUses))
		{
			foreach($this->defaultUses as $model)
			{
				$varName = $model;
				$varName[0] = strtolower($varName[0]);
				$this->$varName = ModelFactory::getModel($model);
			}
		}
		
		if(isset($this->uses))
		{
			foreach($this->uses as $model)
			{
				$varName = $model;
				$varName[0] = strtolower($varName[0]);
				$this->$varName = ModelFactory::getModel($model);
			}
		}
		
		//Los helpers
		if(isset($this->defaultHelpers))
		{
			foreach($this->defaultHelpers as $helper)
			{
				$varName = $helper;
				$varName[0] = strtolower($varName[0]);
				$this->$varName =  HelperFactory::getHelper($helper);
				$this->$varName->startUp($this);
			}
		}
		
		if(isset($this->helpers))
		{
			foreach($this->helpers as $helper)
			{
				$varName = $helper;
				$varName[0] = strtolower($varName[0]);
				$this->$varName =  HelperFactory::getHelper($helper);
				$this->$varName->startUp($this);
			}
		}
		
		//i18n
		$i18nFileName = strtolower(str_replace("Controller", "", get_class($this))).'.'.$this->viewLocale.'.po';
		I18nHelper::getInstance()->loadPoFile(I18N_PATH.'/'.$i18nFileName);
	}
	
	public function startUp($args = null)
	{	
		
		if(is_array($_POST) && count($_POST) > 0)
		{
			$this->data = $_POST;
		}
		
		//Parseo los argumentos
		if($args != null)
		{
			$this->passedArgs = $args["param"];
		}
		
		$this->procPassedArgs();
		
		$this->action = $args["action"];
		
	}
	
	protected function procPassedArgs()
	{
		if(is_array($this->passedArgs))
		{
			foreach($this->passedArgs as $key => $arg)
			{
				if(strpos($arg, "::") !== false)
				{
					$tmp = explode("\:\:", $arg);
					$this->processedArgs[$tmp[0]] = $tmp[1];
					unset($this->passedArgs[$key]);	
				}
			}
		}
	}
	
	/**
	 * It exposes variables with the name $varName and value
	 * $value so the views can use then with just $$varName
	 *
	 * @param string $varName Name for the exposed variable,
	 * @param Object $value Value for the exposed variable.
	 */
	protected function expose($varName, $value)
	{
		$this->exposedVars[$varName] = $value;
	}
	
	/**
	 * It renders the current view within the current layout and
     * exposes the result in $content so this variable must be
     * printed (echoed) within the layout.
	 */
	public function render($action = "")
	{
		if(trim($action) == "")
		{
			$action = "index";
		}
		
		$action[0] = strtoupper($action[0]);
		
		if($this->view == null)
		{
			$view = strtolower(str_replace("Controller", "", get_class($this)));
			$view .= "/".$action;
		}
		else
		{
			$view = $this->view;
		}
		
		if($this->renderDefault)
		{
			ob_start();
			$this->renderView($view);
			$content = ob_get_contents();
			ob_clean();
			$this->expose("content", $content);
			$this->renderDefault();
		}
		else
		{
			$this->renderView($view);
		}
		
	}
	
	/**
	 * Renderds the default view
	 */
	public function renderDefault()
	{
		if($this->layout != "")
		{
			$view = "layouts/".$this->layout;
			$this->renderView($view);
		}
	}
	
	/**
	 * Exposes the variables and renders the view $view.
	 *
	 * @param string $view name of the view to render
	 */
	protected function renderView($view)
	{
		
		//The variables
		foreach($this->exposedVars as $key => $val)
		{
			$$key = $val;
		}
		
		//The helpers
		if(isset($this->defaultHelpers))
		{
			foreach($this->defaultHelpers as $helper)
			{
				$varName = $helper;
				$varName[0] = strtolower($varName[0]);
				$$varName = &$this->$varName;
			}
		}
		
		if(isset($this->helpers))
		{
			foreach($this->helpers as $helper)
			{
				$varName = $helper;
				$varName[0] = strtolower($varName[0]);
				$$varName = &$this->$varName;
			}
		}
		
		$viewFileName = $this->viewBaseDir.$view."View.".$this->viewLocale.".php";
		clearstatcache();
		if(!file_exists($viewFileName))
		{
			$viewFileName = $this->viewBaseDir.$view."View.php";
		}
		include $viewFileName;
	}
	
	public function paginate(&$model, $options=null)
	{
		$limit = isset($this->paginate["limit"]) ? $this->paginate["limit"] : 10;
		$total = $model->count($options);
		$pageCount = intval(ceil($total / $limit));
		$page = isset($this->processedArgs["page"]) ? $this->processedArgs["page"] : 1; 
		$from = isset($this->paginate["limit"]) ? $this->paginate["limit"] * ($page -1) : 10 * ($page -1);
		if($from > $total)
		{
			$page = $pageCount;
			$from = isset($this->paginate["limit"]) ? $this->paginate["limit"] * ($page -1) : 10 * ($page -1);
		}
		
		$options["limit"] = "$limit offset $from";
		
		$data = array(
				"current" => $page,
				"pageCount" => $pageCount,
				'prevPage'	=> ($page > 1),
				'nextPage'	=> ($total > ($page * $limit)),
				'total' => $total, 
				'limit' => $limit,
				'from' => $from + 1,
				'to' => $from + $limit
				);
		
		if(isset($this->paginator))
		{
			$this->paginator->setData($data);
		}				
				
		return $model->findAll($options);
	}
	
	public function setupPaginator($total)
	{
		$limit = isset($this->paginate["limit"]) ? $this->paginate["limit"] : 10;
		$pageCount = intval(ceil($total / $limit));
		$page = isset($this->processedArgs["page"]) ? $this->processedArgs["page"] : 1; 
		$from = isset($this->paginate["limit"]) ? $this->paginate["limit"] * ($page -1) : 10 * ($page -1);
		if($from > $total)
		{
			$page = $pageCount;
			$from = isset($this->paginate["limit"]) ? $this->paginate["limit"] * ($page -1) : 10 * ($page -1);
		}
		
		$options["limit"] = $limit;
		$options["offset"] = $from;
		
		$data = array(
				"current" => $page,
				"pageCount" => $pageCount,
				'prevPage'	=> ($page > 1),
				'nextPage'	=> ($total > ($page * $limit)),
				'total' => $total, 
				'limit' => $limit,
				'from' => $from + 1,
				'to' => $from + $limit
				);
		
		if(isset($this->paginator))
		{
			$this->paginator->setData($data);
		}				
				
		return $options;
	}
	
	public function getPassedArgs()
	{
		return $this->passedArgs;
	}
	
	public function getAction()
	{
		return $this->action;
	}
	
	public function getLayout()
	{
		return $this->layout;
	}
	
	public function setLayout($layout)
	{
		$this->layout = $layout;
	}

	public function setViewLocale($locale)
	{
		if($locale != "")
		{
			$this->viewLocale = $locale;
		}
		else
		{
			$this->viewLocale = "";
		}
	}
	
	public function getViewLocale()
	{
		return str_replace("_", "", $this->viewLocale); 
	}
	
	public function setView($view)
	{
		$this->view = $view;
	}
	
	public function getView()
	{
		return $this->view;
	}
	
	public function addFilter(Filter &$filter)
	{
		$this->filters[] = $filter;	
	}
	
	public function removeFilter(Filter &$filter)
	{
		for($i = 0; $i < count($this->filters); $i++)
		{
			if($this->filters[$i] === $filter)
			{
				unset($this->filters[$i]);
			}
		}
		//$this->filters[] = $filter;	
	}
	
	public function applyFilters(&$args)
	{
		$this->prefilter(&$args);
		
		$ret = true;
	
		for($i = 0; $i < count($this->filters); $i++)
		{
			$ret &= $this->filters[$i]->apply($this, $_GET);
		}
		
		return $ret;
	}
	
	public function isDoctrineLoaded()
	{
		return Controller::$isDoctrineLoaded;
	}
	
	//This is here just to be overriden
	public function prefilter(&$args)
	{
		
	}
	
	protected function startUpDoctrine()
	{
		$configManager = ConfigManager::getInstance();
		Doctrine_Manager::connection($configManager->getDbConnectionString());
		Doctrine_Manager::getInstance()->setAttribute(Doctrine::ATTR_MODEL_LOADING, 
													  Doctrine::MODEL_LOADING_CONSERVATIVE);
		Doctrine::loadModels(CLASSPATH.'/models');
	}
}
?>