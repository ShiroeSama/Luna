<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : ExceptionDispatcherBridge.php
     *   @Created_at : 15/03/2018
     *   @Update_at : 16/04/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Bridge\Component\Dispatcher\Exception;

    use Luna\Bridge\Component\Dispatcher\DispatcherAbstractBridge;
    use Luna\Component\Dispatcher\Exception\ExceptionDispatcher;
    use Luna\Component\Dispatcher\Exception\ExceptionDispatcherInterface;

    class ExceptionDispatcherBridge extends DispatcherAbstractBridge
    {
        # ----------------------------------------------------------
        # Constant

            protected const DISPATCHER_NAME = 'Exception';
            protected const DISPATCHER_METHOD = 'dispatch';
            protected const DISPATCHER_INTERFACE = ExceptionDispatcherInterface::class;
            protected const LUNA_DISPATCHER_NAMESPACE = ExceptionDispatcher::class;
    }
?>