<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : DatabaseExceptionHandlerBridge.php
     *   @Created_at : 18/04/2018
     *   @Update_at : 18/04/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Bridge\Component\Handler\Exception;

    use Luna\Component\Handler\Exception\DatabaseExceptionHandler;
    use Luna\Component\Handler\Exception\DatabaseExceptionHandlerInterface;

    class DatabaseExceptionHandlerBridge extends AbstractExceptionHandlerBridge
    {
	    # ----------------------------------------------------------
        # Constant

            protected const HANDLER_NAME = 'Database';
            protected const HANDLER_METHOD = 'onDatabaseException';
            protected const HANDLER_INTERFACE = DatabaseExceptionHandlerInterface::class;
            protected const LUNA_HANDLER_NAMESPACE = DatabaseExceptionHandler::class;
    }
?>