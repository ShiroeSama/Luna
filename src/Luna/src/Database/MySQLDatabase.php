<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : MySQLDatabase.php
	 *   @Created_at : 24/11/2016
	 *   @Update_at : 10/07/2017
	 * --------------------------------------------------------------------------
	 */
	
	namespace ShirOSBundle\Database;
	use \PDO;
	use ShirOSBundle\Config;
	
	/**
	 * Gestion de l'accés à une base de données
	 * System : MySQL
	 */

	class MySQLDatabase implements Database
	{
		/**
		 * Instance de Config
		 * @var Config
		 */
		private $ConfigModule;
		
		/**
		 * Contient de la nom de la base de données
		 * @var string
		 */
		private $db_name;

		/**
		 * Contient l'identifiant de connexion
		 * @var string
		 */
		private $db_user;

		/**
		 * Contient le password de connexion
		 * @var string
		 */
		private $db_pass;

		/**
		 * Contient l'ip (Host) de connexion a la base de données
		 * @var string
		 */
		private $db_host;

		/**
		 * Instance de PDO
		 * @var PDO
		 */
		private $pdo;
		
		
		/**
		 * MySQLDatabase constructor.
		 *
		 * @param string $db_name
		 * @param string $db_user
		 * @param string $db_pass
		 * @param string $db_host
		 */
		public function __construct(string $db_name, string $db_user, string $db_pass, string $db_host)
		{
			$this->db_name = $db_name;
			$this->db_user = $db_user;
			$this->db_pass = $db_pass;
			$this->db_host = $db_host;

			$this->ConfigModule = Config::getInstance();
			
			$this->connect();
		}
		
		
		/**
		 * Fonction permettant la connexion a la DB
		 */
		protected function connect()
		{
			$pdo = new PDO("mysql:dbname={$this->db_name};host={$this->db_host}", $this->db_user , $this->db_pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->pdo = $pdo;
		}
		
		/**
		 * Permet de construire une requete auprès de la DB
		 *
		 * @param string $queryString
		 * @param $class
		 * @param bool $one | Default Value = false
		 *
		 * @return array|mixed|\PDOStatement
		 */
		public function query(string $queryString, $class, bool $one = false)
		{
			$req = $this->pdo->query($queryString);
			
			if(stripos(trim($queryString), 'UPDATE') === 0
				|| stripos(trim($queryString), 'INSERT') === 0
				|| stripos(trim($queryString), 'DELETE') === 0) {
				return $req;
			} else {
				switch ($this->ConfigModule->get('ShirOS.Database.FetchMode.Current')) {
					case $this->ConfigModule->get('ShirOS.Database.FetchMode.Name.Fetch_Class'):
						$req->setFetchMode(PDO::FETCH_CLASS, $class);
						break;
					
					case $this->ConfigModule->get('ShirOS.Database.FetchMode.Name.Fetch_Into'):
						$req->setFetchMode(PDO::FETCH_INTO, $class);
						break;
						
					default:
						break;
				}
				
				$datas = ($one ? $req->fetch() : $req->fetchAll());
				return $datas;
			}
		}
		
		
		/**
		 * Permet de construire une requete prépare auprès de la DB (Pour eviter les injections SQL)
		 *
		 * @param string $queryString
		 * @param array $attributes
		 * @param $class
		 * @param bool $one | Default Value = false
		 *
		 * @return array|bool|mixed
		 */
		public function prepare(string $queryString, array $attributes, $class, bool $one = false)
		{
			$req = $this->pdo->prepare($queryString);
			$res = $req->execute($attributes);
			
			if(stripos(trim($queryString), 'UPDATE') === 0
				|| stripos(trim($queryString), 'INSERT') === 0
				|| stripos(trim($queryString), 'DELETE') === 0) {
				return $res;
			} else {
				switch ($this->ConfigModule->get('ShirOS.Database.FetchMode.Current')) {
					case $this->ConfigModule->get('ShirOS.Database.FetchMode.Name.Fetch_Class'):
						$req->setFetchMode(PDO::FETCH_CLASS, $class);
						break;
					
					case $this->ConfigModule->get('ShirOS.Database.FetchMode.Name.Fetch_Into'):
						$req->setFetchMode(PDO::FETCH_INTO, $class);
						break;
					
					default:
						break;
				}
				
				$datas = ($one ? $req->fetch() : $req->fetchAll());
				return $datas;
			}
		}		
	}
?>