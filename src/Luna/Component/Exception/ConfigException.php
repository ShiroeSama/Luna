<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : ConfigException.php
     *   @Created_at : 22/03/2018
     *   @Update_at : 22/03/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Component\Exception;

    class ConfigException extends LunaException
    {
        protected const DEFAULT_MESSAGE = 'Error Processing Config Request';
    }
?>