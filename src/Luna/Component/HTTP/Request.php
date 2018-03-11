<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : Request.php
     *   @Created_at : 06/12/2017
     *   @Update_at : 06/12/2017
     * --------------------------------------------------------------------------
     */

    namespace Luna\Utils\HTTP;

    class Request
    {
    	public const POST = 'POST';
	    public const GET = 'GET';
    	
        /** @var array $server */
        protected $server = [];

        /** @var array $get */
        protected $get = [];

        /** @var array $post */
        protected $post = [];
	
	    /** @var string $rule */
	    protected $rule = '';
	
	    /** @var string $ruleName */
	    protected $ruleName = '';
	
	    /** @var string $rule */
	    protected $requestUrl = '';

        public function __construct() { $this->init(); }
	    
        
        /**
         * Charge les Variables Globals de PHP
         */
        public function init()
        {
        	if (isset($_SERVER)) { $this->server =& $_SERVER; }
	        if (isset($_GET)) { $this->get =& $_GET; }
	        if (isset($_POST)) { $this->post =& $_POST; }
        }
	
	
	    /* ------------------------ Getter / Setter ------------------------ */
			
	        public function setRule(string $rule) { $this->rule = $rule; }
	        public function setRuleName(string $ruleName) { $this->ruleName = $ruleName; }
	        public function setRequestUrl(string $requestUrl) { $this->requestUrl = $requestUrl; }
	    
		    public function getGetRequest(): array { return $this->get; }
		    public function getPostRequest(): array { return $this->post; }
		
		    //TODO : Create Access Method to Server Var.
	
            public function getRule(): string { return $this->rule; }
	        public function getRuleName(): string { return $this->ruleName; }
	        public function getRequestUrl(): string { return $this->requestUrl; }
		    public function getMethod(): ?string { return (isset($this->server['REQUEST_METHOD']) ? $this->server['REQUEST_METHOD'] : NULL); }
	
	
	    /* ------------------------ Gestion des Requêtes ------------------------ */

	        public function isGetRequest(string ...$params): bool
	        {
	            $bool = true;
	            
	            if (!empty($this->get) && ($this->getMethod() === self::GET)) {
			        foreach ($params as $param) {
						if (!isset($this->get[$param])) {
							$bool = false;
							break;
						}
			        }
		        } else {
	                $bool = false;
		        }
	            
	            return $bool;
	        }
	        
	        public function isPostRequest(string ...$params): bool
	        {
		        $bool = true;
		
		        if (!empty($this->post) && ($this->getMethod() === self::POST)) {
			        foreach ($params as $param) {
				        if (!isset($this->get[$param])) {
					        $bool = false;
					        break;
				        }
			        }
		        } else {
			        $bool = false;
		        }
		
		        return $bool;
	        }
    }
?>