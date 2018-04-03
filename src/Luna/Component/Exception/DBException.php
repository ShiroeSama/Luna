<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : DBException.php
     *   @Created_at : 03/04/2018
     *   @Update_at : 03/04/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Component\Exception;

    class DBException extends LunaException
    {
        protected const DEFAULT_MESSAGE = 'Error Processing Database Request';
    }
?>