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
		 * @param string $interface
		 * @param $class
		 * @return bool
		 */
		public static function implement(string $interface, $class): bool
		{
			return is_subclass_of($class, $interface, true);
		}
		
		/**
		 * Allow to check if a class extend a specific class
		 *
		 * @param string $parent_class
		 * @param $class
		 * @return bool
		 */
		public static function extend(string $parent_class, $class): bool
		{
			return is_subclass_of($class, $parent_class, true);
		}
		
		/**
		 * Allow to check if class/object is a specific class or extends/implement a specific class/interface
		 *
		 * @param string $class_name
		 * @param $object
		 * @return bool
		 */
		public static function is(string $class_name, $object): bool
		{
			return is_a($object, $class_name, true) or static::implement($class_name, $object);
		}
	}
?>