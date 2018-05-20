<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : ConsoleExceptionHandler.php
     *   @Created_at : 20/05/2018
     *   @Update_at : 20/05/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Component\Handler\Exception\Console;

    use Luna\Component\Handler\Exception\ExceptionHandlerAbstract;

    class ConsoleExceptionHandler extends ExceptionHandlerAbstract
    {
        public function onConsoleException()
        {
            // Log the Exception
            $this->logException();

            // Show the exception
            $this->showException();
        }
    }
?>