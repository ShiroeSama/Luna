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
	use Luna\Component\Container\LunaContainer;
	use Luna\Component\Exception\KernelException;
	use Luna\Component\Handler\Exception\ExceptionHandler;
    use Luna\Component\HTTP\Request\RequestBuilder;
    use Luna\Component\HTTP\Request\ResponseInterface;
	use Luna\Config\Config;
	
	use \Throwable;

    class Kernel implements KernelInterface
	{
        /** @var Config */
	    protected $ConfigModule;
	    
	    /** @var LunaContainer */
	    protected $ContainerModule;

        /** @var RouterBridge */
        protected $RouterBridgeModule;

        /** @var ExceptionHandlerBridge */
        protected $ExceptionHandlerBridgeModule;


        # -------------------------------------------------------------
        #   Information Vars
        # -------------------------------------------------------------
	
	    /** @var string */
	    protected $env;
	
	    /** @var ResponseInterface */
	    protected $response;


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
	            $this->ContainerModule = LunaContainer::getInstance();
	
	
	            # ----------------------------------------------------------
	            # Define Kernel on Container
	            
	            $this->ContainerModule->setKernel($this);


                # ----------------------------------------------------------
                # Define Global vars

                $this->env = $this->ConfigModule->get('Luna.Environment');


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
                    $exceptionHandler = new ExceptionHandler($this, $throwable);
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
                
                $this->ContainerModule->setRequest($request);


                # ----------------------------------------------------------
                # Routing Init

                $response = $this->RouterBridgeModule->init($request);
                
                if (!is_a($response, ResponseInterface::class)) {
                	$message = 'The controller must return a response.';
                	
                	if ($response === null) {
                		$message .= ' Did you forget to add a return statement in your controller ?';
	                }
	                
	                throw new KernelException($message);
                }

            } catch (Throwable $throwable) {
                try {
                    $this->ExceptionHandlerBridgeModule->catchException($throwable);
                } catch (Throwable $throwable) {
                    $exceptionHandler = new ExceptionHandler($this, $throwable);
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
	        $this->response->getHeaders();
	        $this->response->getContent();
        }
	
	
	
	    /* -------------------------------------------------------------------------- */
	    /* Informations */
		
	    /**
	     * @return string
	     */
	    public function getEnv(): string
	    {
		    return $this->env;
	    }
	
	    /**
	     * @return ResponseInterface
	     */
	    public function getResponse(): ResponseInterface
	    {
		    return $this->response;
	    }
	}
?>