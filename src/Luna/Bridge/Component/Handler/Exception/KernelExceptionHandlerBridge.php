<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : KernelExceptionHandlerBridge.php
     *   @Created_at : 08/05/2018
     *   @Update_at : 08/05/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Bridge\Component\Handler\Exception;

    use Luna\Component\Handler\Exception\BridgeExceptionHandler;
    use Luna\Component\Handler\Exception\BridgeExceptionHandlerInterface;
    use Luna\Component\Handler\Exception\KernelExceptionHandler;
    use Luna\Component\Handler\Exception\KernelExceptionHandlerInterface;

    class KernelExceptionHandlerBridge extends AbstractExceptionHandlerBridge
    {
	    # ----------------------------------------------------------
        # Constant

            protected const HANDLER_NAME = 'Kernel';
            protected const HANDLER_METHOD = 'onKernelException';
            protected const HANDLER_INTERFACE = KernelExceptionHandlerInterface::class;
            protected const LUNA_HANDLER_NAMESPACE = KernelExceptionHandler::class;
    }
?>