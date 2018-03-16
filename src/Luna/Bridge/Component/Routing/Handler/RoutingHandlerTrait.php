<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : RoutingHandlerTrait.php
	 *   @Created_at : 15/03/2018
	 *   @Update_at : 15/03/2018
	 * --------------------------------------------------------------------------
	 */
	
	namespace Luna\Bridge\Component\Routing;
	
	use Luna\Config;
	
	trait RoutingHandlerTrait
	{
		# ----------------------------------------------------------
		# Attributes
		
			/** @var Config */
			protected $ConfigModule;
			
			/** @var string */
			protected $method;
		
		
		/**
		 * Make bridge between the app and the framework
		 */
		protected function bridge()
		{
			$handler = $this->ConfigModule->getHandler('Routing.Exception');
			
			if (!is_null($handler)) {
				$class = $this->getClass($handler);
				
				if (class_exists($class)) {
					// TODO : Use DI (Dependency Injector)
					$this->class = new $class();
				}
			} else {
			    if (defined(static::class . '::LUNA_ROUTING_HANDLE_NAMESPACE')) {
                    $lunaRoutingHandlerNamespace = static::LUNA_ROUTING_HANDLE_NAMESPACE;
                    // TODO : Use DI (Dependency Injector)
                    $this->class = new $lunaRoutingHandlerNamespace();
                } else {
                    // TODO : Throw Bridge Exception (Constant LUNA_ROUTING_HANDLE_NAMESPACE is not redefined in subclass static::class)
                }
			}
			
			$this->method = $this->getMethod($handler);
		}
		
		/**
		 * Returns the class to use for routing handler
		 *
		 * @param array $handler
		 * @return string
		 */
		protected function getClass(array $handler): string
		{
			if (array_key_exists('class', $handler)) {
				return $handler['class'];
			}
			// TODO : Throw BridgeException (Redefining the routing handler without specified class)
		}
		
		
		/**
		 * Returns the name of the method to call for the routing handler
		 *
		 * @param array $handler
		 * @return string
		 */
		protected function getMethod(array $handler): string
		{
			if (array_key_exists('method', $handler)) {
				return $handler['method'];
			}

            if (defined(static::class . '::DEFAULT_HANDLER_METHOD')) {
                return static::DEFAULT_HANDLER_METHOD;
            } else {
                return 'onHandlerEvent';
            }
		}
	}
?>