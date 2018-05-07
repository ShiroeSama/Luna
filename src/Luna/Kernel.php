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
     *   @Update_at : 07/05/2018
	 * --------------------------------------------------------------------------
	 */
	
	namespace Luna;

	use Luna\Bridge\Component\Handler\Exception\ExceptionHandlerBridge;
	use Luna\Bridge\Component\Routing\RouterBridge;
    use Luna\Component\Handler\Exception\ExceptionHandler;
    use Luna\Component\HTTP\Request\RequestBuilder;
    use Luna\Component\HTTP\Request\ResponseInterface;
    use \Throwable;

    class Kernel
	{
        /** @var Config */
	    protected $ConfigModule;

        /** @var RouterBridge */
        protected $RouterBridgeModule;

        /** @var ExceptionHandlerBridge */
        protected $ExceptionHandlerBridgeModule;

        /** @var ResponseInterface */
        protected $response;


        # -------------------------------------------------------------
        #   Global Vars
        # -------------------------------------------------------------

        /** @var string */
        protected static $environement;


        /**
		 * Kernel constructor.
		 */
		public function __construct()
		{
            # ----------------------------------------------------------
			# LUNA Constants

            define('LUNA_ROOT', __DIR__);
			define('LUNA_CONFIG_DIR', LUNA_ROOT . '/Config/files');



			# ----------------------------------------------------------
			# APP Constants

            $luna_root = LUNA_ROOT;
			$app_root = preg_replace('#/vendor/([^<]*)$#', '', $luna_root);
			
			define('APP_ROOT', $app_root);
			define('APP_CONFIG_DIR', APP_ROOT . '/config');

            try {

                # ----------------------------------------------------------
                # Prepare Singleton Instance

                $this->ConfigModule = Config::getInstance();




                # ----------------------------------------------------------
                # Define Global vars

                self::$environement = $this->ConfigModule->get('Luna.Environement');




                # ----------------------------------------------------------
                # Construct Object


                $this->RouterBridgeModule = new RouterBridge();
                $this->RouterBridgeModule->bridge();
            } catch (Throwable $throwable) {
                try {
                    $this->ExceptionHandlerBridgeModule = new ExceptionHandlerBridge();
                    $this->ExceptionHandlerBridgeModule->bridge();
                    $this->ExceptionHandlerBridgeModule->catchException($throwable);
                } catch (Throwable $throwable) {
                    $exceptionHandler = new ExceptionHandler($throwable);
                    $exceptionHandler->onKernelException();
                }
            }
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
		    try {

                # ----------------------------------------------------------
                # Build the Request

                $request = RequestBuilder::create();

                // TODO : Set the request in the LunaContainer


                # ----------------------------------------------------------
                # Routing Init

                $this->response = $this->RouterBridgeModule->init($request);

            } catch (Throwable $throwable) {
                try {
                    $this->ExceptionHandlerBridgeModule->catchException($throwable);
                } catch (Throwable $throwable) {
                    $exceptionHandler = new ExceptionHandler($throwable);
                    $exceptionHandler->onKernelException();
                }
            }
        }


        /**
         * Send response to the client.
         * Configure headers and display content
         */
        public function send()
        {
            try {
                if (is_null($this->response)) {
                    // TODO : Throw Kernel Exception
                }

                $this->response->getHeaders();
                $this->response->getContent();
            } catch (Throwable $throwable) {
                try {
                    $this->ExceptionHandlerBridgeModule->catchException($throwable);
                } catch (Throwable $throwable) {
                    $exceptionHandler = new ExceptionHandler($throwable);
                    $exceptionHandler->onKernelException();
                }
            }
        }

        /**
         * @return string
         */
        public static function getEnv(): string
        {
            return self::$environement;
        }
	}
?>