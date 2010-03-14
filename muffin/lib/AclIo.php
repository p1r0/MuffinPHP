<?php
class AclIo
{
	public static $instance = null;
	public $permissions = array();
	
	public static function &getInstance()
	{
		if(AclIo::$instance == null)
		{
			AclIo::$instance = new AclIo();
		}
		
		return AclIo::$instance;
	}
	
	protected function __construct()
	{
		
	}
	
	public function load($user)
	{
		$q = Doctrine_Query::create()
			    ->select("a.*")
			    ->from("Acl a")
			    ->where("a.user_id = ?", $user);
		$this->permissions = $q->execute()->toArray();
	}
	
	public function save()
	{
		$q = Doctrine_Query::create()
			    ->delete()
			    ->from("Acl a")
			    ->where("a.user_id = ?", $this->permissions[0]['user']);
		$q->execute();
		
		foreach($this->permissions as $permission)
		{
			$acl = new Acl();
			$acl->controller = $permission['controller'];
			$acl->method = $permission['method'];
			$acl->user_id = $permission['user'];
			$acl->save();
		}
	}
}
?>