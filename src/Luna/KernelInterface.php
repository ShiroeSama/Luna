<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : KernelInterface.php
	 *   @Created_at : 08/05/2018
	 *   @Update_at : 08/05/2018
	 * --------------------------------------------------------------------------
	 */
	
	namespace Luna;
	
	use Luna\Component\HTTP\Request\ResponseInterface;
	
	interface KernelInterface
	{
		/**
		 * Access point of the application
		 * Allow to start the routing component and settings the Luna Framework
		 *
		 * - DI (Dependency Injector)
		 * - Routing
		 * - Templating
		 * - Constant
		 */
		public function start();
		
		/**
		 * Send response to the client.
		 * Configure headers and display content
		 */
		public function send();
		
		/* -------------------------------------------------------------------------- */
		/* Informations */
		
		/**
		 * @return string
		 */
		public function getEnv(): string;
		
		/**
		 * @return ResponseInterface
		 */
		public function getResponse(): ResponseInterface;
	}
?>