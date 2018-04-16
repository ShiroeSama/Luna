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
    use Luna\Component\Exception\BridgeException;
    use Luna\Component\Exception\ConfigException;

	abstract class HandlerAbstractBridge extends Bridge
	{
        # ----------------------------------------------------------
        # Constant

            protected const HANDLER_TYPE = NULL;
            protected const HANDLER_NAME = 'Default';
            protected const HANDLER_METHOD = NULL;
            protected const HANDLER_INTERFACE = NULL;
            protected const LUNA_HANDLER_NAMESPACE = NULL;

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

            $this->class = $this->ConfigModule->getHandler(static::HANDLER_NAME . '.' . static::HANDLER_TYPE);
        }

        /**
         * Check if all constants are defined correctly
         *
         * @throws BridgeException
         */
        protected function checkConst()
        {
            if (is_null(static::HANDLER_TYPE)) {
                throw new BridgeException('Constant HANDLER_TYPE is not redefined in subclass ' . static::class);
            }

            if (is_null(static::HANDLER_NAME)) {
                throw new BridgeException('Constant HANDLER_NAME is not redefined in subclass ' . static::class);
            }

            if (is_null(static::HANDLER_METHOD)) {
                throw new BridgeException('Constant HANDLER_METHOD is not redefined in subclass ' . static::class);
            }

            if (is_null(static::HANDLER_INTERFACE)) {
                throw new BridgeException('Constant HANDLER_INTERFACE is not redefined in subclass ' . static::class);
            }

            if (is_null(static::LUNA_HANDLER_NAMESPACE)) {
                throw new BridgeException('Constant LUNA_HANDLER_NAMESPACE is not redefined in subclass ' . static::class);
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
                $this->class = static::LUNA_HANDLER_NAMESPACE;
			}

            if (!class_exists($this->class)) {
                throw new BridgeException($this->class . ' doesnt exist');
            }

            $this->interface = static::HANDLER_INTERFACE;
            if (is_subclass_of($this->class, $this->interface)) {
                throw new BridgeException($this->class . ' doesnt implements the ' . $this->interface);
            }

            $this->method = static::HANDLER_METHOD;
            if (!method_exists($this->class, $this->method)) {
                throw new BridgeException($this->method . ' doesnt exist in class ' . $this->class);
            }

			return $this->class;
		}
	}
?>