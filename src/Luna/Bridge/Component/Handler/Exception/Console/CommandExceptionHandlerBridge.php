<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : CommandExceptionHandlerBridge.php
     *   @Created_at : 20/05/2018
     *   @Update_at : 20/05/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Bridge\Component\Handler\Exception\Console;

    use Luna\Bridge\Component\Handler\Exception\AbstractExceptionHandlerBridge;
    use Luna\Component\Handler\Exception\Console\CommandExceptionHandler;

    class CommandExceptionHandlerBridge extends AbstractExceptionHandlerBridge
    {
	    # ----------------------------------------------------------
        # Constant

            protected const HANDLER_TYPE = 'Command';
		    protected const HANDLER_CLASS = CommandExceptionHandler::class;
		    protected const HANDLER_METHOD = 'onCommandException';
    }
?>