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
     *   @Update_at : 12/05/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Bridge\Component\Handler\Exception;

    use Luna\Component\Handler\Exception\DatabaseExceptionHandler;

    class DatabaseExceptionHandlerBridge extends AbstractExceptionHandlerBridge
    {
	    # ----------------------------------------------------------
        # Constant
	
		    protected const HANDLER_TYPE = 'Database';
		    protected const HANDLER_CLASS = DatabaseExceptionHandler::class;
		    protected const HANDLER_METHOD = 'onDatabaseException';
    }
?>