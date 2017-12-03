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
			 * @param array $column
			 *
			 * @return array|bool|mixed
			 */
			public function search(string $search, Manager $Manager, array $column)
			{
				$result = [];

				# Sanitize des Paramètres
					$search = $this->ValidationModule->sanitizeSearch($search);

				foreach ($column as $c) {
					$result += $Manager->searchModel($c,$search);
				}

				$result = array_unique($result,SORT_REGULAR);
				
				if(empty($result))
					return false;
				else
					return $result;
			}
	}
?>