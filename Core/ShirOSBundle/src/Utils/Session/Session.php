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
		protected const AUTH = "Auth";
		protected const NAV = "Navigation";
		protected const NAV_BACK = "Back";
		protected const NAV_CURRENT = "Current";
		protected const NAV_IS_BACK = "Is_Back";
	
		
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
		 * Contient l'url du site
		 * @var String
		 */
		protected $siteUrl;
		
		
		/**
		 * Session constructor, Singleton
		 */
		protected function __construct() {
			$this->ConfigModule = Config::getInstance();
			$this->siteUrl = $this->ConfigModule->get('Server.Homepage');
		}

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
		public function initSession(?string $name = NULL) {
			if(empty($_SESSION)) {
				if (!is_null($name)) { session_name($name); }
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
				return isset($_SESSION[self::AUTH]);
			}

			/**
			 * Initialise la Session d'Authentification
			 *
			 * @param array $auth
			 */
			public function authInit(array $auth)
			{
				$this->initSession($auth[$this->ConfigModule->get('ShirOS.Session.Id')]);
				$_SESSION[self::AUTH] = $auth;
			}

			/**
			 * Créer/Edit la Session d'Authentification
			 *
			 * @param array $auth
			 */
			public function authEdit(array $auth)
			{
				foreach ($auth as $key => $value)
					if(isset($_SESSION[self::AUTH][$key]))
						$_SESSION[self::AUTH][$key] = $value;
			}

			/**
			 * Détruit la Session d'Authentification
			 */
			public function authDestroy()
			{
				session_destroy();
				unset($_SESSION[self::AUTH]);
			}
		
			/**
			 * Récupère la valeur associé à la clé dans la Session d'Authentification
			 *
			 * @param string $key
			 *
			 * @return null|string
			 */
			public function authValueFor(string $key): ?string { return (($this->isAuthSession() && isset($_SESSION[self::AUTH][$key])) ? $_SESSION[self::AUTH][$key] : NULL); }


		/* ------------------------ Fonctions de Navigation ------------------------ */

			/**
			 * Initialise la Session de Navigation
			 */
			public function navInit()
			{
				if(empty($_SESSION[self::NAV][$this->siteUrl]) && !isset($_SESSION[self::NAV][$this->siteUrl]))
				{
					$url = array(
						self::NAV_BACK => array(),
						self::NAV_CURRENT => "",
						self::NAV_IS_BACK => false
					);

					$_SESSION[self::NAV][$this->siteUrl] = $url;
				}
			}
		
			/**
			 * Assigne l'url courante dans la Session de Navigation
			 */
			public function navSet()
			{
				if($this->urlFilter($_SESSION[self::NAV][$this->siteUrl][self::NAV_CURRENT])) {
					if(!$_SESSION[self::NAV][$this->siteUrl][self::NAV_IS_BACK]) {
						if(strtolower(reset($_SESSION[self::NAV][$this->siteUrl][self::NAV_BACK])) != strtolower($_SESSION[self::NAV][$this->siteUrl][self::NAV_CURRENT])) {
							array_unshift($_SESSION[self::NAV][$this->siteUrl][self::NAV_BACK], $_SESSION[self::NAV][$this->siteUrl][self::NAV_CURRENT]);

							if(sizeof($_SESSION[self::NAV][$this->siteUrl][self::NAV_BACK]) > 10)
								array_pop($_SESSION[self::NAV][$this->siteUrl][self::NAV_BACK]);
						}
					}
					else
						$_SESSION[self::NAV][$this->siteUrl][self::NAV_IS_BACK] = false;
				}

				$_SESSION[self::NAV][$this->siteUrl][self::NAV_CURRENT] = $_SERVER['REQUEST_URI'];
			}

			/**
			 * Retourne à l'url précendante
			 */
			public function navBack()
			{
				if(strtolower(reset($_SESSION[self::NAV][$this->siteUrl][self::NAV_BACK])) == strtolower($_SESSION[self::NAV][$this->siteUrl][self::NAV_CURRENT]))
					array_shift($_SESSION[self::NAV][$this->siteUrl][self::NAV_BACK]); // Shift pour le rechargement de Page lors de l'action "Retour"

				if(sizeof($_SESSION[self::NAV][$this->siteUrl][self::NAV_BACK]) != 0) {
					$urlBack = array_shift($_SESSION[self::NAV][$this->siteUrl][self::NAV_BACK]); // Recup de l'url dans la list des "URL_BACK"
					
					$_SESSION[self::NAV][$this->siteUrl][self::NAV_IS_BACK] = true;
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