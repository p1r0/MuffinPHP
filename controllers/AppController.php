<?php
class AppController extends Controller 
{
	
	protected $_config = null;
	protected $logger = null;
	
	var $defaultHelpers = array("Html");
	
	public function __construct()
	{
		parent::__construct();
		$this->logger = new Logger(get_class($this));
		$this->addFilter(FilterFactory::getFilter("Auth"));
		
		$this->expose("html", $this->html);
	}
	
	public function indexAction()
	{
		

	}
	
}
?>