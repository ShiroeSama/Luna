<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : ValidationType.php
	 *   @Created_at : 08/12/2017
	 *   @Update_at : 08/12/2017
	 * --------------------------------------------------------------------------
	 */
	
	namespace Luna\Utils\Validation\Type;
	
	interface ValidationType
	{
		/**
		 * Retour le Type
		 */
		public static function type(): ValidationType;
		
		/**
		 * Permet de verifier si le champ est du type de la classe
		 */
		public function validate($field);
	}
?>