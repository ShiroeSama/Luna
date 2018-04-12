<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : ExceptionDispatcherInterface.php
     *   @Created_at : 12/04/2018
     *   @Update_at : 12/04/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Component\Dispatcher\Exception;

    use \Throwable;

    interface ExceptionDispatcherInterface
    {
        public function dispatcher(Throwable $throwable);
    }
?>