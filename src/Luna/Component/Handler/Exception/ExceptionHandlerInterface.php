<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : ExceptionHandlerInterface.php
     *   @Created_at : 14/03/2018
     *   @Update_at : 12/04/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Component\Handler\Exception;

    interface ExceptionHandlerInterface
    {
        public function logException();

        public function showException();
    }
?>