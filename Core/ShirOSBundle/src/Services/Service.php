<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : Service.php
	 *   @Created_at : 02/12/2017
	 *   @Update_at : 02/12/2017
	 * --------------------------------------------------------------------------
	 */
	
	namespace ShirOSBundle\Services;

	use ShirOSBundle\ApplicationService;
	use ShirOSBundle\Config;
	use ShirOSBundle\Utils\Session\Session;

	class Service
	{
		/**
		 * Instance de la Classe de gestion des Configs
		 * @var Config
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
		 * Service constructor.
		 */
		public function __construct()
		{
			$this->ApplicationModule = ApplicationService::getInstance();

			$this->ConfigModule = Config::getInstance();
			$this->SessionModule = Session::getInstance();
		}


		/* ------------------------ Fonctions de Chargement du Manager ------------------------ */

			/**
			 * Permet de Charger au préalable un Manager, pour accerder à des requêtes SQL
			 *
			 * @param string $managerName
			 */
			protected function loadManager(string $managerName) { $this->$managerName = $this->ApplicationModule->getManager($managerName); }
	}
?>