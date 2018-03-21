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

    use \ReflectionClass;
    use \ReflectionMethod;
    use \ReflectionParameter;

    use Luna\Controller\Controller;

    class DependencyInjector
    {
        protected const METHOD_CONSTRUCT = '__construct';
        protected $args = [];


        /**
         * Allow to instantiate a controller dynamically
         * Prepare the construct's args and the controller object
         *
         * @param string $className
         * @param array $args
         * @return Controller
         */
        public function callController(string $className, array $args = []): Controller
        {
            if (!is_a($className, Controller::class)) {
                // TODO : Throw DependencyInjector Exception ({$className} is not a Controller)
            }

            /** @var Controller $controller*/
            $controller = $this->callController($className, $args);

            return $controller;

        }

        /**
         * Allow to instantiate an object dynamically
         * Prepare the construct's args
         *
         * @param string $className
         * @param array $args
         * @return mixed
         */
        public function callConstructor(string $className, array $args = [])
        {
            if (!class_exists($className)) {
                // TODO : Throw DependencyInjector Exception (Class {$className} doesn't exist))
            }

            $reflectionClass = new ReflectionClass($className);
            $this->args = $args;

            return $this->constructorProcess($reflectionClass);
        }

        /**
         * Allow to calls a method with automatic instantiation of parameters
         *
         * @param string $method
         * @param $class
         * @param array $args
         * @return mixed
         */
        public function callMethod(string $method, $class, array $args = [])
        {
            if (!method_exists($class, $method)) {
                // TODO : Throw DependencyInjector Exception (Method {$method} for {$className} doesn't exist))
            }

            $reflectionMethod = new ReflectionMethod($class, $method);

            if (is_string($class)) {
                $class = $this->callConstructor($class, $args);
            }

            return $this->methodProcess($reflectionMethod, $class);
        }


        /**
         * System to construct the object recursively
         *
         * @param ReflectionClass $reflectionClass
         * @return mixed
         */
        protected function constructorProcess(ReflectionClass $reflectionClass)
        {
            $className = $reflectionClass->getName();

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
                // TODO : Throw DependencyInjector Exception (Class {$parameterClassName} not instantiable (private or protected constructor))
            }
        }

        /**
         * System to call the method
         *
         * @param ReflectionMethod $reflectionMethod
         * @param $object
         * @return mixed
         */
        protected function methodProcess(ReflectionMethod $reflectionMethod, $object)
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
         * Construct the parameter of the call
         *
         * @param ReflectionParameter $parameter
         * @return mixed
         */
        protected function getParameter(ReflectionParameter $parameter)
        {
            $parameterName = $parameter->getName();

            if (array_key_exists($parameterName, $this->args)) {
                return $this->args[$parameterName];
            }

            $className = $parameter->getType()->getName();
            if (!class_exists($className)) {
                // TODO : Throw DependencyInjector Exception (Class {$className} doesn't exist))
            }

            $parameterClass = $parameter->getClass();

            if (is_null($parameterClass)) {
                // TODO : Throw Dependency Injector Exception (Cannot inject a value for attribut {$parameterName})
            }

            return $this->constructorProcess($parameterClass);
        }
    }
?>