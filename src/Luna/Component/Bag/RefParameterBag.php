<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : ParameterBag.php
     *   @Created_at : 25/05/2018
     *   @Update_at : 25/05/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Component\Bag;
	
	class RefParameterBag extends Bag
    {
        /**
         * @param array $parameters
         */
        public function __construct(array &$parameters = [])
        {
	        parent::__construct();
            $this->parameters =& $parameters;
        }
    }
?>
