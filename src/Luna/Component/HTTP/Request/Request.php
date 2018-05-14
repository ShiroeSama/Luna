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
     *   @Update_at : 14/05/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Component\HTTP\Request;

    use Luna\Component\Bag\FileBag;
    use Luna\Component\Bag\ParameterBag;
    use Luna\Component\Bag\ServerBag;

    class Request implements RequestInterface
    {
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
	
		    /**
		     * Get the Server Info
		     *
		     * @return ServerBag
		     */
            public function getServer(): ServerBag { return $this->server; }
	
		    /**
		     * Get the file(s) of the request
		     *
		     * @return FileBag
		     */
	        public function getFileRequest(): FileBag { return $this->files; }
		
		    /**
		     * Get the cookie of the request
		     *
		     * @return ParameterBag
		     */
            public function getCookie(): ParameterBag { return $this->cookie; }
	
		    /**
		     * Get the query parameters
		     *
		     * @return ParameterBag
		     */
		    public function getGetRequest(): ParameterBag { return $this->get; }
	
		    /**
		     * Get the request parameters
		     *
		     * @return ParameterBag
		     */
		    public function getPostRequest(): ParameterBag { return $this->post; }
	
		    /**
		     * Get the url parameters
		     *
		     * @return ParameterBag
		     */
	        public function getParametersRequest(): ParameterBag { return $this->parameters; }
		
		    /**
		     * Get the rule of the request
		     *
		     * @return string|null
		     */
            public function getRule(): ?string { return $this->server->getRule(); }
	
		    /**
		     * Get the rule's name of the request
		     *
		     * @return string|null
		     */
            public function getRuleName(): ?string { return $this->server->getRuleName(); }
	
		    /**
		     * Get the url of the request
		     *
		     * @return string|null
		     */
            public function getPathInfo(): ?string { return $this->server->getPathInfo(); }
	
		    /**
		     * Get the http method of the request
		     *
		     * @return string|null
		     */
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
	
	
	
	    /* ------------------------ Request Check ------------------------ */

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