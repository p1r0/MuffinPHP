<?php
class ComponentLoader
{
	public static function uses($component, Dispatcher &$dispatcher, ConfigManager &$configManager)
	{
		require CLASSPATH."/components/$component/{$component}Configurator.php";
		$conf = "{$component}Configurator";
		forward_static_call_array(array($conf, 'setup'), array($dispatcher, $configManager));
	}
}