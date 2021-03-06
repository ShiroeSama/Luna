<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : SessionBag.php
     *   @Created_at : 12/05/2018
     *   @Update_at : 25/05/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Component\Bag;

    class SessionBag extends RefParameterBag
    {
	    /**
	     * SessionBag constructor.
	     */
	    public function __construct()
	    {
	        parent::__construct($_SESSION);
	    }
    }
?>
