<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : Session.php
	 *   @Created_at : 28/01/2017
	 *   @Update_at : 03/12/2017
	 * --------------------------------------------------------------------------
	 */

	namespace ShirOSBundle\Utils\Session;
	use ShirOSBundle\Config;

	class Session
	{	
		/**
		 * Instance de la Classe de gestion des Configs
		 * @var Config
		 */
		protected $ConfigModule;

		/**
		 * Contient l'instance de la classe
		 * @var Session
		 */
		protected static $_instance;
		
		
		/**
		 * Session constructor, Singleton
		 */
		protected function __construct() { $this->ConfigModule = Config::getInstance(); }

		/**
		 * Retourne l'instance de la classe 'Session'
		 *
		 * @return Session
		 */
		public static function getInstance(): Session
		{
			if(is_null(self::$_instance))
				self::$_instance = new Session();
			return self::$_instance;
		}

		/**
		 * Démarre la Session
		 */
		public function initSession() {
			if(empty($_SESSION)) {
				session_start();
			}
		}


		/* ------------------------ Fonctions d'Authentification ------------------------ */

			/**
			 * Verifie s'il existe une Session d'Authentification
			 *
			 * @return bool
			 */
			public function isAuthSession(): bool
			{
				return isset($_SESSION['auth']);
			}

			/**
			 * Initialise la Session d'Authentification
			 *
			 * @param array $auth
			 */
			public function authInit(array $auth)
			{
				session_name($auth[$this->ConfigModule->get('ShirOS.Session.Id')]);
				$this->initSession();
				$_SESSION['auth'] = $auth;
			}

			/**
			 * Créer/Edit la Session d'Authentification
			 *
			 * @param array $auth
			 */
			public function authEdit(array $auth)
			{
				foreach ($auth as $key => $value)
					if(isset($_SESSION['auth'][$key]))
						$_SESSION['auth'][$key] = $value;
			}

			/**
			 * Détruit la Session d'Authentification
			 */
			public function authDestroy()
			{
				session_destroy();
				unset($_SESSION['auth']);
			}
		
			/**
			 * Récupère la valeur associé à la clé dans la Session d'Authentification
			 *
			 * @param string $key
			 *
			 * @return null|string
			 */
			public function authValueFor(string $key): ?string { return (($this->isAuthSession() && isset($_SESSION['auth'][$key])) ? $_SESSION['auth'][$key] : NULL); }


		/* ------------------------ Fonctions de Navigation ------------------------ */

			/**
			 * Initialise la Session de Navigation
			 */
			public function navInit()
			{
				if(empty($_SESSION['url']) && !isset($_SESSION['url']))
				{
					$url = array(
						'URL_BACK' => array(),
						'URL_CURRENT' => "",
						'IS_BACK' => false
					);

					$_SESSION['url'] = $url;
				}
			}
		
			/**
			 * Assigne l'url courante dans la Session de Navigation
			 */
			public function navSet()
			{
				if($this->urlFilter($_SESSION['url']['URL_CURRENT'])) {
					if(!$_SESSION['url']['IS_BACK']) {
						if(strtolower(reset($_SESSION['url']['URL_BACK'])) != strtolower($_SESSION['url']['URL_CURRENT'])) {
							array_unshift($_SESSION['url']['URL_BACK'], $_SESSION['url']['URL_CURRENT']);

							if(sizeof($_SESSION['url']['URL_BACK']) > 10)
								array_pop($_SESSION['url']['URL_BACK']);
						}
					}
					else
						$_SESSION['url']['IS_BACK'] = false;
				}

				$_SESSION['url']['URL_CURRENT'] = $_SERVER['REQUEST_URI'];
			}

			/**
			 * Retourne à l'url précendante
			 */
			public function navBack()
			{
				if(strtolower(reset($_SESSION['url']['URL_BACK'])) == strtolower($_SESSION['url']['URL_CURRENT']))
					array_shift($_SESSION['url']['URL_BACK']); // Shift pour le rechargement de Page lors de l'action "Retour"

				if(sizeof($_SESSION['url']['URL_BACK']) != 0) {
					$urlBack = array_shift($_SESSION['url']['URL_BACK']); // Recup de l'url dans la list des "URL_BACK"
					
					$_SESSION['url']['IS_BACK'] = true;
					header('Location: ' . $urlBack);
				} else
					header('Location: /');

				exit();
			}



		/* ------------------------ Private Function ------------------------ */

			/**
			 * Filtre les Urls
			 *
			 * @param string $url
			 *
			 * @return bool
			 */
			private function urlFilter(string $url)
			{
				$bool = true;
				
				/** @var array $urlBan */
				$urlBan = $this->ConfigModule->get('ShirOS.Session.Url_Ban');

				foreach ($urlBan as $value)
					$bool &= !strstr($url, $value);

				return $bool;
			}
	}	
?>