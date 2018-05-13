<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : DispatcherAbstractBridge.php
	 *   @Created_at : 18/04/2018
	 *   @Update_at : 18/04/2018
	 * --------------------------------------------------------------------------
	 */
	
	namespace Luna\Bridge\Component\Dispatcher;

    use Luna\Bridge\Bridge;
    use Luna\Component\Bag\ParameterBag;
    use Luna\Component\Exception\BridgeException;
    use Luna\Component\Exception\ConfigException;
    use Luna\Component\Utils\ClassManager;

    abstract class DispatcherAbstractBridge extends Bridge
	{
        # ----------------------------------------------------------
        # Constant
			
			private const DISPATCHER_KEY_CLASS = 'class';
			private const DISPATCHER_KEY_METHOD = 'method';
		
			protected const DISPATCHER_NAME = NULL;
			protected const DISPATCHER_TYPE = NULL;
			protected const DISPATCHER_CLASS = NULL;
			protected const DISPATCHER_METHOD = NULL;

		# ----------------------------------------------------------
		# Attributes
		
			/** @var ParameterBag */
			protected $bag;
			
			/** @var string */
            protected $class;
			
			/** @var string */
			protected $method;


        /**
         * HandlerAbstractBridge constructor.
         *
         * @throws BridgeException
         * @throws ConfigException
         */
        public function __construct()
        {
            parent::__construct();

            $this->checkConst();

            $this->class = $this->ConfigModule->getDispatcher(static::DISPATCHER_NAME);
	
	        $dispatcher = $this->ConfigModule->getHandler(static::DISPATCHER_NAME . '.' . static::DISPATCHER_TYPE);
	        $this->bag = is_null($dispatcher) ? new ParameterBag() : new ParameterBag($dispatcher);
	
	        $this->class = $this->bag->get(static::DISPATCHER_KEY_CLASS);
	        $this->method = $this->bag->get(static::DISPATCHER_KEY_METHOD);
        }

        /**
         * Check if all constants are defined correctly
         *
         * @throws BridgeException
         */
        protected function checkConst()
        {
            if (is_null(static::DISPATCHER_NAME)) {
                throw new BridgeException('Constant DISPATCHER_NAME is not redefined in subclass ' . static::class);
            }
	
	        if (is_null(static::DISPATCHER_TYPE)) {
		        throw new BridgeException('Constant DISPATCHER_TYPE is not redefined in subclass ' . static::class);
	        }
	
	        if (is_null(static::DISPATCHER_CLASS)) {
		        throw new BridgeException('Constant DISPATCHER_CLASS is not redefined in subclass ' . static::class);
	        }

            if (is_null(static::DISPATCHER_METHOD)) {
                throw new BridgeException('Constant DISPATCHER_METHOD is not redefined in subclass ' . static::class);
            }
        }


        /**
         * Make bridge between the app and the framework
         *
         * @return string
         * @throws BridgeException
         */
		public function bridge(): string
		{
			// Set the default value if class & method are NULL
			
			if (is_null($this->class)) {
				$this->class = static::DISPATCHER_CLASS;
			}
			if (is_null($this->method)) {
				$this->method = static::DISPATCHER_METHOD;
			}
			
			
			// Check if the class exist
			
			if (!ClassManager::exist($this->class)) {
				throw new BridgeException($this->class . ' doesnt exist');
			}
			
			
			// Check if the method exist in the class
			
			if (!method_exists($this->class, $this->method)) {
				throw new BridgeException($this->method . ' doesnt exist in class ' . $this->class);
			}
			
			return $this->class;
		}
	}
?>