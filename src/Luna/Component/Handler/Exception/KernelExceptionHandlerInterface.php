<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : KernelExceptionHandlerInterface.php
     *   @Created_at : 08/05/2018
     *   @Update_at : 08/05/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Component\Handler\Exception;

    interface KernelExceptionHandlerInterface
    {
        public function logException();

        public function showException();

        public function onKernelException();
    }
?>