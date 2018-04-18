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
     *   @Update_at : 21/03/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Component\Handler\Exception;

    use Luna\Kernel;
    use Monolog\Handler\StreamHandler;
    use Monolog\Logger;
    use Psr\Log\LoggerInterface;
    use \Throwable;


    abstract class ExceptionHandlerAbstract
    {
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
        public function __construct(Throwable $throwable)
        {
            $this->logPath = APP_ROOT . '/var/log/' . Kernel::getEnv() . '/exception.log';
            $this->logger = new Logger(new StreamHandler($this->logPath));
        }

        public function logException()
        {
            $this->logger->error('--------------------------------');
            $this->logger->error(__METHOD__ . ' : ' . $this->throwable->getMessage());
            $this->logger->error('--------------------------------');
        }

        public function showException()
        {
            $code = $this->throwable->getCode();

            // TODO : Render the Exception
        }
    }
?>