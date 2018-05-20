<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : ConsoleExceptionHandlerBridge.php
     *   @Created_at : 20/05/2018
     *   @Update_at : 20/05/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Bridge\Component\Handler\Exception\Console;

    use Luna\Bridge\Component\Handler\Exception\AbstractExceptionHandlerBridge;
    use Luna\Component\Handler\Exception\Console\ConsoleExceptionHandler;

    class ConsoleExceptionHandlerBridge extends AbstractExceptionHandlerBridge
    {
	    # ----------------------------------------------------------
        # Constant

            protected const HANDLER_TYPE = 'Console';
		    protected const HANDLER_CLASS = ConsoleExceptionHandler::class;
		    protected const HANDLER_METHOD = 'onConsoleException';
    }
?>