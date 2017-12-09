<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : ArrayType.php
	 *   @Created_at : 08/12/2017
	 *   @Update_at : 08/12/2017
	 * --------------------------------------------------------------------------
	 */
	
	namespace ShirOSBundle\Utils\Validation\Type;
	
	class ArrayType implements Type
	{
		/**
		 * Retour le Type
		 */
		public static function type(): Type { return new ArrayType(); }
		
		/**
		 * Permet de verifier si le champ est du type de la classe
		 */
		public function validate($field) { return is_array($field); }
	}
?>