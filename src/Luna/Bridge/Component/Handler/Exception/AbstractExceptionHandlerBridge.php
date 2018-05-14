<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : AbstractExceptionHandlerBridge.php
     *   @Created_at : 15/03/2018
     *   @Update_at : 12/05/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Bridge\Component\Handler\Exception;

    use Luna\Bridge\Component\Handler\HandlerAbstractBridge;
    use Luna\Component\Exception\ConfigException;
    use Luna\Component\Exception\DependencyInjectorException;

    abstract class AbstractExceptionHandlerBridge extends HandlerAbstractBridge
    {
        # ----------------------------------------------------------
        # Constant
	
		    protected const HANDLER_NAME = 'Exception';
	
	
	    /**
	     * Call the handler
	     *
	     * @param \Throwable $throwable
	     *
	     * @throws ConfigException
	     * @throws DependencyInjectorException
	     */
        public function catchException(\Throwable $throwable)
        {
            $args = compact('throwable');

            $exceptionHandler = $this->DIModule->callConstructor($this->class, $args);
            $this->DIModule->callMethod($this->method, $exceptionHandler, $args);
        }
    }
?>