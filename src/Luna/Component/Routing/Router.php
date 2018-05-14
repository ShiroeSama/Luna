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
	
    use Luna\Bridge\Component\Handler\Access\RoutingAccessHandlerBridge;
    use Luna\Component\Container\LunaContainer;
    use Luna\Component\DI\DependencyInjector;
    use Luna\Component\Exception\BridgeException;
    use Luna\Component\Exception\ConfigException;
    use Luna\Component\Exception\DependencyInjectorException;
    use Luna\Component\Exception\RouteException;
    use Luna\Component\HTTP\HTTP;
    use Luna\Component\HTTP\Request\Request;
    use Luna\Component\HTTP\Request\ResponseInterface;
    use Luna\Component\Routing\Builder\RouteBuilder;
    use Luna\Component\Utils\ClassManager;

    class Router implements RouterInterface
	{
	    /** @var DependencyInjector */
        protected $DIModule;
        
	    /** @var RoutingAccessHandlerBridge */
	    protected $routingAccessHandlerBridge;

        /** @var Request */
        protected $request;
	
	    /**
	     * Router constructor.
	     *
	     * @throws BridgeException
	     * @throws ConfigException
	     */
        public function __construct()
		{
            $this->DIModule = new DependencyInjector();
            $this->routingAccessHandlerBridge = new RoutingAccessHandlerBridge();
		}

		/* ------------------------ Init Router ------------------------ */

            /**
             * Start the router and exec the routing system
             *
             * @param Request $request
             *
             * @return ResponseInterface
             *
             * @throws ConfigException
             * @throws DependencyInjectorException
             * @throws RouteException
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
		     * @throws ConfigException
		     * @throws DependencyInjectorException
		     * @throws RouteException
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
				
				$access = $this->routingAccessHandlerBridge->access($this->request);
				if (!$access) {
					throw new RouteException('Access Denied', HTTP::UNAUTHORIZED);
				}

                $response = $this->DIModule->callMethod($route->getMethod(), $route->getController(), $route->getParams());
				
				if (!ClassManager::is(ResponseInterface::class, $response)) {
					$message = 'The controller must return a response.';
					
					if ($response === null) {
						$message .= ' Did you forget to add a return statement in your controller ?';
					}
					
					throw new RouteException($message);
				}

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