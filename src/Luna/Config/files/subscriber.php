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
     *   @Update_at : 16/04/2018
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
	        \Psr\Log\LoggerInterface::class => \Luna\Component\DI\Modules\LoggerDependencyInjectorSubscriber::class
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