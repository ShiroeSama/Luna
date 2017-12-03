<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : MySQLGateway.php
	 *   @Created_at : 24/11/2016
	 *   @Update_at : 02/12/2017
	 * --------------------------------------------------------------------------
	 */

	namespace ShirOSBundle\Database\Gateway;
	use ShirOSBundle\Config;
	use ShirOSBundle\Database\MySQLDatabase;
	use ShirOSBundle\Model\Model;
	use ShirOSBundle\Utils\Exception\DatabaseException;
	use ShirOSBundle\Utils\NameSupervisor\NameSupervisor;

	class MySQLGateway implements Gateway
	{
		/**
		 * Instance de la Classe de la base de données
		 * @var MySQLDatabase
		 */
		protected $DBModule;

		/**
		 * Instance de la Classe de gestion des Configs
		 * @var Config
		 */
		protected $ConfigModule;

		/**
		 * Nom de la Table
		 * @var String
		 */
		protected $table;
		
		
		/**
		 * MySQLGateway constructor.
		 *
		 * @param MySQLDatabase $database
		 */
		public function __construct(MySQLDatabase $database)
		{
			$this->DBModule = $database;
			$this->ConfigModule = Config::getInstance();
			
			if(is_null($this->table))
			{
				$parse = explode('\\', get_class($this));
				$class_name = end($parse);
				$this->table = strtolower(str_replace($this->ConfigModule->get('ShirOS.Namespace.FolderName.Gateway'), '', $class_name));
			}
		}




		/* ------------------------ Préparation des Reqêtes ------------------------ */
		
			/**
			 * Permet d'unifier l'appel d'une requete, et choisi automatiquement en fonction de si un attribut lui est passer, la méthode prepare ou query de la DB
			 *
			 * @param String $request
			 * @param array $attributes | Default Value = NULL
			 * @param bool $one | Default Value = false
			 *
			 * @return mixed
			 */
			public function query(String $request, array $attributes = NULL, $one = false)
			{
				switch ($this->ConfigModule->get('ShirOS.Database.FetchMode.Current')) {
					case $this->ConfigModule->get('ShirOS.Database.FetchMode.Name.Fetch_Class'):
						$class = NameSupervisor::getInstance()->GatewayModel_Path(get_class($this));
						break;
					
					case $this->ConfigModule->get('ShirOS.Database.FetchMode.Name.Fetch_Into'):
						$class = $this;
						break;
					
					default:
						$class = NULL;
						break;
				}
				
				if($attributes) {
					return $this->DBModule->prepare(
						$request,
						$attributes,
						$class,
						$one
					);
				}
				
				else
					return $this->DBModule->query(
						$request,
						$class,
						$one
					);
			}




		/* ------------------------ Opérations CRUD ------------------------ */
		
			/**
			 * Récupère toutes les données
			 *
			 * @return mixed
			 * @throws DatabaseException
			 */
			public function all()
			{
				$request =
					"SELECT *
					FROM $this->table";
				
				return $this->query($request);
			}
		
		
			/**
			 * Récupère certaines données en fonction des paramètres
			 *
			 * @param array $fields
			 *
			 * @return mixed
			 * @throws DatabaseException
			 */
			public function select(array $fields)
			{
				$SQLParts = [];
				$attributes = [];

				foreach ($fields as $key => $value) {
					$SQLParts[] = "$key LIKE ?";
					$attributes[] = $value;
				}

				$SQLPart = implode(' AND ', $SQLParts);
				$request =
					"SELECT *
					FROM {$this->table}
					WHERE $SQLPart";
				
				return $this->query($request, $attributes);
			}
		
		
			/**
			 * Récupère une donnée en fonction des paramètres.
			 *
			 * @param string $column
			 * @param string $value
			 *
			 * @return mixed
			 * @throws DatabaseException
			 */
			public function find(string $column, string $value)
			{
				$request =
					"SELECT *
					FROM {$this->table}
					WHERE {$column}
					LIKE ?";
				
				return $this->query($request, [$value], true);
			}
		
		
			/**
			 * Créer une donnée
			 *
			 * @param Model $object
			 * @param bool $date | Default Value = false
			 *
			 * @return mixed
			 * @throws DatabaseException
			 */
			public function create(Model $object, bool $date = false)
			{
				$SQLParts = [];
				$attributes = [];
				$fields = get_object_vars($object);

				if($date)
					$SQLParts[] = 'date = "' . date('Y-m-d H:i:s') . '"';

				foreach ($fields as $key => $value) {
					$SQLParts[] = "$key = ?";
					$attributes[] = $value;
				}

				$SQLPart = implode(', ', $SQLParts);
				$request =
					"INSERT INTO {$this->table}
					SET $SQLPart";
				
				return $this->query($request, $attributes, true);
			}
		
		
			/**
			 * Modifie une donnée
			 *
			 * @param array $id
			 * @param Model $object
			 *
			 * @return mixed
			 * @throws DatabaseException
			 */
			public function update(array $id, Model $object)
			{
				$SQLParts = [];
				$attributes = [];
				$fields = get_object_vars($object);

				foreach ($fields as $key => $value) {
					$SQLParts[] = "$key = ?";
					$attributes[] = $value;
				}
				$attributes[] = $id[$this->ConfigModule->get('ShirOS.Database.IdIndex.Id_Value')];

				$SQLPart = implode(', ', $SQLParts);
				$request =
					"UPDATE {$this->table}
					SET $SQLPart
					WHERE {$id[$this->ConfigModule->get('ShirOS.Database.IdIndex.Id_Column')]}
					LIKE ?";
				 
				return $this->query($request, $attributes, true);
			}
		
		
			/**
			 * Supprimer une donnée
			 *
			 * @param string $column
			 * @param string $value
			 *
			 * @return mixed
			 * @throws DatabaseException
			 */
			public function delete(string $column, string $value)
			{
				$request =
					"DELETE FROM {$this->table}
					WHERE {$column}
					LIKE ?";
				
				return $this->query($request, [$value], true);
			}




		/* ------------------------ Opérations Supplémentaire ------------------------ */
			
			/**
			 * Retourne tout les éléments par rapport au couple clé/valeur
			 *
			 * @param string $key
			 * @param string $value
			 *
			 * @return array
			 * @throws DatabaseException
			 */
			public function extract(string $key, string $value): array
			{
				$records = $this->all();
				$return = [];

				foreach ($records as $v)
					$return[$v->$key] = $v->$value;
				
				return $return;
			}


			/**
			 * Effectue une recherche par mot clé
			 *
			 * @param String $column
			 * @param String $value
			 *
			 * @return mixed
			 * @throws DatabaseException
			 */
			public function search(String $column, String $value)
			{
				$request =
					"SELECT *
					FROM {$this->table}
					WHERE {$column}
					LIKE CONCAT(\"%\",?,\"%\")";
				
				return $this->query($request, [$value]);
			}


			/**
			 * Retourne le nombre d'élément dans une table
			 *
			 * @return int
			 * @throws DatabaseException
			 */
			public function count(): int
			{
				$request =
					"SELECT count(*) as nb
					FROM {$this->table}";
				
				return (int)$this->query($request, NULL, true)->nb;
			}
	}
?>