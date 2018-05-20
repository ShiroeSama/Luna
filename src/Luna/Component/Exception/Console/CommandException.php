<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : CommandException.php
     *   @Created_at : 17/05/2018
     *   @Update_at : 20/05/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Component\Exception\Console;

    class CommandException extends ConsoleException
    {
        protected const DEFAULT_MESSAGE = 'Error Processing Command Request';
    }
?>