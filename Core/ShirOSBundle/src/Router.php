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
	
	namespace ShirOSBundle;
	use \Exception;
	use \PDOException;
	use ShirOSBundle\Utils\Exception\RouteException;
	use ShirOSBundle\Utils\Exception\LoginException;
	use ShirOSBundle\Utils\Exception\DatabaseException;
	
	use ShirOSBundle\View\Render;
	use ShirOSBundle\View\MetaData;
	use ShirOSBundle\Utils\HTTP\HTTP;
	use ShirOSBundle\Utils\HTTP\Request;
	use ShirOSBundle\Controller\Controller;

	class Router
	{
		/**
		 * Contient l'instance de la classe
		 * @var Router
		 */
		protected static $_instance;
		
		/**
		 * Contient le chemin du fichier des routes
		 * @var string
		 */
		protected static $routing_path = 'Config/route.php';
		
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
		 * Clé des Routes à ignorer lors de la vérification de l'existence des routes
		 * @var array
		 */
		protected $prohibitedKeys = array(
			'ROOT_FOLDER',
		);

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
		 * Construteur de la classe 'AppRouter', Singleton
		 *
		 * @param string $filePath
		 */
		protected function __construct(string $filePath)
		{
			$this->routes = require($filePath);
			$this->RenderModule = new Render();
		}

		/**
		 * Retourne l'instance de la classe 'Router'
		 *
		 * @param string $filePath | Default Value => NULL
		 *
		 * @return Router
		 */
		public static function getInstance(string $filePath = NULL)
		{
			if(is_null($filePath))
				$filePath = self::$routing_path;

			if(is_null(self::$_instance))
				self::$_instance = new Router($filePath);
			return self::$_instance;
		}

		/* ------------------------ Init Router ------------------------ */
			
			/**
			 * Point d'entré de l'application
			 */
			public function init()
			{
				try {
					$this->launch();
				} catch (RouteException $re) {
					# Gére les Exceptions des Routes
					switch ($re->getCode()) {
						case RouteException::ROUTE_NOTFOUND_ERROR_CODE:
							$this->RenderModule->notFound($re->getMessage());
							break;

						case RouteException::ROUTE_CONTROLLER_NOTFOUND_ERROR_CODE:
							$this->RenderModule->notFound($re->getMessage());
							break;

						case RouteException::ROUTE_FORBIDDEN_ERROR_CODE:
							$this->RenderModule->forbidden($re->getMessage());
							break;

						case RouteException::ROUTE_METHODE_NOT_ALLOWED_ERROR_CODE:
							$this->RenderModule->error(HTTP::METHOD_NOT_ALLOWED, $re->getMessage());
							break;

						case RouteException::ROUTE_GONE_ERROR_CODE:							
							$this->RenderModule->error(HTTP::GONE, $re->getMessage());
							break;
						
						case RouteException::ROUTE_INTERNAL_SERVER_ERROR_ERROR_CODE:
							$this->RenderModule->error(HTTP::INTERNAL_SERVER_ERROR, $re->getMessage());
							break;
						
						default:
							$this->RenderModule->internalServerError();
							break;
					}
				} catch (PDOException $pdo) {
					# Gére les Exceptions de Connexion à la Base de Données
					$this->RenderModule->internalServerError($pdo->getMessage());
				} catch (DatabaseException $dbe) {
					# Gére les Exceptions de Connexion à la Base de Données
					switch ($dbe->getCode()) {
						case DatabaseException::DATABASE_METHODE_NOT_ALLOWED_ERROR_CODE:
							$this->RenderModule->error(HTTP::METHOD_NOT_ALLOWED, $dbe->getMessage());
							break;

						case DatabaseException::DATABASE_NOT_IMPLEMENTED_ERROR_CODE:
							$this->RenderModule->error(HTTP::NOT_IMPLEMENTED, $dbe->getMessage());
							break;

						case DatabaseException::DATABASE_BAD_GATEWAY_ERROR_CODE:
							$this->RenderModule->error(HTTP::BAD_GATEWAY, $dbe->getMessage());
							break;
						
						default:						
							$this->RenderModule->internalServerError();
							break;
					}
				} catch (LoginException $le) {
					# Gére les Exceptions du Login
					switch ($le->getCode()) {
						case LoginException::AUTHENTIFICATION_FAILED_ERROR_CODE:
							$this->RenderModule->error(HTTP::UNAUTHORIZED, $le->getMessage());
							break;

						case LoginException::AUTHENTIFICATION_TOKEN_FAILED_ERROR_CODE:
							$this->RenderModule->error(HTTP::UNAUTHORIZED, $le->getMessage());
							break;
						
						default:
							$this->RenderModule->internalServerError();
							break;
					}
				} catch (Exception $exception) {
					$this->catchOtherException($exception);
				}
			}
		
		/**
		 * Gère les cas d'erreurs inconnue
		 * @param Exception $exception
		 */
		public function catchOtherException(Exception $exception)
		{
			/*TODO : Redifine this on SubClass*/
			$this->RenderModule->error($exception->getCode(), $exception->getMessage());
		}
			
			
		
		/**
		 * Initialise le traitement de la requête et sa redirection
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
			
			// Set MetaData
			$this->setMetaData($controller);
			// Set Request
			$this->setRequest($controller);
			
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
				foreach ($this->prohibitedKeys as $key) {
					if (in_array($key, $keysRoutes)) {
						unset($routes[$key]);
					}
				}
				
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
			protected function clearRoute(Array $requestTab): array { return array_values(array_filter($requestTab)); }


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
				if (is_dir($this->routes['ROOT_FOLDER'])) {
					$this->controllerFolder = str_replace('/',	'\\', $this->routes['ROOT_FOLDER']);
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
			protected function setRequest(Controller $controller)
			{
				$request = new Request();
				// TODO : Set differents informations in the Request Object.
				
				$controller->setRequest($request);
				
				return $controller;
			}
	}
?>