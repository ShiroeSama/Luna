<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : handler.php
     *   @Created_at : 15/03/2018
     *   @Update_at : 12/05/2018
     * --------------------------------------------------------------------------
     */

    /*
    |--------------------------------------------------------------------------
    | Handler Configuration
    |--------------------------------------------------------------------------
    |
    */

    $Handler = [
	
	    /*
		|--------------------------------------------------------------------------
		| Access Handler
		|--------------------------------------------------------------------------
		|
		*/
	
	    'Access' => [
		    'Routing' => [
			    'class' => \Luna\Component\Handler\Access\RoutingAccessHandler::class,
			    'method' => 'access',
		    ]
	    ],

        /*
        |--------------------------------------------------------------------------
        | Exception Handler
        |--------------------------------------------------------------------------
        |
        */

        'Exception' => [
            'Default' => [
	            'class' => \Luna\Component\Handler\Exception\ExceptionHandler::class,
	            'method' => 'onKernelException',
            ],

            'Bridge' => [
	            'class' => \Luna\Component\Handler\Exception\BridgeExceptionHandler::class,
	            'method' => 'onBridgeException',
            ],

            'Config' => [
	            'class' => \Luna\Component\Handler\Exception\ConfigExceptionHandler::class,
	            'method' => 'onConfigException',
            ],

            'Controller' => [
	            'class' => \Luna\Component\Handler\Exception\ControllerExceptionHandler::class,
	            'method' => 'onControllerException',
            ],

            'Database' => [
	            'class' => \Luna\Component\Handler\Exception\DatabaseExceptionHandler::class,
	            'method' => 'onDatabaseException',
            ],

            'DependencyInjector' => [
	            'class' => \Luna\Component\Handler\Exception\DependencyInjectorExceptionHandler::class,
	            'method' => 'onDependencyInjectorException',
            ],

            'Kernel' => [
	            'class' => \Luna\Component\Handler\Exception\KernelExceptionHandler::class,
	            'method' => 'onKernelException',
            ],

            'QueryComponent' => [
	            'class' => \Luna\Component\Handler\Exception\QueryComponentExceptionHandler::class,
	            'method' => 'onQueryComponentException',
            ],

            'Repository' => [
	            'class' => \Luna\Component\Handler\Exception\RepositoryExceptionHandler::class,
	            'method' => 'onRepositoryException',
            ],

            'Route' => [
	            'class' => \Luna\Component\Handler\Exception\RouteExceptionHandler::class,
	            'method' => 'onRouteException',
            ],
        ],
    ];

    /*
    |--------------------------------------------------------------------------
    | Return Handler Configuration
    |--------------------------------------------------------------------------
    |
    */

    return $Handler;
?>