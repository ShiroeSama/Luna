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

	use Luna\Bridge\Component\Routing\RouterBridge;

    class Kernel
	{
	    /** @var RouterBridge */
	    protected $RouterBridgeModule;

		/**
		 * Kernel constructor.
		 */
		public function __construct()
		{
            # ----------------------------------------------------------
			# LUNA Constant

            define('LUNA_ROOT', __DIR__);
			define('LUNA_CONFIG_DIR', LUNA_ROOT . '/Config/files');



			# ----------------------------------------------------------
			# APP Constant

            $luna_root = LUNA_ROOT;
			$app_root = preg_replace('#/vendor/([^<]*)$#', '', $luna_root);
			
			define('APP_ROOT', $app_root);
			define('APP_CONFIG_DIR', APP_ROOT . '/config');



            # ----------------------------------------------------------
            # Prepare Singleton Instance

            Config::getInstance();



            # ----------------------------------------------------------
            # Construct Object

            $this->RouterBridgeModule = new RouterBridge();

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
		{
            # ----------------------------------------------------------
            # Routing Init

		    $this->RouterBridgeModule->init();
        }
	}
?>