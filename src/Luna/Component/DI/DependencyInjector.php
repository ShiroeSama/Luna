<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : DependencyInjector.php
     *   @Created_at : 14/03/2018
     *   @Update_at : 14/03/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Component\DI;

    use Luna\Component\Bag\ParameterBag;
    use Luna\Component\Exception\ConfigException;
    use Luna\Component\Exception\DependencyInjectorException;
    use Luna\Component\HTTP\Request\Request;
    use Luna\Component\Utils\ClassManager;
    use \ReflectionClass;
    use \ReflectionMethod;

    use Luna\Controller\Controller;

    class DependencyInjector
    {
        /**
         * Allow to instantiate a controller dynamically
         * Prepare the construct's args and the controller object
         *
         * @param string $className
         * @param Request $request
         * @param array $args
         *
         * @return Controller
         *
         * @throws ConfigException
         * @throws DependencyInjectorException
         */
        public function callController(string $className, Request $request, array $args = []): Controller
        {
            if (!ClassManager::checkClassOf($className, Controller::class)) {
                throw new DependencyInjectorException(DependencyInjectorException::DEFAULT_CODE, "{$className} is not a Controller");
            }

            /** @var Controller $controller*/
            $controller = $this->callConstructor($className, $args);
            $controller->setRequest($request);

            return $controller;

        }
	
	    /**
	     * Allow to instantiate an object dynamically
	     * Prepare the construct's args
	     *
	     * @param string $className
	     * @param array $args
	     *
	     * @return mixed
	     *
	     * @throws ConfigException
	     * @throws DependencyInjectorException
	     */
        public function callConstructor(string $className, array $args = [])
        {
            if (!class_exists($className)) {
                throw new DependencyInjectorException(DependencyInjectorException::DEFAULT_CODE, "Class {$className} doesn't exist");
            }

            $reflectionClass = new ReflectionClass($className);
            $process = new DependencyInjectorProcess($this, new ParameterBag($args));

            return $process->construct($reflectionClass);
        }

        /**
         * Allow to calls a method with automatic instantiation of parameters
         *
         * @param string $method
         * @param $class
         * @param array $args
         *
         * @return mixed
         *
         * @throws ConfigException
         * @throws DependencyInjectorException
         */
        public function callMethod(string $method, $class, array $args = [])
        {
            if (!method_exists($class, $method)) {
                $className = (is_string($class) ? $class : get_class($class));
                throw new DependencyInjectorException(DependencyInjectorException::DEFAULT_CODE, "Method {$method} for {$className} doesn't exist)");
            }

            $reflectionMethod = new ReflectionMethod($class, $method);

            if (is_string($class)) {
                $class = $this->callConstructor($class, $args);
            }
            
	        $process = new DependencyInjectorProcess($this, new ParameterBag($args));

            return $process->method($reflectionMethod, $class);
        }
    }
?>