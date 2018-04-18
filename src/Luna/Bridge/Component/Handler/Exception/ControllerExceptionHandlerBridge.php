<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : ControllerExceptionHandlerBridge.php
     *   @Created_at : 18/04/2018
     *   @Update_at : 18/04/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Bridge\Component\Handler\Exception;

    use Luna\Component\Handler\Exception\ControllerExceptionHandler;
    use Luna\Component\Handler\Exception\ControllerExceptionHandlerInterface;

    class ControllerExceptionHandlerBridge extends AbstractExceptionHandlerBridge
    {
	    # ----------------------------------------------------------
        # Constant

            protected const HANDLER_NAME = 'Controller';
            protected const HANDLER_METHOD = 'onControllerException';
            protected const HANDLER_INTERFACE = ControllerExceptionHandlerInterface::class;
            protected const LUNA_HANDLER_NAMESPACE = ControllerExceptionHandler::class;
    }
?>