<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : DependencyInjectorAbstractSubscriber.php
	 *   @Created_at : 08/05/2018
	 *   @Update_at : 08/05/2018
	 * --------------------------------------------------------------------------
	 */
	
	namespace Luna\Component\DI\Modules;
	
	use Luna\Component\DI\DependencyInjector;
	
	abstract class DependencyInjectorAbstractSubscriber implements DependencyInjectorSubscriberInterface
	{
		/** @var DependencyInjector */
		protected $dependencyInjector;
		
		/**
		 * DependencyInjectorAbstractSubscriber constructor.
		 * @param DependencyInjector $dependencyInjector
		 */
		public function __construct(DependencyInjector $dependencyInjector)
		{
			$this->dependencyInjector = $dependencyInjector;
		}
	}
?>