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
     *   @Update_at : 16/04/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Bridge\Component\Routing;

    use Luna\Bridge\Bridge;
    use Luna\Component\Exception\BridgeException;
    use Luna\Component\HTTP\Request\RequestBuilder;
    use Luna\Component\Routing\Router;
    use Luna\Component\Routing\RouterInterface;

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

            if (class_exists(self::APP_ROUTER_NAMESPACE)) {
                $this->class = self::APP_ROUTER_NAMESPACE;

                if (is_subclass_of($this->class, RouterInterface::class)) {
                    throw new BridgeException('App Router doesnt implements the RouterInterface');
                }
            }

            return $this->class;
        }

        /**
         * @param RequestBuilder $requestBuilder
         * @throws \Luna\Component\Exception\DependencyInjectorException
         */
        public function init(RequestBuilder $requestBuilder)
        {
            $router = $this->DIModule->callConstructor($this->class);

            switch (get_class($this->class)) {
                case self::APP_ROUTER_NAMESPACE :
                default :
                    $router->init($requestBuilder);
                    break;

            }
        }
    }
?>