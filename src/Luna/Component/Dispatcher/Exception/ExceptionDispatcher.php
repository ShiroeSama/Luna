<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : ExceptionDispatcher.php
     *   @Created_at : 12/04/2018
     *   @Update_at : 12/04/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Component\Dispatcher\Exception;

    use \PDOException;
    use \Throwable;

    use Luna\Component\Exception\BridgeException;
    use Luna\Component\Exception\ConfigException;
    use Luna\Component\Exception\ControllerException;
    use Luna\Component\Exception\DatabaseException;
    use Luna\Component\Exception\DependencyInjectorException;
    use Luna\Component\Exception\QueryComponentException;
    use Luna\Component\Exception\RepositoryException;
    use Luna\Component\Exception\RouteException;
    use Luna\Component\Handler\Exception\ExceptionHandler;

    class ExceptionDispatcher implements ExceptionDispatcherInterface
    {
        /**
         * ExceptionDispatcher constructor.
         */
        public function __construct()
        {
            $this->prepareBridge();
        }

        protected function prepareBridge()
        {
            try {
                // TODO : Instanciate the Bridge
            } catch (Throwable $throwable) {
                $handler = new ExceptionHandler($throwable);
                $handler->onKernelException();
            }
        }

        public function dispatcher(Throwable $throwable)
        {
            switch (get_class($throwable)) {
                // Other Exception

                case PDOException::class:
                    // TODO : Call the Bridge
                    break;

                // Luna Exception

                case BridgeException::class:
                    // TODO : Call the Bridge
                    break;

                case ConfigException::class:
                    // TODO : Call the Bridge
                    break;

                case ControllerException::class:
                    // TODO : Call the Bridge
                    break;

                case DatabaseException::class:
                    // TODO : Call the Bridge
                    break;

                case DependencyInjectorException::class:
                    // TODO : Call the Bridge
                    break;

                case QueryComponentException::class:
                    // TODO : Call the Bridge
                    break;

                case RepositoryException::class:
                    // TODO : Call the Bridge
                    break;

                case RouteException::class:
                    // TODO : Call the Bridge
                    break;

                default:
                    // TODO : Call the Bridge
                    break;
            }
        }
    }
?>