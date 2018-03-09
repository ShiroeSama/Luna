<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : Manager.php
	 *   @Created_at : 10/07/2017
	 *   @Update_at : 02/12/2017
	 * --------------------------------------------------------------------------
	 */

	namespace ShirOSBundle\Database\Gateway;
	use ShirOSBundle\Config;
	use ShirOSBundle\Database\Database;
	use ShirOSBundle\Model\Model;
	use ShirOSBundle\Utils\NameSupervisor\NameSupervisor;
	use ShirOSBundle\Utils\Exception\DatabaseException;

	class Manager
	{
		/**
		 * Instance de la Gateway à utiliser
		 * @var Gateway
		 */
		protected $Gateway;
		
		
		/**
		 * Manager constructor.
		 *
		 * @param string $gateway
		 * @param Database $db_instance
		 *
		 * @throws DatabaseException
		 */
		public function __construct(string $gateway, Database $db_instance)
		{
			try {
				$this->Gateway = new $gateway($db_instance);
			} catch (\Throwable $e) {
				throw new DatabaseException(DatabaseException::DATABASE_BAD_GATEWAY_ERROR_CODE, $e->getMessage());				
			}
		}


		/**
		 * Verifie que la Gateway peut être appelée
		 *
		 * @param string $gateway
		 *
		 * @return bool
		 */
		protected function gatewayIs(string $gateway): bool { return is_a($this->Gateway, $gateway); }


		/* ------------------------ Opérations CRUD ------------------------ */

			/**
			 * Retourne toutes les lignes d'une table. Utilise la Gateway appropriée
			 *
			 * @return mixed
			 */
			public function allModels() { return $this->Gateway->all(); }
			
			/**
			 * Récupere plusieurs lignes spécifique. Utilise la Gateway appropriée
			 *
			 * @param array $fields
			 *
			 * @return mixed
			 */
			public function getModels(array $fields) { return $this->Gateway->select($fields); }

			/**
			 * Récupere une ligne spécifique. Utilise la Gateway appropriée
			 *
			 * @param string $column
			 * @param string $value
			 *
			 * @return mixed
			 */
			public function getModel(string $column, string $value) { return $this->Gateway->find($column, $value); }
		
			/**
			 * Cherche un ou plusieurs objets correspondants au mot clé. Utilise la Gateway appropriée
			 *
			 * @param string $column
			 * @param string $value
			 *
			 * @return mixed
			 */
			public function searchModel(string $column, string $value) { return $this->Gateway->search($column, $value); }
		
		
			/**
			 * Créer une ligne spécifique. Utilise la Gateway appropriée
			 *
			 * @param Model $object
			 * @param bool $date
			 *
			 * @return mixed
			 */
			public function createModel(Model $object, $date = false) { return $this->Gateway->create($object, $date); }


			/**
			 * Mets à jour une ligne spécifique. Utilise la Gateway appropriée
			 *
			 * @param array $id
			 * @param Model $object
			 *
			 * @return mixed
			 */
			public function updateModel(array $id, Model $object) { return $this->Gateway->update($id, $object); }

			/**
			 * Supprime une ligne spécifique. Utilise la Gateway appropriée
			 *
			 * @param string $column
			 * @param string $value
			 *
			 * @return mixed
			 */
			public function deleteModel(string $column, string $value) { return $this->Gateway->delete($column, $value); }

			/**
			 * Permet d'avoir une liste associative de certain éléments. Utilise la Gateway appropriée
			 *
			 * @param string $key
			 * @param string $value
			 *
			 * @return mixed
			 */
			public function extractModel(string $key, string $value) { return $this->Gateway->extract($key, $value); }

			/**
			 * Retourne le nombre de ligne dans une table. Utilise la Gateway appropriée
			 *
			 * @return int
			 */
			public function countModel(): int { return $this->Gateway->count(); }
	}
?>