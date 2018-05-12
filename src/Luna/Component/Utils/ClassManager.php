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
	 *   @Update_at : 12/05/2018
	 * --------------------------------------------------------------------------
	 */
	
	namespace Luna\Component\Utils;
	
	class ClassManager
	{
		/**
		 * Allow to check if a class implement a specific interface
		 *
		 * @param $interface
		 * @param $class
		 * @return bool
		 */
		public static function checkClassImplement($interface, $class): bool
		{
			return is_subclass_of($class, $interface, true);
		}
		
		/**
		 * Allow to check if class/object is a specific class or extends/implement a specific class/interface
		 *
		 * @param $object
		 * @param string $class_name
		 * @return bool
		 */
		public static function checkClassOf($object, string $class_name): bool
		{
			return is_a($object, $class_name, true) or static::checkClassImplement($class_name, $object);
		}
	}
?>