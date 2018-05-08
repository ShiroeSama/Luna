<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : DependencyInjectorSubscriberInterfaceInterface
	 *   @Created_at : 08/05/2018
	 *   @Update_at : 08/05/2018
	 * --------------------------------------------------------------------------
	 */
	
	namespace Luna\Component\DI\Modules;
	
	use Luna\Component\Bag\ParameterBag;
	use \ReflectionClass;
	
	interface DependencyInjectorSubscriberInterface
	{
		public function process(ReflectionClass $reflectionClass, ParameterBag $args);
	}
?>