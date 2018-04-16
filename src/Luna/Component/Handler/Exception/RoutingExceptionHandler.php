<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : RoutingExceptionHandler.php
     *   @Created_at : 14/03/2018
     *   @Update_at : 16/04/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Component\Handler\Exception;

    class RoutingExceptionHandler extends ExceptionHandlerAbstract implements RoutingExceptionHandlerInterface
    {
        public function onRoutingException()
        {
            // Log the Exception
            $this->logException();

            // Show the exception
            $this->showException();
        }
    }
?>