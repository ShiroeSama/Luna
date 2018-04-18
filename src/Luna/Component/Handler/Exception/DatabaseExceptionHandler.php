<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : DatabaseExceptionHandler.php
     *   @Created_at : 18/04/2018
     *   @Update_at : 18/04/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Component\Handler\Exception;

    class DatabaseExceptionHandler extends ExceptionHandlerAbstract implements DatabaseExceptionHandlerInterface
    {
        public function onDatabaseException()
        {
            // Log the Exception
            $this->logException();

            // Show the exception
            $this->showException();
        }
    }
?>