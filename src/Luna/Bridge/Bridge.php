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
	    	// TODO : Throw Bridge Exception (This method can be overide in subclass)
	    }
	
	    /**
	     * Allow to take some information about a bridge
	     * Like method to class for an Handler
	     *
	     * @param string $key
	     * @return null
	     */
	    public function getParameters(string $key)
	    {
		    if (property_exists($this, $key)) {
			    return $this->$key;
		    }
		    return NULL;
	    }
    }
?>