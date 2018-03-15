<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : BridgeTrait.php
     *   @Created_at : 15/03/2018
     *   @Update_at : 15/03/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Bridge;

    trait BridgeTrait
    {
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