<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : ApplicationKernelphp
	 *   @Created_at : 03/12/2017
	 *   @Update_at : 03/12/2017
	 * --------------------------------------------------------------------------
	 */
	
	namespace ShirOSBundle;
	use ShirOSBundle\Config;
    use ShirOSBundle\Database\Database;
    use ShirOSBundle\Database\Gateway\Manager;
    use ShirOSBundle\Utils\Url\Url;
	use ShirOSBundle\Database\MySQLDatabase;

	class ApplicationKernel
	{
		/**
		 * Contient l'instance de la classe
		 * @var ApplicationKernel
		 */
		protected static $_instance;

		/**
		 * Instance de la Classe de Base de Données
		 * @var MySQLDatabase
		 */
		protected $DBModule;

		/**
		 * Instance de la Classe de gestion des Configs
		 * @var Config
		 */
		protected $ConfigModule;

		/**
		 * Instance de la Classe de gestion des Url
		 * @var Url
		 */
		protected $UrlModule;
		
		
		/**
		 * ApplicationKernel constructor, Singleton
		 */
		protected function __construct()
		{
			$this->ConfigModule = Config::getInstance();
			$this->UrlModule = new Url();
		}
		
		/**
		 * Retourne l'instance de la classe 'App'
		 *
		 * @return ApplicationKernel
		 */
		public static function getInstance(): ApplicationKernel
		{
			if(is_null(static::$_instance))
				static::$_instance = new static();
			
			return static::$_instance;
		}
		

		/* ------------------------ Accès à la DAL (Database) ------------------------ */

			/**
			 * Recupère l'instance de la DB
			 *
			 * @return Database
			 */
			public function getDatabase(): Database
			{
				if(is_null($this->DBModule)) {
					if($this->ConfigModule->get('ShirOS.Database.Driver.MySQL_PDO')) {
						return $this->getMySqlDatabase();
					}
				}
				return $this->DBModule;
			}

			/**
			 * Recupère l'instance de la DB
			 *
			 * @return MySqlDatabase
			 */
			protected function getMySqlDatabase(): MySQLDatabase
			{
				return new MySQLDatabase(
					$this->ConfigModule->get('ShirOS.Database.Connect.dbName'),
					$this->ConfigModule->get('ShirOS.Database.Connect.dbUser'),
					$this->ConfigModule->get('ShirOS.Database.Connect.dbPass'),
					$this->ConfigModule->get('ShirOS.Database.Connect.dbHost')
				);
			}

			/**
			 * Recupère un Manager pour une Gateway spécifique
			 *
			 * @param string $name
			 *
			 * @return Manager
			 */
			public function getManager(string $name): Manager { return new Manager($name, $this->getDatabase()); }



		/* ------------------------ Récupèration des Css ------------------------ */

			/**
			 * Recupère une liste de feuille Css
			 *
			 * @return string
			 */
			public function getBundleCss(): string
			{
				$css = '';
				$dir = SHIROS_WEB_CSS;
				$prohibitedDirCss = array(
					'.',
					'..',
				);

				if(file_exists($dir))
				{
					$files = scandir($dir);

					foreach ($files as $file) 
					{
						if(in_array($file, $prohibitedDirCss))
							continue;

						$css .= "<link type=\"text/css\" rel=\"stylesheet\" href=\"{$this->UrlModule->getUrl()}/{$dir}/{$file}\" />\n";
					}
				}

				return $css;
			}
		
			/**
			 * Recupère une liste de feuille Css
			 *
			 * @param string $dir
			 * @return string
			 */
			public function getCss(string $dir)
			{
				$css = "";
				$prohibitedDirCss = array(
					'.',
					'..',
					'Users',
					'Fonts',
				);
				
				if(file_exists($dir))
				{
					$files = scandir($dir);
					
					foreach ($files as $file)
					{
						if(in_array($file, $prohibitedDirCss))
							continue;
						
						$css .= "<link type=\"text/css\" rel=\"stylesheet\" href=\"{$this->UrlModule->getUrl()}/{$dir}/{$file}\" />\n";
					}
				}
				
				return $css;
			}
		
		
		/* ------------------------ Récupèration des Js ------------------------ */
		
			/**
			 * Recupère une liste de fonction Js
			 *
			 * @param string $dir
			 * @return string
			 */
			public function getJs(String $dir)
			{
				$js = "";
				$prohibitedDirJs = array(
					'.',
					'..'
				);
				
				if(file_exists($dir))
				{
					$files = scandir($dir);
					
					foreach ($files as $file)
					{
						if(in_array($file, $prohibitedDirJs))
							continue;
						
						$js .= "<script type=\"text/javascript\" src=\"{$this->UrlModule->getUrl()}/{$dir}/{$file}\" ></script>\n";
					}
				}
				
				return $js;
			}
	}
?>