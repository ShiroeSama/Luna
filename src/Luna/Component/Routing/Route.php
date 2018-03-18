<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : RouteBuilder.php
	 *   @Created_at : 18/03/2018
	 *   @Update_at : 18/03/2018
	 * --------------------------------------------------------------------------
	 */
	
	namespace Luna\Component\Routing;
	
	use Luna\Controller\Controller;
	
	class Route
	{
		/**
		 * The route corresponding to the user's request
		 * @var array
		 */
		protected $route;
		
		/**
		 * Controller instance
		 * @var Controller
		 */
		protected $controller;
		
		/**
		 * Name of the method to call
		 * @var string
		 */
		protected $method;
		
		/**
		 * List of params for the method
		 * @var array
		 */
		protected $params;
		
		/**
		 * Route constructor.
		 *
		 * @param array $route
		 * @param Controller $controller
		 * @param string $method
		 * @param array $params
		 */
		public function __construct(array $route, Controller $controller, string $method, array $params)
		{
			$this->route = $route;
			$this->controller = $controller;
			$this->method = $method;
			$this->params = $params;
		}
		
		/**
		 * @return array
		 */
		public function getRoute(): array
		{
			return $this->route;
		}
		
		/**
		 * @return Controller
		 */
		public function getController(): Controller
		{
			return $this->controller;
		}
		
		/**
		 * @return string
		 */
		public function getMethod(): string
		{
			return $this->method;
		}
		
		/**
		 * @return array
		 */
		public function getParams(): array
		{
			return $this->params;
		}
	}
?>