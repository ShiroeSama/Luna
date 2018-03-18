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

    use Luna\Config;

    abstract class Bridge
    {
	    /** @var Config */
	    protected $ConfigModule;
	
	    protected $class;
	
	    /**
	     * BridgeTrait constructor.
	     */
	    public function __construct()
	    {
		    $this->ConfigModule = Config::getInstance();
		    $this->bridge();
	    }
	
	    /**
	     * Make bridge between the app and the framework
	     */
	    protected function bridge()
	    {
	    	// TODO : Throw Bridge Exception (This method can be override in subclass)
	    }
    }
?>