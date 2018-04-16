<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : RoutingExceptionHandlerInterface.php
     *   @Created_at : 16/04/2018
     *   @Update_at : 16/04/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Component\Handler\Exception;

    interface RoutingExceptionHandlerInterface
    {
        public function logException();

        public function showException();

        public function onRoutingException();
    }
?>