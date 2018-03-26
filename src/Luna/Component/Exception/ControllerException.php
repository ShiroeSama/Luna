<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : ControllerException.php
     *   @Created_at : 26/03/2018
     *   @Update_at : 26/03/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Component\Exception;

    class ControllerException extends LunaException
    {
        protected const DEFAULT_MESSAGE = 'Error Processing Controller Request';
    }
?>