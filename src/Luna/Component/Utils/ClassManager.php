<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : ClassManager.php
	 *   @Created_at : 10/05/2018
	 *   @Update_at : 10/05/2018
	 * --------------------------------------------------------------------------
	 */
	
	namespace Luna\Component\Utils;
	
	class ClassManager
	{
		public static function checkClassOf($object, string $class_name): bool
		{
			return is_a($object, $class_name, true) or is_subclass_of($object, $class_name, true);
		}
	}
?>