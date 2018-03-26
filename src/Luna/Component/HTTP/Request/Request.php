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

    class Request
    {
        public const GET = 'GET';
        public const POST = 'POST';

        /** @var array */
        protected $server;

        /** @var array */
        protected $get;

        /** @var array */
        protected $post;

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
            # Set Default value for server, get & post var.
            $this->server = [];
            $this->get = [];
            $this->post = [];


            $this->rule = $rule;
            $this->ruleName = $ruleName;
            $this->userRequest = $userRequest;
        }

        public function init()
        {
            if (isset($_SERVER)) { $this->server =& $_SERVER; }
            if (isset($_GET)) { $this->get =& $_GET; }
            if (isset($_POST)) { $this->post =& $_POST; }
        }



        /* ------------------------ Getter ------------------------ */

            // TODO : Create getter for Server Var

            public function getGetRequest(): array { return $this->get; }
            public function getPostRequest(): array { return $this->post; }

            public function getRule(): string { return $this->rule; }
            public function getRuleName(): string { return $this->ruleName; }
            public function getUserRequest(): string { return $this->userRequest; }
            public function getMethod(): ?string { return (isset($this->server['REQUEST_METHOD']) ? $this->server['REQUEST_METHOD'] : NULL); }



        /* ------------------------ Request Process ------------------------ */

            protected function requestProcess(string $httpMethod, array $params): bool
            {
                switch ($httpMethod) {
                    case self::GET:
                        $varName = 'get';
                        $method = self::GET;
                        break;

                    case self::POST:
                        $varName = 'post';
                        $method = self::POST;
                        break;

                    default:
                        return false;
                }


                if (!empty($this->$varName) && ($this->getMethod() === $method)) {
                    foreach ($params as $param) {
                        if (!isset($this->$varName[$param])) {
                            return false;
                            break;
                        }
                    }
                } else {
                    return false;
                }

                return true;
            }

            public function isGetRequest(string ...$params): bool
            {
                return $this->requestProcess(self::GET, $params);
            }

            public function isPostRequest(string ...$params): bool
            {
                return $this->requestProcess(self::POST, $params);
            }
    }
?>