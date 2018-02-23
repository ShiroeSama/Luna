<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : Url.php
	 *   @Created_at : 03/12/2017
	 *   @Update_at : 03/12/2017
	 * --------------------------------------------------------------------------
	 */
	
	namespace ShirOSBundle\Utils\Url;
	
	use ShirOSBundle\Config;
	
	class Url
	{
		/**
		 * Instance de la Classe de gestion des Configs
		 * @var Config
		 */
		protected $ConfigModule;
		
		/**
		 * Contient l'url de la page d'accueil
		 * @var string
		 */
		protected $rootUrl;
		
		/**
		 * Contient l'url de la page d'accueil
		 * @var string
		 */
		protected $homeUrl;
		
		/**
		 * Contient toutes les routes et régles
		 * @var array
		 */
		protected $routes = [];
		
		/**
		 * Url constructor.
		 *
		 * @param string $homeUrl
		 */
		public function __construct(string $homeUrl) {
			$this->ConfigModule = Config::getInstance();
			$this->rootUrl = rtrim(trim($this->ConfigModule->get('Server.Homepage')), '/');
			$this->homeUrl = $homeUrl;
			
			$routeFile = require(SHIROS_ROUTES);
			$this->routes = $routeFile['ROUTES'];
		}
		
		/**
		 * Vérifie que la valeur en paramètre est dans l'énumeration
		 *
		 * @param string $url | Default Value = NULL
		 * @param array $params
		 *
		 * @return string
		 */
		public function getUrl(string $url = NULL, array $params = []): string
		{
			if (is_null($url)) { return $this->homeUrl; }
			
			if (array_key_exists($url, $this->routes)) {
				$rule = $this->routes[$url]['Rule'];
				
				foreach ($params as $key => $value) { $rule = str_replace(':' . $key, $value, $rule); }
				$rule = preg_replace('#\:[a-zA-Z0-9]*\/?#', '', $rule);
				
				return $this->rootUrl . $rule;
			} else {
				if (strstr($url, $this->homeUrl)) { return $url; }
				else {
					$url = explode('.', $url);
					if (is_array($url)) { $url = implode('/', $url); }
					
					$this->homeUrl = rtrim(trim($this->homeUrl), '/');
					return $this->homeUrl . '/' . $url;
				}
			}
		}
		
		/**
		 * Revoie l'utilisateur sur une autre page
		 *
		 * @param string $url
		 */
		public function goTo(string $url = NULL) { die(header('Location: ' . $this->getUrl($url))); }
	}
?>