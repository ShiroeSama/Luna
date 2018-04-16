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
     *   @Update_at : 16/04/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Bridge\Component\Handler\Exception;

    use Luna\Component\Handler\Exception\RoutingExceptionHandler;
    use Luna\Component\Handler\Exception\RoutingExceptionHandlerInterface;

    class RoutingExceptionHandlerBridge extends AbstractExceptionHandlerBridge
    {
	    # ----------------------------------------------------------
        # Constant

            protected const HANDLER_TYPE = 'Exception';
            protected const HANDLER_NAME = 'Routing';
            protected const HANDLER_METHOD = 'onRoutingException';
            protected const HANDLER_INTERFACE = RoutingExceptionHandlerInterface::class;
            protected const LUNA_HANDLER_NAMESPACE = RoutingExceptionHandler::class;
    }
?>