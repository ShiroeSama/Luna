<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : BooleanType.php
	 *   @Created_at : 08/12/2017
	 *   @Update_at : 08/12/2017
	 * --------------------------------------------------------------------------
	 */
	
	namespace Luna\Utils\Validation\Type;
	
	class BooleanType implements ValidationType
	{
		/**
		 * Retour le Type
		 */
		public static function type(): ValidationType { return new BooleanType(); }
		
		/**
		 * Permet de verifier si le champ est du type de la classe
		 */
		public function validate($field) {
			if (!is_bool($field)) {
				$field = strtolower($field);
				return ($field == "false" || $field == "true");
			} else { return true; }
		}
	}
?>