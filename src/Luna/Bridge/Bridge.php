<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : RouterInterface.php
     *   @Created_at : 14/03/2018
     *   @Update_at : 14/03/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Bridge;

    use Luna\Component\DI\DependencyInjector;
    use Luna\Component\Exception\BridgeException;
    use Luna\Config;

    abstract class Bridge
    {
	    /** @var Config */
	    protected $ConfigModule;

        /** @var DependencyInjector */
        protected $DIModule;

        /** @var string */
	    protected $class;
	
	    /**
	     * BridgeTrait constructor.
	     */
	    public function __construct()
	    {
		    $this->ConfigModule = Config::getInstance();
		    $this->DIModule = new DependencyInjector();
	    }

        /**
         * Make bridge between the app and the framework
         *
         * @return string
         */
	    public function bridge(): string
	    {
            return $this->class;
	    }
    }
?>