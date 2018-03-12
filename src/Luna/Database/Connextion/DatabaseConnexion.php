<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : DatabaseConnexion.php
	 *   @Created_at : 10/03/2018
	 *   @Update_at : 10/03/2018
	 * --------------------------------------------------------------------------
	 */
	
	namespace Luna\Database\Connexion;
	
	use \PDO;
	use Luna\Config;
	use Luna\Database\Database;
	use Luna\Database\MySQLDatabase;
	
	class DatabaseConnexion
	{
		protected const DRIVER_DEFAULT = 0;
		protected const DRIVER_PDO_MYSQL = 1;
		
		/** @var DatabaseConnexion */
		protected static $_instance;
		
		/** @var Config */
		protected $ConfigModule;
		
		/** @var PDO */
		protected $DBModule;
		
		/**
		 * DatabaseConnexion constructor.
		 */
		protected function __construct()
		{
			$this->ConfigModule = Config::getInstance();
			$this->prepareConnexion();
		}
		
		/**
		 * Get the Database Connexion instance (Singleton)
		 * @return DatabaseConnexion
		 */
		public static function getInstance(): DatabaseConnexion
		{
			if(is_null(static::$_instance)) {
				static::$_instance = new static();
			}
			return static::$_instance;
		}
		
		/* -------------------------------------------------------------------------- */
		/* CONNEXION */
		
			/**
			 * Return a configured connexion
			 * @return PDO
			 */
			public function getConnection(): PDO
			{
				return $this->DBModule;
			}
			
		
		/* -------------------------------------------------------------------------- */
		/* CONFIGURATION */
		
			/**
			 * Prepare the connexion according to the selected driver
			 */
			protected function prepareConnexion()
			{
				if(is_null($this->DBModule)) {
					switch ($this->getDriver()) {
						case static::DRIVER_PDO_MYSQL :
							$this->DBModule = $this->getMySqlDatabaseConnexion();
							break;
						
						default:
							$this->DBModule = $this->getMySqlDatabaseConnexion();
							break;
					}
				}
			}
		
			/**
			 * @return int|null
			 */
			protected function getDriver()
			{
				if ($this->ConfigModule->get('ShirOS.Database.Driver.PDO_MYSQL')){
					return static::DRIVER_PDO_MYSQL;
				} else {
					return NULL;
				}
			}
		
			/**
			 * Get the MySql Connexion
			 * @return PDO
			 */
			protected function getMySqlDatabaseConnexion(): PDO
			{
				$mySql = new MySQLDatabase(
					$this->ConfigModule->get('ShirOS.Database.Connect.dbName'),
					$this->ConfigModule->get('ShirOS.Database.Connect.dbUser'),
					$this->ConfigModule->get('ShirOS.Database.Connect.dbPass'),
					$this->ConfigModule->get('ShirOS.Database.Connect.dbHost')
				);
				
				return $mySql->getPDO();
			}
	}
?>