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
	
	class NumericType implements Type
	{
		/**
		 * Retour le Type
		 */
		public static function type(): Type { return new NumericType(); }
		
		/**
		 * Regex pour les nombre
		 * @var string
		 */
		private const REGEX_NUMBER = "#^[\d\s]*$#";
		
		/**
		 * Permet de verifier si le champ est du type de la classe
		 */
		public function validate($field) { return is_numeric($field) && preg_match(self::REGEX_NUMBER, $field); }
	}
?>