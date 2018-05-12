<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : ExceptionHandlerBridge.php
     *   @Created_at : 15/03/2018
     *   @Update_at : 12/05/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Bridge\Component\Handler\Exception;

    use Luna\Component\Handler\Exception\ExceptionHandler;

    class ExceptionHandlerBridge extends AbstractExceptionHandlerBridge
    {
	    # ----------------------------------------------------------
	    # Constant
	
		    protected const HANDLER_TYPE = 'Default';
		    protected const HANDLER_CLASS = ExceptionHandler::class;
		    protected const HANDLER_METHOD = 'onKernelException';
    }
?>