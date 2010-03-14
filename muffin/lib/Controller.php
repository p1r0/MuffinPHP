<?php
/**
 * Representa un Controlador
 *
 */

require "convenience.php";

class Controller
{
	/**
	 * Todas la varibles que se expondrán a las vistas.
	 *
	 * @var Array
	 */
	protected $exposedVars = array();
	
	public $data = null;
	
	/**
	 * Seteos para el paginador.
	 *
	 * @var Array
	 */
	protected $paginate = null;
	
	protected $passedArgs = array();
	
	protected $processedArgs = array();
	
	protected $action = null;
	
	public $isValid = true;
	
	public $isEdit = false;
	
	protected $layout = "Default";
	
	private $filters = array();
	
	protected static $isDoctrineLoaded = false;
	
	protected $renderDefault = true;
	
	protected $viewLocale = "";
	
	protected $view = null;
	
	protected $viewBaseDir = null;
	
	/**
	 * Inicializa la clase y expone los modelos que se listan 
	 * en var $uses.
	 *
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
		$i18nFileName = strtolower(str_replace("Controller", "", get_class($this))).$this->viewLocale.'.po';
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
	 * Expone una varibales con el nombre $varName y el valor
	 * $value a las vistas.
	 *
	 * @param String $varName Nombre que tendrá la variable
	 * @param Object $value El valor de la variable.
	 */
	protected function expose($varName, $value)
	{
		$this->exposedVars[$varName] = $value;
	}
	
	/**
	 * Renderiza la vista correspondiente al controlador dentro
	 * de la vista por defecto (DefaultView) exponiendo su contenido
	 * en la variable $content que debe ser renderizada detro de la
	 * vista por defecto.
	 *
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
	 * Renderiza la vista por defecto.
	 *
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
	 * Expone las variables y renderiza una vista.
	 *
	 * @param String $view el nombre de la vista sin la palabre view.
	 */
	protected function renderView($view)
	{
		
		//Las variables
		foreach($this->exposedVars as $key => $val)
		{
			$$key = $val;
		}
		
		//Los helpers
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
		
		
		include $this->viewBaseDir.$view."View".$this->viewLocale.".php";
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
			$this->viewLocale = "_".$locale;
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
	
	public function addFilter(Filter $filter)
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
		$this->filters[] = $filter;	
	}
	
	public function applyFilters()
	{
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