<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : KernelExceptionHandler.php
     *   @Created_at : 08/05/2018
     *   @Update_at : 08/05/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Component\Handler\Exception;

    class KernelExceptionHandler extends ExceptionHandlerAbstract implements KernelExceptionHandlerInterface
    {
        public function onKernelException()
        {
            // Log the Exception
            $this->logException();

            // Show the exception
            $this->showException();
        }
    }
?>