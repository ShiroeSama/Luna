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
     *   @Update_at : 12/05/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Bridge\Component\Handler\Exception;

    use Luna\Component\Handler\Exception\QueryComponentExceptionHandler;

    class QueryComponentExceptionHandlerBridge extends AbstractExceptionHandlerBridge
    {
	    # ----------------------------------------------------------
        # Constant
		
		    protected const HANDLER_TYPE = 'QueryComponent';
		    protected const HANDLER_CLASS = QueryComponentExceptionHandler::class;
		    protected const HANDLER_METHOD = 'onQueryComponentException';
    }
?>