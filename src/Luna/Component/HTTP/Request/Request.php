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

    use Luna\Component\Bag\FileBag;
    use Luna\Component\Bag\ParameterBag;
    use Luna\Component\Bag\ServerBag;

    class Request
    {
        public const GET = 'GET';
        public const POST = 'POST';

        /** @var ParameterBag */
        protected $get;

        /** @var ParameterBag */
        protected $post;

        /** @var FileBag */
        protected $files;

        /** @var ParameterBag */
        protected $cookie;

        /** @var ServerBag */
        protected $server;

        /** @var ParameterBag */
        protected $parameters;

        /**
         * Request constructor.
         *
         * @param array $get
         * @param array $post
         * @param array $files
         * @param array $cookies
         * @param array $server
         * @param array $parameters
         */
        public function __construct(array $get = [], array $post = [], array $files = [], array $cookies = [], array $server = [], array $parameters = [])
        {
            $this->get = new ParameterBag($get);
            $this->post = new ParameterBag($post);
            $this->files = new FileBag($files);
            $this->cookie = new ParameterBag($cookies);
            $this->server = new ServerBag($server);
            $this->parameters = new ParameterBag($parameters);
        }



        /* ------------------------ Getter ------------------------ */
	
            public function getServer(): ServerBag { return $this->server; }
	        public function getFileRequest(): FileBag { return $this->files; }
            public function getCookie(): ParameterBag { return $this->cookie; }
		    public function getGetRequest(): ParameterBag { return $this->get; }
		    public function getPostRequest(): ParameterBag { return $this->post; }
	        public function getParametersRequest(): ParameterBag { return $this->parameters; }

            public function getRule(): ?string { return $this->server->getRule(); }
            public function getRuleName(): ?string { return $this->server->getRuleName(); }
            public function getPathInfo(): ?string { return $this->server->getPathInfo(); }
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