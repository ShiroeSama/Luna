<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : subscriber.php
     *   @Created_at : 16/04/2018
     *   @Update_at : 10/05/2018
     * --------------------------------------------------------------------------
     */

    /*
    |--------------------------------------------------------------------------
    | Subscriber Configuration
    |--------------------------------------------------------------------------
    |
    */

    $Subscriber = [

        /*
        |--------------------------------------------------------------------------
        | Dependency Injector Subscriber
        |--------------------------------------------------------------------------
        |
        */

        'DependencyInjector' => [
	        \Luna\Component\Container\LunaContainer::class => \Luna\Component\DI\Modules\ContainerDependencyInjectorSubscriber::class,
	        \Luna\Config\Config::class                     => \Luna\Component\DI\Modules\ConfigDependencyInjectorSubscriber::class,
	        \Luna\KernelInterface::class                   => \Luna\Component\DI\Modules\KernelDependencyInjectorSubscriber::class,
	        \Psr\Log\LoggerInterface::class                => \Luna\Component\DI\Modules\LoggerDependencyInjectorSubscriber::class,
        ]
    ];

    /*
    |--------------------------------------------------------------------------
    | Return Subscriber Configuration
    |--------------------------------------------------------------------------
    |
    */

    return $Subscriber;
?>