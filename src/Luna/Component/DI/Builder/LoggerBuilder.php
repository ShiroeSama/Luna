<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : LoggerBuilder.php
	 *   @Created_at : 10/05/2018
	 *   @Update_at : 10/05/2018
	 * --------------------------------------------------------------------------
	 */
	
	namespace Luna\Component\DI\Builder;
	
	use Luna\Component\Container\LunaContainer;
	use Luna\Kernel;
	use Monolog\Handler\StreamHandler;
	use Monolog\Logger;
	use Psr\Log\LoggerInterface;
	
	class LoggerBuilder
	{
		/**
		 * @param string $name
		 * @param string $logPath
		 * @return LoggerInterface
		 */
		public static function create(string $name, string $logPath) : LoggerInterface
		{
			$logger = new Logger($name);
			
			try {
				$streamHandler = new StreamHandler($logPath);
				$logger->pushHandler($streamHandler);
			} catch (\Exception $e) {}
			
			return $logger;
		}
		
		/**
		 * @return LoggerInterface
		 */
		public static function createExceptionLogger(): LoggerInterface
		{
			$kernel = LunaContainer::getInstance()->getKernel();
			
			$name = Kernel::APP_NAME . '.' . Kernel::LOG_EXCEPTION;
			$logPath = $kernel->getLogPath() . '/exception.log';
			
			return LoggerBuilder::create($name, $logPath);
		}
	}
?>