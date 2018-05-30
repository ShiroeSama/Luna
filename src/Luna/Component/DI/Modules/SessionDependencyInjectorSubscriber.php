<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : SessionDependencyInjectorSubscriber.php
	 *   @Created_at : 30/05/2018
	 *   @Update_at : 30/05/2018
	 * --------------------------------------------------------------------------
	 */
	
	namespace Luna\Component\DI\Modules;
	
	use Luna\Component\Bag\ParameterBag;
	use Luna\Component\Container\LunaContainer;
	use Luna\Component\Session\Session;
	use Luna\Config\Config;
	
	use \ReflectionClass;
	
	class SessionDependencyInjectorSubscriber extends DependencyInjectorAbstractSubscriber
	{
		public function process(ReflectionClass $reflectionClass, ParameterBag $args)
		{
			return LunaContainer::getInstance()->getSession();
		}
	}
?>