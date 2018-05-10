<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : ConfigDependencyInjectorSubscriber.php
	 *   @Created_at : 10/05/2018
	 *   @Update_at : 10/05/2018
	 * --------------------------------------------------------------------------
	 */
	
	namespace Luna\Component\DI\Modules;
	
	use Luna\Component\Bag\ParameterBag;
	use Luna\Config\Config;
	
	use \ReflectionClass;
	
	class ConfigDependencyInjectorSubscriber extends DependencyInjectorAbstractSubscriber
	{
		public function process(ReflectionClass $reflectionClass, ParameterBag $args)
		{
			return Config::getInstance();
		}
	}
?>