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
	
	namespace ShirOSBundle\Utils\Validation\Type;
	
	class NumericType implements ValidationType
	{
		/**
		 * Retour le Type
		 */
		public static function type(): ValidationType { return new NumericType(); }
		
		/**
		 * Regex
		 * @var string
		 */
		protected const REGEX_NUMBER = "#^[\d\s]*$#";
		
		/**
		 * Permet de verifier si le champ est du type de la classe
		 */
		public function validate($field) { return is_numeric($field) && preg_match(self::REGEX_NUMBER, $field); }
	}
?>