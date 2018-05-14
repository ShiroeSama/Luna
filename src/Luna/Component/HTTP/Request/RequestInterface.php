<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : RequestInterface.php
	 *   @Created_at : 14/05/2018
	 *   @Update_at : 14/05/2018
	 * --------------------------------------------------------------------------
	 */
	
	namespace Luna\Component\HTTP\Request;
	
	use Luna\Component\Bag\FileBag;
	use Luna\Component\Bag\ParameterBag;
	use Luna\Component\Bag\ServerBag;
	
	interface RequestInterface
	{
		public const GET = 'GET';
		public const POST = 'POST';
		
		/**
		 * Get the Server Info
		 *
		 * @return ServerBag
		 */
		public function getServer(): ServerBag;
		
		/**
		 * Get the file(s) of the request
		 *
		 * @return FileBag
		 */
		public function getFileRequest(): FileBag;
		
		/**
		 * Get the cookie of the request
		 *
		 * @return ParameterBag
		 */
		public function getCookie(): ParameterBag;
		
		/**
		 * Get the query parameters
		 *
		 * @return ParameterBag
		 */
		public function getGetRequest(): ParameterBag;
		
		/**
		 * Get the request parameters
		 *
		 * @return ParameterBag
		 */
		public function getPostRequest(): ParameterBag;
		
		/**
		 * Get the url parameters
		 *
		 * @return ParameterBag
		 */
		public function getParametersRequest(): ParameterBag;
		
		/**
		 * Get the rule of the request
		 *
		 * @return string|null
		 */
		public function getRule(): ?string;
		
		/**
		 * Get the rule's name of the request
		 *
		 * @return string|null
		 */
		public function getRuleName(): ?string;
		
		/**
		 * Get the url of the request
		 *
		 * @return string|null
		 */
		public function getPathInfo(): ?string;
		
		/**
		 * Get the http method of the request
		 *
		 * @return string|null
		 */
		public function getMethod(): ?string;
		
		/**
		 * @param string[] ...$params
		 * @return bool
		 */
		public function isGetRequest(string ...$params): bool;
		
		/**
		 * @param string[] ...$params
		 * @return bool
		 */
		public function isPostRequest(string ...$params): bool;
	}
?>