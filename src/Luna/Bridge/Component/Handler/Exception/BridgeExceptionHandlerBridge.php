<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : BridgeExceptionHandlerBridge.php
     *   @Created_at : 18/04/2018
     *   @Update_at : 18/04/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Bridge\Component\Handler\Exception;

    use Luna\Component\Handler\Exception\BridgeExceptionHandler;
    use Luna\Component\Handler\Exception\BridgeExceptionHandlerInterface;

    class BridgeExceptionHandlerBridge extends AbstractExceptionHandlerBridge
    {
	    # ----------------------------------------------------------
        # Constant

            protected const HANDLER_NAME = 'Bridge';
            protected const HANDLER_METHOD = 'onBridgeException';
            protected const HANDLER_INTERFACE = BridgeExceptionHandlerInterface::class;
            protected const LUNA_HANDLER_NAMESPACE = BridgeExceptionHandler::class;
    }
?>