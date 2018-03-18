<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : Router.php
	 *   @Created_at : 03/12/2017
	 *   @Update_at : 03/12/2017
	 * --------------------------------------------------------------------------
	 */
	
	namespace Luna\Component\Routing;
	
	use \Throwable;
	use Luna\Bridge\Component\Routing\RoutingExceptionHandlerBridge;
	use Luna\Component\Routing\Builder\RouteBuilder;

	class Router implements RouterInterface
	{
        /** @var RoutingExceptionHandlerBridge */
        protected $RoutingExceptionHandlerBridgeModule;

        /**
         * Router constructor.
         */
        public function __construct()
		{
			$this->RoutingExceptionHandlerBridgeModule = new RoutingExceptionHandlerBridge();
		}

		/* ------------------------ Init Router ------------------------ */
			
			/**
			 * Start the router and exec the routing system
			 */
			public function init()
			{
				try {
					$this->launch();
				} catch (Throwable $throwable) {
                    $this->RoutingExceptionHandlerBridgeModule->catchException($throwable);
				}
			}
		
		/* ------------------------ System ------------------------ */
			
			/**
			 * Exec the routing system
			 */
			protected function launch()
			{
				# Get the Request URI
				$REQUEST_URI	= $_SERVER['REQUEST_URI'];
				$SCRIPT_NAME	= $_SERVER['SCRIPT_NAME'];
				
				# Prepare the User Request URI
				$requestTab = $this->prepareUserRequestURI($REQUEST_URI, $SCRIPT_NAME);
				
				# Build the Route
				$routeBuilder = new RouteBuilder($requestTab);
				$routeBuilder->prepare();
				
				$route = $routeBuilder->getRoute();
				
				// TODO : Call RoutingAccessHandler (Check the User Permissions)
				
				// TODO : Use DI (Dependency Injector) to call method
			}
		
		
		/* ------------------------ Prepare URI ------------------------ */
			
			/**
			 * @param string $REQUEST_URI
			 * @param string $SCRIPT_NAME
			 *
			 * @return array
			 */
			protected function prepareUserRequestURI(string $REQUEST_URI, string $SCRIPT_NAME): array
			{
				# Format the User Request URI
				$requestTab = $this->formatRequest($REQUEST_URI, $SCRIPT_NAME);
				
				# Clean the request
				$requestTab = $this->clearRoute($requestTab);
				
				if(empty($requestTab)) { array_push($requestTab, "/"); }
				
				return $requestTab;
			}
		
		
		/* ------------------------ Format ------------------------ */
		
			/**
			 * @param string $REQUEST_URI
			 * @param string $SCRIPT_NAME
			 *
			 * @return array
			 */
			protected function formatRequest(string $REQUEST_URI, string $SCRIPT_NAME): array
			{
				$REQUEST_URI = preg_replace('#\?[^>]*$#', '', $REQUEST_URI);
				
				$requestTab = explode('/', $REQUEST_URI);
				$scriptTab  = explode('/', $SCRIPT_NAME);
				
				foreach ($requestTab as $key => $value) {
					if (in_array($value, $scriptTab)) {
						unset($requestTab[$key]);
					}
				}
				
				return array_values($requestTab);
			}
			
			/**
			 * Removing empty values
			 *
			 * @param array $requestTab
			 * @return array
			 */
			protected function clearRoute(Array $requestTab): array { return array_values(array_filter($requestTab, __CLASS__ . '::arrayFilterCallback', ARRAY_FILTER_USE_BOTH)); }
			protected function arrayFilterCallback($var) : bool { return (!empty($var) || $var == '0'); }
	}
?>