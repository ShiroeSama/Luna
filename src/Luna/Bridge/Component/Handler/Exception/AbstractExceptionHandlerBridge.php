<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : AbstractExceptionHandlerBridge.php
     *   @Created_at : 15/03/2018
     *   @Update_at : 16/04/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Bridge\Component\Handler\Exception;

    use Luna\Bridge\Component\Handler\HandlerAbstractBridge;
    use Luna\Component\Exception\BridgeException;
    use Luna\Component\Exception\ConfigException;
    use Luna\Component\Handler\Exception\ExceptionHandler;
    use Luna\Component\Handler\Exception\ExceptionHandlerInterface;

    abstract class AbstractExceptionHandlerBridge extends HandlerAbstractBridge
    {
        # ----------------------------------------------------------
        # Constant

            protected const HANDLER_TYPE = 'Exception';
            protected const HANDLER_NAME = 'Default';
            protected const HANDLER_METHOD = 'onKernelException';
            protected const HANDLER_INTERFACE = ExceptionHandlerInterface::class;
            protected const LUNA_HANDLER_NAMESPACE = ExceptionHandler::class;

        # ----------------------------------------------------------
        # Attributes

            /** @var \Throwable */
            protected $throwable;


        /**
         * AbstractExceptionHandlerBridge constructor.
         *
         * @param \Throwable $throwable
         *
         * @throws BridgeException
         * @throws ConfigException
         */
        public function __construct(\Throwable $throwable)
        {
            parent::__construct();
            $this->throwable = $throwable;
        }


        /**
         * Call the handler
         *
         * @throws \Luna\Component\Exception\DependencyInjectorException
         */
        public function catchException()
        {
            $throwable = $this->throwable;
            $args = compact('throwable');

            $exceptionHandler = $this->DIModule->callConstructor($this->class, $args);
            $this->DIModule->callMethod($this->method, $exceptionHandler, $args);
        }
    }
?>