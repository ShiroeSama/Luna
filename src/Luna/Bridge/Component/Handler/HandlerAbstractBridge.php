<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : HandlerAbstractBridge.php
	 *   @Created_at : 16/04/2018
	 *   @Update_at : 16/04/2018
	 * --------------------------------------------------------------------------
	 */
	
	namespace Luna\Bridge\Component\Handler;

    use Luna\Bridge\Bridge;
    use Luna\Component\Bag\ParameterBag;
    use Luna\Component\Exception\BridgeException;
    use Luna\Component\Exception\ConfigException;
    use Luna\Component\Utils\ClassManager;

    abstract class HandlerAbstractBridge extends Bridge
	{
        # ----------------------------------------------------------
        # Constant
		
			private const HANDLER_KEY_CLASS = 'class';
			private const HANDLER_KEY_METHOD = 'method';
		
			protected const HANDLER_NAME = NULL;
			protected const HANDLER_TYPE = NULL;
			protected const HANDLER_CLASS = NULL;
			protected const HANDLER_METHOD = NULL;

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

            $handler = $this->ConfigModule->getHandler(static::HANDLER_NAME . '.' . static::HANDLER_TYPE);
            $this->bag = is_null($handler) ? new ParameterBag() : new ParameterBag($handler);
            
            $this->class = $this->bag->get(static::HANDLER_KEY_CLASS);
	        $this->method = $this->bag->get(static::HANDLER_KEY_METHOD);
        }

        /**
         * Check if all constants are defined correctly
         *
         * @throws BridgeException
         */
        protected function checkConst()
        {
			if (is_null(static::HANDLER_NAME)) {
		        throw new BridgeException('Constant HANDLER_NAME is not redefined in subclass ' . static::class);
	        }
	        
            if (is_null(static::HANDLER_TYPE)) {
                throw new BridgeException('Constant HANDLER_TYPE is not redefined in subclass ' . static::class);
            }

            if (is_null(static::HANDLER_CLASS)) {
                throw new BridgeException('Constant HANDLER_CLASS is not redefined in subclass ' . static::class);
            }
	
	        if (is_null(static::HANDLER_METHOD)) {
		        throw new BridgeException('Constant HANDLER_METHOD is not redefined in subclass ' . static::class);
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
                $this->class = static::HANDLER_CLASS;
			}
			if (is_null($this->method)) {
				$this->method = static::HANDLER_METHOD;
			}
			
			
			// Check if the class exist
   
			if (!class_exists($this->class)) {
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