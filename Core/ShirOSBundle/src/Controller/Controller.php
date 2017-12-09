<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : Controller.php
	 *   @Created_at : 24/11/2016
	 *   @Update_at : 10/07/2017
	 * --------------------------------------------------------------------------
	 */

	namespace ShirOSBundle\Controller;

	use ShirOSBundle\Config;
	use ShirOSBundle\Utils\Exception\RouteException;
    use ShirOSBundle\Utils\HTTP\Request;
    use ShirOSBundle\View\Render;
	use ShirOSBundle\View\MetaData;
	use ShirOSBundle\Utils\Url\Url;
	use ShirOSBundle\ApplicationService;
	use ShirOSBundle\Utils\Session\Session;
	
	class Controller
	{
		/**
		 * Instance de la Classe de gestion des Configs
		 * @var ApplicationService
		 */
		protected $ApplicationModule;

		/**
		 * Instance de la Classe de gestion des Configs
		 * @var Config
		 */
		protected $ConfigModule;

		/**
		 * Instance de la Classe de gestion des Sessions
		 * @var Session
		 */
		protected $SessionModule;

		/**
		 * Instance de la Classe de gestion des Url
		 * @var Url
		 */
		protected $UrlModule;

		/**
		 * Instance de la Classe de gestion de Rendu
		 * @var MetaData
		 */
		protected $MetaDataModule;
		
		/**
		 * Instance de la Classe de gestion de Rendu
		 * @var Render
		 */
		protected $RenderModule;

        /**
         * Instance de la Classe de gestion des Requêtes
         * @var Request
         */
        protected $RequestModule;
		
		
		/**
		 * Controller constructor.
		 */
		public function __construct()
		{
			$this->ApplicationModule = ApplicationService::getInstance();

			$this->ConfigModule = Config::getInstance();
			$this->SessionModule = Session::getInstance();
			
			$this->UrlModule = new Url('Server.Homepage');
			$this->RenderModule = new Render();
			$this->RequestModule = new Request();
		}
		
		/**
		 *  Renvoie un Exception au Router en cas de méthode non existante
		 *
		 *  @param string $name
		 *  @param $arguments
		 *  @throws RouteException
		 */
		public function __call(string $name, $arguments)
		{
			if (!method_exists($this, $name))
				throw new RouteException();
		}


		/* ------------------------ Fonctions de Chargement du Manager ------------------------ */

			/**
			 * Permet de Charger au préalable un Manager, pour accerder à des requêtes SQL
			 *
			 * @param string $managerName
			 */
			protected function loadManager(string $managerName) { $this->$managerName = $this->ApplicationModule->getManager($managerName); }



		/* ------------------------ Gestion des Vues ------------------------ */

			/**
			 * Permet de donner au controleur les méta datas de la page à afficher
			 */
			public function setMetaData(MetaData $metaData) { $this->MetaDataModule = $metaData; }

			/**
			 * Rend la View correspondant a celle demander en paramètre
			 *
			 * @param string $view
			 * @param array $variables | Default Value = []
			 */
			protected function render(string $view, array $variables = [])
			{
				if (is_null($this->MetaDataModule)) { $this->MetaDataModule = new MetaData('/'); }
				$variables['MetaDataModule'] = $this->MetaDataModule;
				$variables['UrlModule'] = $this->UrlModule;
				
				$this->RenderModule->show($view, $variables);
			}

			/**
			 * Permet l'inclusion d'une vue
			 *
			 * @param string $view
			 * @param array $variables | Default Value = []
			 */
			protected function include(string $view, array $variables = [])
			{
				$variables['UrlModule'] = $this->UrlModule;
				
				$this->RenderModule->include($view, $variables);
			}

			/**
			 * Fonction appelant la page Forbidden (403)
			 *
			 * @param string $message | Default Value = NULL
			 */
			public function forbidden(string $message = NULL) { $this->RenderModule->forbidden($message); }

			/**
			 * Fonction appelant la page NotFound (404)
			 *
			 * @param string $message | Default Value = NULL
			 */
			public function notFound(string $message = NULL) { $this->RenderModule->notFound($message); }

			/**
			 * Fonction appelant la page InternalServerError (500)
			 *
			 * @param string $message | Default Value = NULL
			 */
			public function internalServerError(string $message = NULL) { $this->RenderModule->internalServerError($message); }

			/**
			 * Fonction appelant la page InternalServerError (500)
			 *
			 * @param int $code
			 * @param string $message | Default Value = NULL
			 */
			public function error(int $code, string $message = NULL) { $this->RenderModule->error($code, $message); }
	}
?>