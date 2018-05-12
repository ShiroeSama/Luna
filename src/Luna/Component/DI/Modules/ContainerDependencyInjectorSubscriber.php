<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : ContainerDependencyInjectorSubscriber.php
	 *   @Created_at : 12/05/2018
	 *   @Update_at : 12/05/2018
	 * --------------------------------------------------------------------------
	 */
	
	namespace Luna\Component\DI\Modules;
	
	use Luna\Component\Bag\ParameterBag;
	use Luna\Component\Container\LunaContainer;
	
	use \ReflectionClass;
	
	class ContainerDependencyInjectorSubscriber extends DependencyInjectorAbstractSubscriber
	{
		public function process(ReflectionClass $reflectionClass, ParameterBag $args)
		{
			return LunaContainer::getInstance();
		}
	}
?>