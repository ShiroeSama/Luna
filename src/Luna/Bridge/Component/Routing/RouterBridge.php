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
     *   @Update_at : 14/03/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Bridge\Component\Routing;

    use Luna\Bridge\Bridge;
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

            /** @var RouterInterface */
            protected $class;


        /**
         * Allow to instance the Luna Router or the App Router
         * Make bridge between the app and the framework
         */
        protected function bridge()
        {
            if (class_exists(self::APP_ROUTER_NAMESPACE)) {
                $appRouterNamespace = self::APP_ROUTER_NAMESPACE;

                if (is_subclass_of($appRouterNamespace, RouterInterface::class)) {
                    // TODO : Use DI (Dependency Injector)
                    $this->class = new $appRouterNamespace();
                } else {
                    // TODO : Throw BridgeExeption (App Router doesnt implements the RouterInterface)
                }
            } else {
                $lunaRouterNamespace = self::LUNA_ROUTER_NAMESPACE;

                // TODO : Use DI (Dependency Injector)
	            $this->class = new $lunaRouterNamespace();
            }
        }

        public function init()
        {
            switch (get_class($this->class)) {
                case self::APP_ROUTER_NAMESPACE :
                default :
                    $this->class->init();
                    break;

            }
        }
    }
?>