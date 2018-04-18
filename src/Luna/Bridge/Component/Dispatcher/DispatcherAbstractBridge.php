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
    use Luna\Component\Exception\BridgeException;
    use Luna\Component\Exception\ConfigException;

	abstract class DispatcherAbstractBridge extends Bridge
	{
        # ----------------------------------------------------------
        # Constant

            protected const DISPATCHER_NAME = NULL;
            protected const DISPATCHER_METHOD = NULL;
            protected const DISPATCHER_INTERFACE = NULL;
            protected const LUNA_DISPATCHER_NAMESPACE = NULL;

		# ----------------------------------------------------------
		# Attributes

            /** @var string */
            protected $interface;

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

            if (is_null(static::DISPATCHER_METHOD)) {
                throw new BridgeException('Constant DISPATCHER_METHOD is not redefined in subclass ' . static::class);
            }

            if (is_null(static::DISPATCHER_INTERFACE)) {
                throw new BridgeException('Constant DISPATCHER_INTERFACE is not redefined in subclass ' . static::class);
            }

            if (is_null(static::LUNA_DISPATCHER_NAMESPACE)) {
                throw new BridgeException('Constant LUNA_DISPATCHER_NAMESPACE is not redefined in subclass ' . static::class);
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
			if (is_null($this->class)) {
                $this->class = static::LUNA_DISPATCHER_NAMESPACE;
			}

            if (!class_exists($this->class)) {
                throw new BridgeException($this->class . ' doesnt exist');
            }

            $this->interface = static::DISPATCHER_INTERFACE;
            if (is_subclass_of($this->class, $this->interface)) {
                throw new BridgeException($this->class . ' doesnt implements the ' . $this->interface);
            }

            $this->method = static::DISPATCHER_METHOD;
            if (!method_exists($this->class, $this->method)) {
                throw new BridgeException($this->method . ' doesnt exist in class ' . $this->class);
            }

			return $this->class;
		}
	}
?>