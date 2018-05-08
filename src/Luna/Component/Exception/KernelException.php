<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : KernelException.php
     *   @Created_at : 08/05/2018
     *   @Update_at : 08/05/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Component\Exception;

    class KernelException extends LunaException
    {
        protected const DEFAULT_MESSAGE = 'Error Processing Kernel Request';
    }
?>