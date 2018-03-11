<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : NumericType.php
	 *   @Created_at : 08/12/2017
	 *   @Update_at : 08/12/2017
	 * --------------------------------------------------------------------------
	 */
	
	namespace Luna\Utils\Validation\Type;
	
	class PhoneType implements ValidationType
	{
		/**
		 * Retour le Type
		 */
		public static function type(): ValidationType { return new PhoneType(); }
		
		/**
		 * Regex
		 * @var string
		 */
		protected const REGEX_PHONE = "#^((\d{2}?){4}\d{2})$#";
		
		/**
		 * Permet de verifier si le champ est du type de la classe
		 */
		public function validate($field) { return preg_match(self::REGEX_PHONE, $field); }
	}
?>