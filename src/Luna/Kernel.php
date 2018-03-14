<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : Kernel.php
	 *   @Created_at : 03/12/2017
	 *   @Update_at : 03/12/2017
	 * --------------------------------------------------------------------------
	 */
	
	namespace Luna;
	use Luna\Config;
    use Luna\Database\Database;
    use Luna\Database\Gateway\Manager;
    use Luna\Utils\Url\Url;
	use Luna\Database\MySQLDatabase;

	class Kernel
	{
		/**
		 * Kernel constructor.
		 */
		public function __construct()
		{
			# LUNA Constant
			define('LUNA_ROOT', __DIR__);
			define('LUNA_CONFIG_DIR', LUNA_ROOT . '/Config/files');
			
			# ----------------------------------------------------------
			# APP Constant
			$luna_root = LUNA_ROOT;
			$app_root = preg_replace('#/vendor/([^<]*)$#', '', $luna_root);
			
			define('APP_ROOT', $app_root);
			define('APP_CONFIG_DIR', APP_ROOT . '/config');
		}
		
		/**
		 * Access point of the application
		 * Allow to start the routing component and settings the Luna Framework
		 *
		 * - DI (Dependency Injector)
		 * - Routing
		 * - Templating
		 * - Constant
		 */
		public function start()
		{}
	}
?>