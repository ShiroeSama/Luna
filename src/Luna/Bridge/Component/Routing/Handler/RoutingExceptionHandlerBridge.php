<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : RoutingExceptionHandlerBridge.php
     *   @Created_at : 15/03/2018
     *   @Update_at : 15/03/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Bridge\Component\Routing;

    use Luna\Bridge\BridgeInterface;
    use Luna\Bridge\BridgeTrait;
    use Luna\Component\Routing\Handler\RoutingExceptionHandler;
    use Luna\Component\Routing\RouterInterface;
    use Luna\Config;

    class RoutingExceptionHandlerBridge implements BridgeInterface
    {
        # ----------------------------------------------------------
        # Trait

            use BridgeTrait;



        # ----------------------------------------------------------
        # Constant

            protected const LUNA_ROUTING_EXCEPTION_HANDLE_NAMESPACE = RoutingExceptionHandler::class;



        # ----------------------------------------------------------
        # Attributes

            /** @var Config */
            protected $ConfigModule;

            /** @var string */
            protected $method;


        /**
         * RoutingExceptionHandlerBridge constructor.
         */
        public function __construct()
        {
            $this->ConfigModule = Config::getInstance();
        }


        /**
         * Allow to instance the Luna Router or the App Router
         * Make bridge between the app and the framework
         *
         * @return RouterInterface
         */
        public function bridge(): RouterInterface
        {
            $handler = $this->ConfigModule->getHandler('Routing.Exception');

            if (!is_null($handler)) {
                $class = $this->getClass($handler);
                $method = $this->getMethod($handler);

                # Set Informations
                $this->method = $method;

                if (class_exists($class)) {
                    // TODO : Use DI (Dependency Injector)
                    return new $class();
                }
            }

            $lunaRoutingExceptionHandlerNamespace = self::LUNA_ROUTING_EXCEPTION_HANDLE_NAMESPACE;

            // TODO : Use DI (Dependency Injector)
            return new $lunaRoutingExceptionHandlerNamespace();
        }

        /**
         * Returns the class to use for routing exception handler
         *
         * @param array $handler
         * @return string
         */
        protected function getClass(array $handler): string
        {
            if (array_key_exists('class', $handler)) {
                return $handler['class'];
            }
            // TODO : Throw BridgeException (Redefining the routing exception handler without specified class)
        }


        /**
         * Returns the name of the method to call for the routing exception handler
         *
         * @param array $handler
         * @return string
         */
        protected function getMethod(array $handler): string
        {
            if (array_key_exists('method', $handler)) {
                return $handler['method'];
            }
            return 'onHandlerEvent';
        }
    }
?>