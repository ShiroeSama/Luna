<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : RepositoryExceptionHandlerBridge.php
     *   @Created_at : 18/04/2018
     *   @Update_at : 12/05/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Bridge\Component\Handler\Exception;

    use Luna\Component\Handler\Exception\RepositoryExceptionHandler;

    class RepositoryExceptionHandlerBridge extends AbstractExceptionHandlerBridge
    {
	    # ----------------------------------------------------------
	    # Constant
	
		    protected const HANDLER_TYPE = 'Repository';
		    protected const HANDLER_CLASS = RepositoryExceptionHandler::class;
		    protected const HANDLER_METHOD = 'onRepositoryException';
    }
?>