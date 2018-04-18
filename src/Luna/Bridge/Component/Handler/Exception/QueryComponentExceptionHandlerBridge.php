<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : QueryComponentExceptionHandlerBridge.php
     *   @Created_at : 18/04/2018
     *   @Update_at : 18/04/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Bridge\Component\Handler\Exception;

    use Luna\Component\Handler\Exception\DependencyInjectorExceptionHandler;
    use Luna\Component\Handler\Exception\DependencyInjectorExceptionHandlerInterface;

    class QueryComponentExceptionHandlerBridge extends AbstractExceptionHandlerBridge
    {
	    # ----------------------------------------------------------
        # Constant

            protected const HANDLER_NAME = 'QueryComponent';
            protected const HANDLER_METHOD = 'onQueryComponentException';
            protected const HANDLER_INTERFACE = DependencyInjectorExceptionHandlerInterface::class;
            protected const LUNA_HANDLER_NAMESPACE = DependencyInjectorExceptionHandler::class;
    }
?>