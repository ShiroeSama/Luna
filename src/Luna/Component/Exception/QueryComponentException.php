<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : QueryComponentException.php
     *   @Created_at : 05/04/2018
     *   @Update_at : 05/04/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Component\Exception;

    class QueryComponentException extends LunaException
    {
        protected const DEFAULT_MESSAGE = 'Error Processing Query Component Request';
    }
?>