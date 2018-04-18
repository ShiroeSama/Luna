<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : ControllerExceptionHandler.php
     *   @Created_at : 18/04/2018
     *   @Update_at : 18/04/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Component\Handler\Exception;

    class ControllerExceptionHandler extends ExceptionHandlerAbstract implements ControllerExceptionHandlerInterface
    {
        public function onControllerException()
        {
            // Log the Exception
            $this->logException();

            // Show the exception
            $this->showException();
        }
    }
?>