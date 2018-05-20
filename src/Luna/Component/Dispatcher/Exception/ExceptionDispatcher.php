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
     *   @Update_at : 19/04/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Component\Dispatcher\Exception;

    use Luna\Bridge\Component\Handler\Exception\BridgeExceptionHandlerBridge;
    use Luna\Bridge\Component\Handler\Exception\ConfigExceptionHandlerBridge;
    use Luna\Bridge\Component\Handler\Exception\Console\CommandExceptionHandlerBridge;
    use Luna\Bridge\Component\Handler\Exception\Console\ConsoleExceptionHandlerBridge;
    use Luna\Bridge\Component\Handler\Exception\Console\InputArgumentExceptionHandlerBridge;
    use Luna\Bridge\Component\Handler\Exception\ControllerExceptionHandlerBridge;
    use Luna\Bridge\Component\Handler\Exception\DatabaseExceptionHandlerBridge;
    use Luna\Bridge\Component\Handler\Exception\DependencyInjectorExceptionHandlerBridge;
    use Luna\Bridge\Component\Handler\Exception\ExceptionHandlerBridge;
    use Luna\Bridge\Component\Handler\Exception\KernelExceptionHandlerBridge;
    use Luna\Bridge\Component\Handler\Exception\QueryComponentExceptionHandlerBridge;
    use Luna\Bridge\Component\Handler\Exception\RepositoryExceptionHandlerBridge;
    use Luna\Bridge\Component\Handler\Exception\RouteExceptionHandlerBridge;
    use Luna\Component\DI\Builder\LoggerBuilder;
    use Luna\Component\Exception\BridgeException;
    use Luna\Component\Exception\ConfigException;
    use Luna\Component\Exception\Console\CommandException;
    use Luna\Component\Exception\Console\ConsoleException;
    use Luna\Component\Exception\Console\InputArgumentException;
    use Luna\Component\Exception\ControllerException;
    use Luna\Component\Exception\DatabaseException;
    use Luna\Component\Exception\DependencyInjectorException;
    use Luna\Component\Exception\KernelException;
    use Luna\Component\Exception\QueryComponentException;
    use Luna\Component\Exception\RepositoryException;
    use Luna\Component\Exception\RouteException;
    use Luna\Component\Handler\Exception\ExceptionHandler;
    use Luna\KernelInterface;


    use \PDOException;
    use \Throwable;

    class ExceptionDispatcher implements ExceptionDispatcherInterface
    {
        /** @var BridgeExceptionHandlerBridge */
        protected $bridgeExceptionHandlerBridge;
	
	    /** @var CommandExceptionHandlerBridge */
	    protected $commandExceptionHandlerBridge;

        /** @var ConfigExceptionHandlerBridge */
        protected $configExceptionHandlerBridge;
	
	    /** @var ConsoleExceptionHandlerBridge */
	    protected $consoleExceptionHandlerBridge;

        /** @var ControllerExceptionHandlerBridge */
        protected $controllerExceptionHandlerBridge;

        /** @var DatabaseExceptionHandlerBridge */
        protected $databaseExceptionHandlerBridge;

        /** @var DependencyInjectorExceptionHandlerBridge */
        protected $dependencyInjectorExceptionHandlerBridge;
	
	    /** @var InputArgumentExceptionHandlerBridge */
	    protected $inputArgumentExceptionHandlerBridge;
	
	    /** @var KernelExceptionHandlerBridge */
	    protected $kernelExceptionHandlerBridge;

        /** @var QueryComponentExceptionHandlerBridge */
        protected $queryComponentExceptionHandlerBridge;

        /** @var RepositoryExceptionHandlerBridge */
        protected $repositoryExceptionHandlerBridge;

        /** @var RouteExceptionHandlerBridge */
        protected $routeExceptionHandlerBridge;

        /** @var ExceptionHandlerBridge */
        protected $defaultExceptionHandlerBridge;

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
                // Bridge Exception Handler
                $this->bridgeExceptionHandlerBridge = new BridgeExceptionHandlerBridge();
                $this->bridgeExceptionHandlerBridge->bridge();
	
	            // Command Exception Handler
	            $this->commandExceptionHandlerBridge = new CommandExceptionHandlerBridge();
	            $this->commandExceptionHandlerBridge->bridge();

                // Config Exception Handler
                $this->configExceptionHandlerBridge = new ConfigExceptionHandlerBridge();
	            $this->configExceptionHandlerBridge->bridge();
	
	            // Console Exception Handler
	            $this->consoleExceptionHandlerBridge = new ConsoleExceptionHandlerBridge();
	            $this->consoleExceptionHandlerBridge->bridge();

                // Controller Exception Handler
                $this->controllerExceptionHandlerBridge = new ControllerExceptionHandlerBridge();
	            $this->controllerExceptionHandlerBridge->bridge();

                // Database Exception Handler
                $this->databaseExceptionHandlerBridge = new DatabaseExceptionHandlerBridge();
	            $this->databaseExceptionHandlerBridge->bridge();

                // Dependency Injector Exception Handler
                $this->dependencyInjectorExceptionHandlerBridge = new DependencyInjectorExceptionHandlerBridge();
	            $this->dependencyInjectorExceptionHandlerBridge->bridge();
	
	            // Input Argument Exception Handler
	            $this->inputArgumentExceptionHandlerBridge = new InputArgumentExceptionHandlerBridge();
	            $this->inputArgumentExceptionHandlerBridge->bridge();
	
	            // Kernel Component Exception Handler
	            $this->kernelExceptionHandlerBridge = new KernelExceptionHandlerBridge();
	            $this->kernelExceptionHandlerBridge->bridge();

                // Query Component Exception Handler
                $this->queryComponentExceptionHandlerBridge = new QueryComponentExceptionHandlerBridge();
	            $this->queryComponentExceptionHandlerBridge->bridge();

                // Repository Exception Handler
                $this->repositoryExceptionHandlerBridge = new RepositoryExceptionHandlerBridge();
	            $this->repositoryExceptionHandlerBridge->bridge();

                // Route Exception Handler
                $this->routeExceptionHandlerBridge = new RouteExceptionHandlerBridge();
	            $this->routeExceptionHandlerBridge->bridge();

                // Default Exception Handler
                $this->defaultExceptionHandlerBridge = new ExceptionHandlerBridge();
	            $this->defaultExceptionHandlerBridge->bridge();
            } catch (Throwable $throwable) {
	            $logger = LoggerBuilder::createExceptionLogger();
	            $handler = new ExceptionHandler($logger, $throwable);
                $handler->onKernelException();
            }
        }

        /**
         * Dispatch the throwable in the correct handler
         *
         * @param Throwable $throwable
         */
        public function dispatch(Throwable $throwable)
        {
            try {
                switch (get_class($throwable)) {
	                // --------------------------------
                    // Other Exception

                    case PDOException::class:
                        $this->databaseExceptionHandlerBridge->catchException($throwable);
                        break;
	
	                // --------------------------------
	                // Luna Console Exception
	
	                case CommandException::class:
	                	$this->commandExceptionHandlerBridge->catchException($throwable);
		                break;
	                
	                case ConsoleException::class:
		                $this->consoleExceptionHandlerBridge->catchException($throwable);
		                break;
	
	                case InputArgumentException::class:
		                $this->inputArgumentExceptionHandlerBridge->catchException($throwable);
		                break;
	                	
	
	                // --------------------------------
                    // Luna Exception

                    case BridgeException::class:
                        $this->bridgeExceptionHandlerBridge->catchException($throwable);
                        break;

                    case ConfigException::class:
                        $this->configExceptionHandlerBridge->catchException($throwable);
                        break;

                    case ControllerException::class:
                        $this->controllerExceptionHandlerBridge->catchException($throwable);
                        break;

                    case DatabaseException::class:
                        $this->databaseExceptionHandlerBridge->catchException($throwable);
                        break;

                    case DependencyInjectorException::class:
                        $this->dependencyInjectorExceptionHandlerBridge->catchException($throwable);
                        break;
	
	                case KernelException::class:
		                $this->kernelExceptionHandlerBridge->catchException($throwable);
		                break;

                    case QueryComponentException::class:
                        $this->queryComponentExceptionHandlerBridge->catchException($throwable);
                        break;

                    case RepositoryException::class:
                        $this->repositoryExceptionHandlerBridge->catchException($throwable);
                        break;

                    case RouteException::class:
                        $this->routeExceptionHandlerBridge->catchException($throwable);
                        break;

                    default:
                        $this->defaultExceptionHandlerBridge->catchException($throwable);
                        break;
                }
            } catch (Throwable $throwable) {
	            $logger = LoggerBuilder::createExceptionLogger();
	            $handler = new ExceptionHandler($logger, $throwable);
                $handler->onKernelException();
            }
        }
    }
?>