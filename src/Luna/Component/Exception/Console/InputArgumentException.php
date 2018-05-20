<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : InputArgumentException.php
     *   @Created_at : 19/05/2018
     *   @Update_at : 20/05/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Component\Exception\Console;

    class InputArgumentException extends ConsoleException
    {
        protected const DEFAULT_MESSAGE = 'Error Processing Input Argument Request';
    }
?>