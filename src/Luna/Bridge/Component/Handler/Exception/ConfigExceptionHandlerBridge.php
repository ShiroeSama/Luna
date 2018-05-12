<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : ConfigExceptionHandlerBridge.php
     *   @Created_at : 18/04/2018
     *   @Update_at : 12/05/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Bridge\Component\Handler\Exception;

    use Luna\Component\Handler\Exception\ConfigExceptionHandler;

    class ConfigExceptionHandlerBridge extends AbstractExceptionHandlerBridge
    {
	    # ----------------------------------------------------------
        # Constant

            protected const HANDLER_TYPE = 'Config';
		    protected const HANDLER_CLASS = ConfigExceptionHandler::class;
		    protected const HANDLER_METHOD = 'onConfigException';
    }
?>