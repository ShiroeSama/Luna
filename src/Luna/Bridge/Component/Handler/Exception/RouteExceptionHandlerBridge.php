<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : RouteExceptionHandlerBridge.php
     *   @Created_at : 15/03/2018
     *   @Update_at : 18/04/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Bridge\Component\Handler\Exception;

    use Luna\Component\Handler\Exception\RouteExceptionHandler;
    use Luna\Component\Handler\Exception\RouteExceptionHandlerInterface;

    class RouteExceptionHandlerBridge extends AbstractExceptionHandlerBridge
    {
	    # ----------------------------------------------------------
        # Constant

            protected const HANDLER_NAME = 'Route';
            protected const HANDLER_METHOD = 'onRouteException';
            protected const HANDLER_INTERFACE = RouteExceptionHandlerInterface::class;
            protected const LUNA_HANDLER_NAMESPACE = RouteExceptionHandler::class;
    }
?>