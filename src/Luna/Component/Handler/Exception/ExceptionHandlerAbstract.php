<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : ExceptionHandlerAbstract.php
     *   @Created_at : 21/03/2018
     *   @Update_at : 10/05/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Component\Handler\Exception;

    use Luna\KernelInterface;
    use Psr\Log\LoggerInterface;
    use \Throwable;


    abstract class ExceptionHandlerAbstract
    {
    	protected const LOGGER_NAME = 'Luna.Exception';
    	
        /** @var string */
        protected $logPath;

        /** @var LoggerInterface */
        protected $logger;

        /** @var Throwable */
        protected $throwable;

        /**
         * ExceptionHandlerTrait constructor.
         * @param Throwable $throwable
         */
        public function __construct(KernelInterface $kernel, LoggerInterface $logger, Throwable $throwable)
        {
	        $env = $kernel->getEnv();
	
	        $this->throwable = $throwable;
            $this->logger = $logger;
        }

        public function logException()
        {
            $this->logger->error('--------------------------------');
	        $this->logger->error('Exception Class : ' . get_class($this->throwable));
            $this->logger->error('Message : ' . $this->throwable->getMessage());
            $this->logger->error('--------------------------------');
        }

        public function showException()
        {
            $code = $this->throwable->getCode();

            // TODO : Render the Exception
        }
    }
?>