<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : LoggerDependencyInjectorSubscriber.php
	 *   @Created_at : 08/05/2018
	 *   @Update_at : 10/05/2018
	 * --------------------------------------------------------------------------
	 */
	
	namespace Luna\Component\DI\Modules;
	
	use Luna\Component\Bag\ParameterBag;
	use Luna\Component\Handler\Exception\ExceptionHandlerAbstract;
	use Luna\Kernel;
	use ReflectionClass;
	
	class LoggerDependencyInjectorSubscriber extends DependencyInjectorAbstractSubscriber
	{
		public function process(ReflectionClass $reflectionClass, ParameterBag $args)
		{
			// Get Kernel
			$kernel = $this->container->getKernel();
			
			// Get log path
			$path = $kernel->getLogPath();
			
			// Get class name who need a logger
			$className = $reflectionClass->getName();
			
			$loggerName = Kernel::APP_NAME;
			$logPath = $path . '.log';
			
			if (is_a($className, ExceptionHandlerAbstract::class)) {
				return LoggerBuilder::createExceptionLogger();
			}
			
			return LoggerBuilder::create($loggerName, $logPath);
		}
	}
?>