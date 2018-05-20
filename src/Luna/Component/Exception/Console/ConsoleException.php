<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : ConsoleException.php
     *   @Created_at : 17/05/2018
     *   @Update_at : 20/05/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Component\Exception\Console;

    use Luna\Component\Exception\LunaException;

    class ConsoleException extends LunaException
    {
	    public const DEFAULT_CODE = 1;
        protected const DEFAULT_MESSAGE = 'Error Processing Console Request';
    }
?>