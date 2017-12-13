<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : StringType.php
	 *   @Created_at : 10/12/2017
	 *   @Update_at : 10/12/2017
	 * --------------------------------------------------------------------------
	 */
	
	namespace ShirOSBundle\Utils\Validation\Type;
	
	class UrlType implements ValidationType
	{
		/**
		 * Retour le Type
		 */
		public static function type(): ValidationType { return new UrlType(); }
		
		/**
		 * Regex
		 * @var string
		 */
		protected const REGEX_URL = "#^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$#";
		
		/**
		 * Permet de verifier si le champ est du type de la classe
		 */
		public function validate($field) { return preg_match(self::REGEX_URL, $field); }
	}
	?>