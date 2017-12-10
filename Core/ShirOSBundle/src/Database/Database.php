<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : Database.php
	 *   @Created_at : 24/11/2016
	 *   @Update_at : 10/07/2017
	 * --------------------------------------------------------------------------
	 */

	namespace ShirOSBundle\Database;

	interface Database
	{
		public const UPDATE_COLUMN = 'ColumnName';
		public const UPDATE_VALUE = 'Value';
		
		/**
		 * Permet de construire une requête auprès de la DB
		 *
		 * @param string $queryString
		 * @param $class
		 * @param bool $one | Default Value = false
		 *
		 * @return array|bool|mixed
		 */
		public function query(string $queryString, $class, bool $one = false);
		

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
		public function prepare(string $queryString, array $attributes, $class, bool $one = false);
	}
?>