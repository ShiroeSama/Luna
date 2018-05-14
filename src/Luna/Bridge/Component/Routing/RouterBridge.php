<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : RouterBridge.php
     *   @Created_at : 14/03/2018
     *   @Update_at : 12/05/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Bridge\Component\Routing;

    use Luna\Bridge\Bridge;
    use Luna\Component\Exception\BridgeException;
    use Luna\Component\Exception\ConfigException;
    use Luna\Component\Exception\DependencyInjectorException;
    use Luna\Component\HTTP\Request\Request;
    use Luna\Component\HTTP\Request\ResponseInterface;
    use Luna\Component\Routing\Router;
    use Luna\Component\Routing\RouterInterface;
    use Luna\Component\Utils\ClassManager;

    class RouterBridge extends Bridge
    {
        # ----------------------------------------------------------
        # Constant

            protected const APP_ROUTER_NAMESPACE = 'App\\Component\\Routing\\Router';
            protected const LUNA_ROUTER_NAMESPACE = Router::class;


        # ----------------------------------------------------------
        # Attributes

            /** @var string */
            protected $class;


        /**
         * Allow to instance the Luna Router or the App Router
         * Make bridge between the app and the framework
         *
         * @return string
         * @throws BridgeException
         */
        public function bridge(): string
        {
            $this->class = self::LUNA_ROUTER_NAMESPACE;

            if (ClassManager::exist(self::APP_ROUTER_NAMESPACE)) {
                $this->class = self::APP_ROUTER_NAMESPACE;

                if (ClassManager::extend(RouterInterface::class, $this->class)) {
                    throw new BridgeException('App Router doesnt implements the RouterInterface');
                }
            }

            return $this->class;
        }
	
	    /**
	     * @param Request $request
	     *
	     * @return ResponseInterface
	     *
	     * @throws ConfigException
	     * @throws DependencyInjectorException
	     */
        public function init(Request $request): ResponseInterface
        {
            /** @var RouterInterface $router */
            $router = $this->DIModule->callConstructor($this->class);
            return $router->init($request);
        }
    }
?>