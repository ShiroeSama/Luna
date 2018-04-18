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
     *   @Update_at : 18/04/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Bridge\Component\Handler\Exception;

    use Luna\Component\Handler\Exception\ConfigExceptionHandler;
    use Luna\Component\Handler\Exception\ConfigExceptionHandlerInterface;

    class ConfigExceptionHandlerBridge extends AbstractExceptionHandlerBridge
    {
	    # ----------------------------------------------------------
        # Constant

            protected const HANDLER_NAME = 'Config';
            protected const HANDLER_METHOD = 'onConfigException';
            protected const HANDLER_INTERFACE = ConfigExceptionHandlerInterface::class;
            protected const LUNA_HANDLER_NAMESPACE = ConfigExceptionHandler::class;
    }
?>