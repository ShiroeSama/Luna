<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : ExceptionHandlerAbstractBridge.php
	 *   @Created_at : 15/03/2018
	 *   @Update_at : 21/03/2018
	 * --------------------------------------------------------------------------
	 */
	
	namespace Luna\Bridge\Component\Handler\Exception;

    use Luna\Component\Exception\BridgeException;
    use \Throwable;
	use Luna\Bridge\Bridge;
	use Luna\Component\DI\DependencyInjector;
    use Luna\Component\Handler\Exception\ExceptionHandler;
    use Luna\Config;
	
	abstract class ExceptionHandlerAbstractBridge extends Bridge
	{
        # ----------------------------------------------------------
        # Constant

            protected const EXCEPTION_HANDLER_NAME = 'Default';
            protected const DEFAULT_HANDLER_METHOD = 'onKernelException';
            protected const LUNA_EXCEPTION_HANDLER_NAMESPACE = ExceptionHandler::class;

		# ----------------------------------------------------------
		# Attributes
		
			/** @var Config */
			protected $ConfigModule;

            /** @var DependencyInjector */
            protected $DIModule;

            /** @var array */
            protected $exceptionHandler;

            /** @var Throwable */
            protected $throwable;

            protected $class;
			
			/** @var string */
			protected $method;


        /**
         * ExceptionHandlerBridgeTrait constructor.
         * @param Throwable $throwable
         */
        public function __construct(Throwable $throwable)
        {
            parent::__construct();
            $this->exceptionHandler = $this->ConfigModule->get(self::EXCEPTION_HANDLER_NAME . '.Exception');
        }


        /**
         * Make bridge between the app and the framework
         *
         * @throws BridgeException
         * @throws \Luna\Component\Exception\DependencyInjectorException
         */
		public function bridge()
		{
			if (!is_null($this->exceptionHandler)) {
				$class = $this->getHandlerClass();
				
				if (class_exists($class)) {
					$this->class = $this->DIModule->callConstructor($class);
				}
			} else {
			    if (defined(static::class . '::LUNA_EXCEPTION_HANDLER_NAMESPACE')) {
                    $this->class = $this->DIModule->callConstructor(static::LUNA_EXCEPTION_HANDLER_NAMESPACE);
                } else {
			        throw new BridgeException('Constant LUNA_EXCEPTION_HANDLER_NAMESPACE is not redefined in subclass ' . static::class);
                }
			}
			
			$this->method = $this->getHandlerMethod();
		}


        /**
         * Call the handler
         *
         * @throws \Luna\Component\Exception\DependencyInjectorException
         */
        public function catchException()
        {
            $throwable = $this->throwable;
            $args = compact('throwable');

            $exceptionHandler = $this->DIModule->callConstructor($this->class, $args);
            $this->DIModule->callMethod($this->method, $exceptionHandler, $args);
        }


        /**
         * Returns the class to use for routing handler
         *
         * @return string
         * @throws BridgeException
         */
		protected function getHandlerClass(): string
		{
			if (array_key_exists('class', $this->exceptionHandler)) {
				return $this->exceptionHandler['class'];
			}
            throw new BridgeException('Redefining the routing handler without specified class');
		}
		
		
		/**
		 * Returns the name of the method to call for the routing handler
		 *
		 * @return string
		 */
		protected function getHandlerMethod(): string
		{
			if (array_key_exists('method', $this->exceptionHandler)) {
				return $this->exceptionHandler['method'];
			}

            if (defined(static::class . '::DEFAULT_HANDLER_METHOD')) {
                return static::DEFAULT_HANDLER_METHOD;
            } else {
                return 'onHandlerEvent';
            }
		}
	}
?>