<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : QueryComponentExceptionHandlerInterface.php
     *   @Created_at : 18/04/2018
     *   @Update_at : 18/04/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Component\Handler\Exception;

    interface QueryComponentExceptionHandlerInterface
    {
        public function logException();

        public function showException();

        public function onQueryComponentException();
    }
?>