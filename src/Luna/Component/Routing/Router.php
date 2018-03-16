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
	use \PDOException;

    use Luna\Config;
	use Luna\Utils\Exception\RouteException;
    use Luna\Bridge\Component\Routing\RoutingExceptionHandlerBridge;
	
	use Luna\View\Render;
	use Luna\View\MetaData;
	use Luna\Utils\HTTP\Request;
	use Luna\Controller\Controller;

	class Router implements RouterInterface
	{
        /** @var Config */
        protected $ConfigModule;

        /** @var RoutingExceptionHandlerBridge */
        protected $RoutingExceptionHandlerBridgeModule;


		/**
		 * Contient le dossier des contrôleurs
		 * @var string
		 */
		protected $rootFolder;
		
		/**
		 * Contient toutes les routes et régles
		 * @var array
		 */
		protected $routes = [];

		/**
		 * Contient la route actuel
		 * @var array
		 */
		protected $route;

		/**
		 * Module de Rendu de vue
		 * @var Render
		 */
		protected $RenderModule;

		/**
		 * Chemin du dossier contenant les Controleurs
		 * @var string
		 */
		protected $controllerFolder;

		/**
		 * Nom du controleur à utiliser
		 * @var string
		 */
		protected $controller;

		/**
		 * Nom de la méthode à appeler
		 * @var string
		 */
		protected $action;

		/**
		 * Contient les potentiels paramètres pour la méthode
		 * @var array
		 */
		protected $params;


        /**
         * Router constructor.
         */
        public function __construct()
		{
		    $this->ConfigModule = Config::getInstance();

		    $this->routes = $this->ConfigModule->getRouting('ROUTES');
            $this->rootFolder = $this->ConfigModule->getRouting('ROOT_FOLDER');
			
			$this->RenderModule = new Render();
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
			
			
		
		/**
		 * Exec the routing system
         *
		 * @throws PDOException
		 * @throws RouteException
		 */
		protected function launch()
		{
			# Récupération de l'URl
			$REQUEST_URI	= $_SERVER['REQUEST_URI'];
			$SCRIPT_NAME	= $_SERVER['SCRIPT_NAME'];
			
			# Découpe de l'Url
			$requestTab = $this->formatRequest($REQUEST_URI, $SCRIPT_NAME);
			
			# Netoyage des values vides
			$requestTab = $this->clearRoute($requestTab);
			
			# Vérifie que le dossier indiqué contenant les controleurs existe
			$this->checkControllerDir();
			
			$this->matchRoute($requestTab);
			$this->getControllerWithAction();
			
			$this->checkAccessPermissions();
			
			$class = $this->controller;
			$controller = new $class();
			
			$requestTab = (sizeof($requestTab) === 0) ? '/' : implode('/', $requestTab);
			
			// Set MetaData
			$this->setMetaData($controller);
			// Set Request
			$this->setRequest($controller, $requestTab);
			
			if (method_exists($controller, 'init')) {
				$controller->init();
			}
			
			if (!method_exists($controller, $this->action)) {
				throw new RouteException(RouteException::ROUTE_METHODE_NOT_ALLOWED_ERROR_CODE);
			} else {
				$action = $this->action;
			}
			
			if (empty($this->params)) {
				$controller->$action();
			} else {
				call_user_func_array(array($controller, $action), $this->params);
			}
		}
		
		
		/* ------------------------ Match ------------------------ */
		
			/**
			 * Permet de voir si la route existe, puis retourne le controleur et la méthode à utiliser pour cette requête
			 *
			 * @param array $requestTab
			 *
			 * @throws RouteException
			 */
			protected function matchRoute(array $requestTab)
			{
				$requestTab = $this->clearRoute($requestTab);
				
				if(empty($requestTab)) { array_push($requestTab, "/"); }
				$routes = $this->formatRoutes($this->routes);
				
				foreach ($routes as $key => $value) {
					$rule = $value['Rule'];
					$rule = $this->clearRoute($rule);
					
					if (count($rule) === count($requestTab)) {
						if ($this->checkRouteRule($rule, $requestTab) && $this->checkRouteMethod($routes[$key])) {
							$this->params = $this->getParams($rule, $requestTab);
							$this->route = [ $key => $this->routes[$key] ];
							return;
						}
					}
				}
				
				throw new RouteException(RouteException::ROUTE_NOTFOUND_ERROR_CODE);
			}
		
		
		/* ------------------------ Format ------------------------ */
		
			/**
			 * Formate la Requête
			 *
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
			 * Formate les Routes
			 *
			 * @param array $routesConfig
			 *
			 * @return array
			 * @throws RouteException
			 */
			protected function formatRoutes(array $routesConfig): array
			{
				$keysRoutes = array_keys($routesConfig);
				$routes = $routesConfig;
				
				foreach ($routes as $key => $value) {
					if (!isset($value['Rule']) || !isset($value['Action'])) {
						throw new RouteException(RouteException::ROUTE_INTERNAL_SERVER_ERROR_ERROR_CODE, "The 'Rule' or 'Action' parameters as not configured for {$key}");
					}
					
					$value['Rule'] = (($value['Rule'] == '/') ? array('/') : explode('/', $value['Rule']));
					$routes[$key]['Rule'] =  $value['Rule'];
				}
				
				return $routes;
			}
			
			/**
			 * Nettoie la route en enlevant les valeurs vides
			 *
			 * @param array $requestTab
			 *
			 * @return array
			 */
			protected function clearRoute(Array $requestTab): array { return array_values(array_filter($requestTab, __CLASS__ . '::arrayFilterCallback', ARRAY_FILTER_USE_BOTH)); }
			
			protected function arrayFilterCallback($var) : bool { return (!empty($var) || $var == '0'); }


		/* ------------------------ Check ------------------------ */

			/**
			 * Vérifie que la requête correspond à une régle de routage
			 * Exemple :
			 * - Request ('/Test') == Route ('/Test')
			 * - Request ('/Test/Testy') == Route ('/Test/:name')
			 *
			 * @param array $route
			 * @param array $request
			 *
			 * @return bool
			 */
			protected function checkRouteRule(array $route, array $request): bool
			{
				$size = count($route);

				for ($i=0; $i < $size; $i++) {
					if ($route[$i] === $request[$i] || $route[$i][0] === ':') {
						continue;
					} else {
						return false;
					}
				}
				return true;
			}
		
			/**
			 * Vérifie que la requête correspond à la méthode d'appel de la route
			 * Exemple :
			 * - Request (METHOD = GET) == Route (METHOD = GET)
			 *
			 * @param array $route
			 *
			 * @return bool
			 */
			protected function checkRouteMethod(array $route): bool
			{
				if (!isset($route['Method'])) { return true; }
				
				$routeMethod = $route['Method'];
				$requestMethod = (isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : NULL);
				
				return strtolower($routeMethod) === strtolower($requestMethod);
			}

			/**
			 * Vérifie que le dossier indiqué contenant les controleurs existe
			 *
			 * @throws RouteException
			 */
			protected function checkControllerDir()
			{
				if (is_dir($this->rootFolder)) {
					$this->controllerFolder = str_replace('/',	'\\', $this->rootFolder);
				} else {
					throw new RouteException(RouteException::ROUTE_CONTROLLER_NOTFOUND_ERROR_CODE);
				}
			}

			/**
			 * Vérifie que l'utilisateur à les droits nécéssaire pour acceder à la ressource
			 */
			protected function checkAccessPermissions() { /*TODO : Redifine this on SubClass*/ }


		/* ------------------------ Controller / Action & Params ------------------------ */

			/**
			 * Retourne les paramètres s'il y en a
			 * Exemple :
			 * - Request ('/Test/Testy') && Route ('/Test/:name') => Param['name'] = 'Testy'
			 *
			 * @param array $route
			 * @param array $request
			 *
			 * @return array
			 */
			protected function getParams(array $route, array $request): array
			{
				$params = array();
				$size = count($route);
				
				for ($i=0; $i < $size; $i++) {
					if ($route[$i][0] === ':') {
						array_push($params, rawurldecode($request[$i]));
					}
				}

				return $params;
			}
		
			/**
			 * Créer la route à appeler (Controleur / Méthode / Paramètres)
			 */
			protected function getControllerWithAction()
			{
				$route = reset($this->route);
				
				# Recupère l'action
				$action = $route['Action'];
				
				# Parse l'action
				$action = explode('.', $action);
				
				# Définition de la méthode
				$this->action = end($action);
				
				# Définition du Controller
				$key = array_search($this->action, $action);
				unset($action[$key]);
				$this->controller = $this->controllerFolder . '\\' . implode('\\', $action);
			}
		
		
		/* ------------------------ Prepare Controller ------------------------ */
		
			/**
			 * Importe les Méta Data de la page dans le Controleur
			 *
			 * @param Controller $controller
			 * @return Controller
			 */
			protected function setMetaData(Controller $controller)
			{
				$name = key($this->route);
				
				$metaData = new MetaData($name);
				$controller->setMetaData($metaData);
				
				return $controller;
			}
			
			/**
			 * Importe les Méta Data de la page dans le Controleur
			 *
			 * @param Controller $controller
			 * @return Controller
			 */
			protected function setRequest(Controller $controller, String $userRequest)
			{
				$request = new Request();
				$route = reset($this->route);
				
				$request->setRuleName(key($this->route));
				$request->setRule($route['Rule']);
				$request->setRequestUrl($userRequest);
				
				$controller->setRequest($request);
				
				return $controller;
			}
	}
?>