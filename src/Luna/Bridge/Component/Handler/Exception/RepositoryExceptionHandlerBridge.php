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
     *   @Update_at : 18/04/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Bridge\Component\Handler\Exception;

    use Luna\Component\Handler\Exception\RepositoryExceptionHandler;
    use Luna\Component\Handler\Exception\RepositoryExceptionHandlerInterface;

    class RepositoryExceptionHandlerBridge extends AbstractExceptionHandlerBridge
    {
	    # ----------------------------------------------------------
        # Constant

            protected const HANDLER_NAME = 'Repository';
            protected const HANDLER_METHOD = 'onRepositoryException';
            protected const HANDLER_INTERFACE = RepositoryExceptionHandlerInterface::class;
            protected const LUNA_HANDLER_NAMESPACE = RepositoryExceptionHandler::class;
    }
?>