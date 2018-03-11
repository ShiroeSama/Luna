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

	namespace Luna\Database;
	
	use \PDO;

	interface Database
	{
		public const UPDATE_COLUMN = 'ColumnName';
		public const UPDATE_VALUE = 'Value';
		
		/**
		 * Established the connexion with PDO
		 */
		public function getPDO(): PDO;
	}
?>