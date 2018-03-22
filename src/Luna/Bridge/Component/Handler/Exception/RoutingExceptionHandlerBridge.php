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

    namespace Luna\Bridge\Component\Handler\Exception;

    use \Throwable;
    use Luna\Component\Handler\Exception\RoutingExceptionHandler;

    class RoutingExceptionHandlerBridge extends ExceptionHandlerAbstractBridge
    {
	    # ----------------------------------------------------------
        # Constant

            protected const EXCEPTION_HANDLER_NAME = 'Routing';
            protected const DEFAULT_HANDLER_METHOD = 'onRoutingException';
            protected const LUNA_HANDLER_EXCEPTION_NAMESPACE = RoutingExceptionHandler::class;
    }
?>