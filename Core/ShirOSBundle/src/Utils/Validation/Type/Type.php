<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : Type.php
	 *   @Created_at : 08/12/2017
	 *   @Update_at : 08/12/2017
	 * --------------------------------------------------------------------------
	 */
	
	namespace ShirOSBundle\Utils\Validation\Type;
	
	interface Type
	{
		/**
		 * Retour le Type
		 */
		public static function type(): Type;
		
		/**
		 * Permet de verifier si le champ est du type de la classe
		 */
		public function validate($field);
	}
?>