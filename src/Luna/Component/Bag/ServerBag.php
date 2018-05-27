<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : ServerBag.php
     *   @Created_at : 19/04/2018
     *   @Update_at : 25/05/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Component\Bag;

    class ServerBag extends ParameterBag
    {
        public const RULE = 'rule';
        public const RULE_NAME = 'rule_name';
        public const PATH_INFO = 'path_info';

        /**
         * Get the rule according to the request
         *
         * @return null|string
         */
        public function getRule(): ?string { return $this->get(self::RULE, NULL); }

        /**
         * Get the name of the rule
         *
         * @return null|string
         */
        public function getRuleName(): ?string { return $this->get(self::RULE_NAME, NULL); }

        /**
         * Get the path info (User Request Url)
         *
         * @return null|string
         */
        public function getPathInfo(): ?string { return $this->get(self::PATH_INFO, NULL); }
    }
?>
