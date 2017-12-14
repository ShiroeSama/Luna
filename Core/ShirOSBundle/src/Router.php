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
		 * Contient la route actuel
		 * @var string
		 */
		protected $path;

		/**
		 * Contient toutes les routes et régles
		 * @var array
		 */
		protected $routes = [];

		/**
		 * Clé des Routes à ignorer lors de la vérification de l'existence des routes
		 * @var array
		 */
		protected $prohibitedKey = array(
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
			
			$route = $this->matchRoute($requestTab);
			$this->createRoute($route);
			
			$this->checkAccessPermissions();
			
			$class = $this->controller;
			$controller = new $class();
			$controller = $this->setMetaData($controller);
			
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
			protected function checkRoute(array $route, array $request): bool
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
		
			/**
			 * Permet de voir si la route existe, puis retourne le controleur et la méthode à utiliser pour cette requête
			 *
			 * @param array $requestTab
			 *
			 * @return string
			 * @throws RouteException
			 */
			protected function matchRoute(array $requestTab): string
			{
				$requestTab = $this->clearRoute($requestTab);
				
				if(empty($requestTab)) { array_push($requestTab, "/"); }
				$routes = $this->getRoutes($this->routes);

				foreach ($routes as $route) {
					$route = $this->clearRoute($route);
					
					if (count($route) === count($requestTab) && $this->checkRoute($route, $requestTab)) {
						$this->params = $this->getParams($route, $requestTab);
						$path = $this->createPath($route);

						$this->path = $path;
						return $this->routes[$path];
					}
				}

				throw new RouteException(RouteException::ROUTE_NOTFOUND_ERROR_CODE);
			}


		/* ------------------------ Route Getter ------------------------ */

			/**
			 * Recupère les routes (règles de routage) et décompose les régles
			 * Exemple :
			 * - array(
			 * 	'/' => ...,
			 * 	'/Test' => ...,
			 * 	'/Test/:name' => ...,
			 * )
			 *
			 * <=> array(
			 * 	0 => array('/'),
			 * 	1 => array('Test'),
			 * 	2 => array('Test', ':name'),
			 * )
			 *
			 * @param array $lists
			 *
			 * @return array
			 */
			protected function getRoutes(array $lists): array
			{
				$routes = array();
				foreach ($lists as $key => $value) {
					if(in_array($key, $this->prohibitedKey))
						continue;

					$explode = (($key == '/') ? array('/') : explode('/', $key));
					array_push($routes, $explode);
				}
				return $routes;
			}

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


		/* ------------------------ Format & Create ------------------------ */

			/**
			 * Formate la Requête
			 *
			 * @param string $REQUEST_URI
			 * @param string $SCRIPT_NAME
			 *
			 * @return array
			 */
			protected function formatRequest(String $REQUEST_URI, String $SCRIPT_NAME): array
			{
				$REQUEST_URI = preg_replace('#\?[^>]*$#', '', $REQUEST_URI);

				$requestTab		= explode('/', $REQUEST_URI);
				$scriptTab		= explode('/', $SCRIPT_NAME);

				foreach ($requestTab as $key => $value) {
					if (in_array($value, $scriptTab)) {
						unset($requestTab[$key]);
					}
				}

				return array_values($requestTab);
			}

			/**
			 * Nettoie la route en enlevant les valeurs vides
			 *
			 * @param array $requestTab
			 *
			 * @return array
			 */
			protected function clearRoute(Array $requestTab): array { return array_values(array_filter($requestTab)); }

			/**
			 * Créer le chemin pour récupérer le controleur et sa méthode par la suite
			 * Exemple :
			 * - array(
			 * 	0 => 'Test',
			 * 	1 =>':name',
			 * )
			 *
			 * <=> 'Test/:name'
			 *
			 * @param array $path
			 *
			 * @return string
			 */
			protected function createPath(array $path): string
			{
				$path = implode('/', $path);
				return (($path === DIRECTORY_SEPARATOR) ? $path : DIRECTORY_SEPARATOR . $path);
			}

			/**
			 * Créer la route à appeler (Controleur / Méthode / Paramètres)
			 *
			 * @param string $route
			 */
			protected function createRoute(string $route)
			{
				# Parse de la Route
				$route = explode('.', $route);

				# Définition de la méthode
				$this->action = end($route);

				# Définition du Controller
				$key = array_search($this->action, $route);
				unset($route[$key]);
				$this->controller = $this->controllerFolder . '\\' . implode('\\', $route);
			}
		
			/**
			 * Importe les Méta Data de la page dans le Controleur
			 *
			 * @param Controller $controller
			 * @return Controller
			 */
			protected function setMetaData(Controller $controller)
			{
				$metaData = new MetaData($this->path);
				$controller->setMetaData($metaData);
				
				return $controller;	
			}
	}
?>