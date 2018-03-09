<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : Gateway.php
	 *   @Created_at : 02/12/2017
	 *   @Update_at : 02/12/2017
	 * --------------------------------------------------------------------------
	 */
	
	namespace ShirOSBundle\Database\Gateway;
	
	use ShirOSBundle\Model\Model;
	
	interface Gateway
	{
		/**
		 * Récupère toutes les données
		 *
		 * @return mixed
		 */
		public function all();
		
		/**
		 * Récupère certaines données en fonction des paramètres
		 *
		 * @param array $fields
		 *
		 * @return mixed
		 */
		public function select(array $fields);
		
		/**
		 * Récupère une donnée en fonction des paramètres.
		 *
		 * @param string $column
		 * @param string $value
		 *
		 * @return mixed
		 */
		public function find(string $column, string $value);
		
		/**
		 * Créer une donnée
		 *
		 * @param Model $object
		 * @param bool $date | Default Value = false
		 *
		 * @return mixed
		 */
		public function create(Model $object, bool $date = false);
		
		/**
		 * Modifie une donnée
		 *
		 * @param array $id
		 * @param Model $object
		 *
		 * @return mixed
		 */
		public function update(array $id, Model $object);
		
		/**
		 * Supprimer une donnée
		 *
		 * @param string $column
		 * @param string $value
		 *
		 * @return mixed
		 */
		public function delete(string $column, string $value);
		
		/**
		 * Retourne tout les éléments par rapport au couple clé/valeur
		 *
		 * @param string $key
		 * @param string $value
		 *
		 * @return array
		 */
		public function extract(string $key, string $value): array;
		
		/**
		 * Effectue une recherche par mot clé
		 *
		 * @param String $column
		 * @param String $value
		 *
		 * @return mixed
		 */
		public function search(String $column, String $value);
		
		/**
		 * Retourne le nombre d'élément dans une table
		 *
		 * @return int
		 */
		public function count(): int;
	}
?>