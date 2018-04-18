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
        /**
         * Dispatch the throwable in the correct handler
         *
         * @param Throwable $throwable
         */
        public function dispatch(Throwable $throwable);
    }
?>