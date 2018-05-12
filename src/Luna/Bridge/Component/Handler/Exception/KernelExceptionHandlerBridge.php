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
     *   @Update_at : 12/05/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Bridge\Component\Handler\Exception;

    use Luna\Component\Handler\Exception\KernelExceptionHandler;

    class KernelExceptionHandlerBridge extends AbstractExceptionHandlerBridge
    {
	    # ----------------------------------------------------------
        # Constant
	
		    protected const HANDLER_TYPE = 'Kernel';
		    protected const HANDLER_CLASS = KernelExceptionHandler::class;
		    protected const HANDLER_METHOD = 'onKernelException';
    }
?>