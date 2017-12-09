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
	
	class PhoneType implements Type
	{
		/**
		 * Retour le Type
		 */
		public static function type(): Type { return new PhoneType(); }
		
		/**
		 * Regex pour les nombre
		 * @var string
		 */
		private const REGEX_PHONE = "#^((\d{2}?){4}\d{2})$#";
		
		/**
		 * Permet de verifier si le champ est du type de la classe
		 */
		public function validate($field) { return preg_match(self::REGEX_PHONE, $field); }
	}
?>