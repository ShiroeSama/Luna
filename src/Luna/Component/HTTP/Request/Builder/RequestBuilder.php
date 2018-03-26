<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : RequestBuilder.php
     *   @Created_at : 26/03/2018
     *   @Update_at : 26/03/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Component\HTTP\Request;

    class RequestBuilder
    {
        /** @var string */
        protected $rule;

        /** @var string */
        protected $ruleName;

        /** @var string */
        protected $userRequest;

        /**
         * @param string $rule
         * @return RequestBuilder
         */
        public function setRule(string $rule): RequestBuilder
        {
            $this->rule = $rule;
            return $this;
        }

        /**
         * @param string $ruleName
         * @return RequestBuilder
         */
        public function setRuleName(string $ruleName): RequestBuilder
        {
            $this->ruleName = $ruleName;
            return $this;
        }

        /**
         * @param string $userRequest
         * @return RequestBuilder
         */
        public function setUserRequest(string $userRequest): RequestBuilder
        {
            $this->userRequest = $userRequest;
            return $this;
        }

        public function getRequest(): Request
        {
            $request = new Request();
            $request->init();

            return $request;
        }
    }
?>