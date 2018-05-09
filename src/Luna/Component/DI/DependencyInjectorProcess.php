<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : DependencyInjectorProcess.php
     *   @Created_at : 08/05/2018
     *   @Update_at : 08/05/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Component\DI;

    use Luna\Component\Bag\ParameterBag;
    use Luna\Component\DI\Modules\DependencyInjectorSubscriberInterface;
    use Luna\Component\Exception\ConfigException;
    use Luna\Component\Exception\DependencyInjectorException;
    use Luna\Config\Config;

    use \ReflectionClass;
    use \ReflectionMethod;
    use \ReflectionParameter;

    class DependencyInjectorProcess
    {
    	protected const DI_SUBSCRIBER = 'DependencyInjector';
    	
    	/** @var Config */
		protected $ConfigModule;
	
	    /** @var DependencyInjector */
	    protected $dependencyInjector;
		
		/** @var ParameterBag */
		protected $args;
    	
	    /**
	     * DependencyInjectorProcess constructor.
	     */
	    public function __construct(DependencyInjector $dependencyInjector, ParameterBag $args)
	    {
	    	$this->ConfigModule = Config::getInstance();
	    	$this->dependencyInjector = $dependencyInjector;
	    	$this->args = $args;
	    }
	
	    /**
	     * System to construct the object recursively
	     *
	     * @param ReflectionClass $reflectionClass
	     *
	     * @return mixed
	     *
	     * @throws ConfigException
	     * @throws DependencyInjectorException
	     */
	    public function construct(ReflectionClass $reflectionClass)
	    {
	    	// Get name of the class
		    $className = $reflectionClass->getName();
	    	
	    	// Get subscriber (DI Module)
	    	$subscriber = $this->getDISubscriber($className);
	    	
	    	if (!is_null($subscriber)) {
	    		$object = $subscriber->process($reflectionClass, $this->args);
	    		
	    		if (!is_object($object)) {
	    			$subscriberName = get_class($subscriber);
				    throw new DependencyInjectorException("The subscriber '{$subscriberName}' must be return an object");
			    }
			    return $object;
		    } else {
			    if ($reflectionClass->isInstantiable()) {
				    $reflectionConstructor = $reflectionClass->getConstructor();
				    $reflectionConstructorArgs = [];
				
				    if (!is_null($reflectionConstructor)) {
					    $reflectionConstructorArgs = $reflectionConstructor->getParameters();
				    }
				
				    $constructArgs = [];
				    /** @var ReflectionParameter $parameter */
				    foreach ($reflectionConstructorArgs as $parameter) {
					    $parameter = $this->getParameter($parameter);
					    array_push($constructArgs, $parameter);
				    }
				
				    return (empty($constructArgs) ? new $className() : $reflectionClass->newInstanceArgs($constructArgs));
			    } else {
				    throw new DependencyInjectorException("Class {$className} not instantiable (private or protected constructor)");
			    }
		    }
	    }
	
	    /**
	     * System to call the method
	     *
	     * @param ReflectionMethod $reflectionMethod
	     * @param $object
	     *
	     * @return mixed
	     *
	     * @throws ConfigException
	     * @throws DependencyInjectorException
	     */
	    public function method(ReflectionMethod $reflectionMethod, $object)
	    {
		    $reflectionMethodArgs = $reflectionMethod->getParameters();
		
		    $methodArgs = [];
		    /** @var ReflectionParameter $parameter */
		    foreach ($reflectionMethodArgs as $parameter) {
			    $parameter = $this->getParameter($parameter);
			    array_push($methodArgs, $parameter);
		    }
		
		    if (empty($methodArgs)) {
			    return $reflectionMethod->invoke($object);
		    } else {
			    return $reflectionMethod->invokeArgs($object, $methodArgs);
		    }
	    }
	
	    /**
	     * Get all DI Subscriber for know how to create correctly many objects
	     *
	     * @param string $className
	     *
	     * @return DependencyInjectorSubscriberInterface|null
	     *
	     * @throws ConfigException
	     */
	    protected function getDISubscriber(string $className): ?DependencyInjectorSubscriberInterface
	    {
		    // Get DI Modules
		    $DIModules = $this->ConfigModule->getSubscriber(self::DI_SUBSCRIBER);
		    
		    $subscriber = NULL;
		    
		    if (is_array($DIModules) && !empty($DIModules)) {
			    foreach ($DIModules as $class => $module) {
					if (is_a($module, DependencyInjectorSubscriberInterface::class)) {
						$subscriber = (is_a($class, $className)) ? $module : NULL;
					}
			    }
		    }
		    
		    return is_null($subscriber) ? NULL : new $subscriber($this->dependencyInjector);
	    }
	
	    /**
	     * Construct the parameter of the call
	     *
	     * @param ReflectionParameter $parameter
	     * @return mixed
	     *
	     * @throws ConfigException
	     * @throws DependencyInjectorException
	     */
	    protected function getParameter(ReflectionParameter $parameter)
	    {
		    $parameterName = $parameter->getName();
		
		    if ($this->args->has($parameterName)) {
			    return $this->args[$parameterName];
		    }
		
		    $className = $parameter->getType()->getName();
		    if (!class_exists($className)) {
			    throw new DependencyInjectorException("Class {$className} doesn't exist)");
		    }
		
		    $parameterClass = $parameter->getClass();
		
		    if (is_null($parameterClass)) {
			    throw new DependencyInjectorException("Cannot inject a value for attribut {$parameterName}");
		    }
		
		    return $this->construct($parameterClass);
	    }
    }
?>