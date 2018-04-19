<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : Request.php
     *   @Created_at : 26/03/2018
     *   @Update_at : 26/03/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Component\HTTP\Request;

    use Luna\Component\Bag\ParameterBag;

    class Request
    {
        public const GET = 'GET';
        public const POST = 'POST';

        /** @var ParameterBag */
        protected $server;

        /** @var ParameterBag */
        protected $get;

        /** @var ParameterBag */
        protected $post;

        /** @var ParameterBag */
        protected $cookie;

        /** @var string */
        protected $rule;

        /** @var string */
        protected $ruleName;

        /** @var string */
        protected $userRequest;

        /**
         * Request constructor.
         *
         * @param string $rule
         * @param string $ruleName
         * @param string $userRequest
         */
        public function __construct(string $ruleName, string $rule, string $userRequest)
        {
            $this->rule = $rule;
            $this->ruleName = $ruleName;
            $this->userRequest = $userRequest;

            # Set Default value for server, get & post var.
            $this->initialize();
        }

        protected function initialize()
        {
            $this->server = (isset($_SERVER)) ? new ParameterBag($_SERVER) : new ParameterBag();
            $this->get = (isset($_GET)) ? new ParameterBag($_GET) : new ParameterBag();
            $this->post = (isset($_POST)) ? new ParameterBag($_POST) : new ParameterBag();
            $this->cookie = (isset($_COOKIE)) ? new ParameterBag($_COOKIE) : new ParameterBag();
        }



        /* ------------------------ Getter ------------------------ */

            public function getServer(): ParameterBag { return $this->server; }
            public function getCookie(): ParameterBag { return $this->cookie; }
            public function getGetRequest(): ParameterBag { return $this->get; }
            public function getPostRequest(): ParameterBag { return $this->post; }

            public function getRule(): string { return $this->rule; }
            public function getRuleName(): string { return $this->ruleName; }
            public function getUserRequest(): string { return $this->userRequest; }
            public function getMethod(): ?string { return $this->server->get('REQUEST_METHOD'); }



        /* ------------------------ Request Process ------------------------ */

            /**
             * @param string $httpMethod
             * @param ParameterBag $bag
             * @param ParameterBag $params
             *
             * @return bool
             */
            protected function requestProcess(string $httpMethod, ParameterBag $bag, ParameterBag $params): bool
            {
                if (!$bag->isEmpty() && ($this->getMethod() === $httpMethod)) {
                    return $bag->has($params);
                } else {
                    return false;
                }
            }

            /**
             * @param string[] ...$params
             * @return bool
             */
            public function isGetRequest(string ...$params): bool
            {
                $params = new ParameterBag($params);
                return $this->requestProcess(static::GET, $this->get, $params);
            }

            /**
             * @param string[] ...$params
             * @return bool
             */
            public function isPostRequest(string ...$params): bool
            {
                $params = new ParameterBag($params);
                return $this->requestProcess(static::POST, $this->post, $params);
            }
    }
?>