<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : RouteExceptionHandler.php
     *   @Created_at : 14/03/2018
     *   @Update_at : 12/05/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Component\Handler\Exception;

    class RouteExceptionHandler extends ExceptionHandlerAbstract
    {
        public function onRouteException()
        {
            // Log the Exception
            $this->logException();

            // Show the exception
            $this->showException();
        }
    }
?>