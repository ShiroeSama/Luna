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
	 *   @Update_at : 07/05/2018
	 * --------------------------------------------------------------------------
	 */
	
	namespace Luna\Component\Routing;
	
    use Luna\Component\DI\DependencyInjector;
    use Luna\Component\HTTP\Request\Request;
    use Luna\Component\HTTP\Request\ResponseInterface;
    use Luna\Component\Routing\Builder\RouteBuilder;

	class Router implements RouterInterface
	{
        /** @var DependencyInjector */
        protected $DIModule;

        /** @var Request */
        protected $request;

        /**
         * Router constructor.
         */
        public function __construct()
		{
            $this->DIModule = new DependencyInjector();
		}

		/* ------------------------ Init Router ------------------------ */

            /**
             * Start the router and exec the routing system
             *
             * @param Request $request
             *
             * @return ResponseInterface
             *
             * @throws \Luna\Component\Exception\DependencyInjectorException
             * @throws \Luna\Component\Exception\RouteException
             */
			public function init(Request $request): ResponseInterface
			{
			    $this->request = $request;
                return $this->launch();
			}
		
		/* ------------------------ System ------------------------ */

            /**
             * Exec the routing system
             *
             * @return ResponseInterface
             *
             * @throws \Luna\Component\Exception\DependencyInjectorException
             * @throws \Luna\Component\Exception\RouteException
             */
			protected function launch(): ResponseInterface
			{
				# Get the Request URI
				$REQUEST_URI	= $_SERVER['REQUEST_URI'];
				$SCRIPT_NAME	= $_SERVER['SCRIPT_NAME'];
				
				# Prepare the User Request URI
				$requestTab = $this->prepareUserRequestURI($REQUEST_URI, $SCRIPT_NAME);
				
				# Build the Route
				$routeBuilder = new RouteBuilder($this->request, $requestTab);
				$routeBuilder->prepare();
				
				$route = $routeBuilder->getRoute();
				
				// TODO : Call RoutingAccessHandler (Check the User Permissions)

                $response = $this->DIModule->callMethod($route->getMethod(), $route->getController(), $route->getParams());

                // TODO : Check if the response is correct

                return $response;
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