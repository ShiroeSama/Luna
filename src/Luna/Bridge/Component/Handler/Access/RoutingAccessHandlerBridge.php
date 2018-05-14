<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : RoutingAccessHandlerBridge.php
	 *   @Created_at : 14/05/2018
	 *   @Update_at : 14/05/2018
	 * --------------------------------------------------------------------------
	 */
	
	namespace Luna\Bridge\Component\Handler\Access;
	
	use Luna\Bridge\Component\Handler\HandlerAbstractBridge;
	use Luna\Component\Exception\ConfigException;
	use Luna\Component\Exception\DependencyInjectorException;
	use Luna\Component\Handler\Access\RoutingAccessHandler;
	use Luna\Component\HTTP\Request\RequestInterface;
	
	class RoutingAccessHandlerBridge extends HandlerAbstractBridge
	{
		# ----------------------------------------------------------
		# Constant
		
			protected const HANDLER_NAME = 'Access';
			protected const HANDLER_TYPE = 'Routing';
			protected const HANDLER_CLASS = RoutingAccessHandler::class;
			protected const HANDLER_METHOD = 'access';
		
		
		/**
		 * Call the handler
		 *
		 * @param RequestInterface $request
		 *
		 * @return bool
		 *
		 * @throws ConfigException
		 * @throws DependencyInjectorException
		 */
		public function access(RequestInterface $request): bool
		{
			$args = compact('request');
			
			$routingAccessHandler = $this->DIModule->callConstructor($this->class, $args);
			return $this->DIModule->callMethod($this->method, $routingAccessHandler, $args);
		}
	}
?>