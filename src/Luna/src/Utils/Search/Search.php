<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : Search.php
	 *   @Created_at : 18/07/2017
	 *   @Update_at : 03/12/2017
	 * --------------------------------------------------------------------------
	 */

	namespace ShirOSBundle\Utils\Search;
	use ShirOSBundle\Database\Gateway\Manager;
	use ShirOSBundle\Utils\Validation\Validation;

	class Search
	{
		/**
		 * Instance de la classe de validation
		 * @var Validation
		 */
		protected $ValidationModule;
		
		/**
		 * Search constructor.
		 */
		public function __construct() { $this->ValidationModule = new Validation(); }


		/* -------- Fonctions de Recherche -------- */
		
			/**
			 * Effectue une recherche pour voir si l'élément existe
			 *
			 * @param string $search
			 * @param Manager $Manager
			 * @param array $columns
			 *
			 * @return array|bool|mixed
			 */
			public function search(string $search, Manager $Manager, array $columns)
			{
				$result = [];
				
				foreach ($columns as $column) {
					$result += $Manager->searchModel($column, $search);
				}

				$result = array_unique($result,SORT_REGULAR);
				
				if(empty($result))
					return false;
				else
					return $result;
			}
	}
?>