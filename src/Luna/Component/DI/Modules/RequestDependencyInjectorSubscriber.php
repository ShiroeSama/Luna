<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : RequestDependencyInjectorSubscriber.php
	 *   @Created_at : 14/05/2018
	 *   @Update_at : 14/05/2018
	 * --------------------------------------------------------------------------
	 */
	
	namespace Luna\Component\DI\Modules;
	
	use Luna\Component\Bag\ParameterBag;
	use Luna\Component\Container\LunaContainer;
	
	use \ReflectionClass;
	
	class RequestDependencyInjectorSubscriber extends DependencyInjectorAbstractSubscriber
	{
		public function process(ReflectionClass $reflectionClass, ParameterBag $args)
		{
			return LunaContainer::getInstance()->getRequest();
		}
	}
?>