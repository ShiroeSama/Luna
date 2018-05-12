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
    use Luna\Component\Exception\ConfigException;
    use Luna\Component\Exception\DependencyInjectorException;

    class ExceptionDispatcherBridge extends DispatcherAbstractBridge
    {
        # ----------------------------------------------------------
        # Constant

            protected const DISPATCHER_NAME = 'Exception';
		    protected const DISPATCHER_TYPE = 'Default';
		    protected const DISPATCHER_CLASS = ExceptionDispatcher::class;
		    protected const DISPATCHER_METHOD = 'dispatch';
	
	    /**
	     * Call the Exception Dispatcher
	     *
	     * @param \Throwable $throwable
	     *
	     * @throws ConfigException
	     * @throws DependencyInjectorException
	     */
	    public function dispatch(\Throwable $throwable)
	    {
		    $args = compact('throwable');
		
		    $exceptionDispatcher = $this->DIModule->callConstructor($this->class, $args);
		    $this->DIModule->callMethod($this->method, $exceptionDispatcher, $args);
	    }
    }
?>