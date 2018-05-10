<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : LunaContainer.php
	 *   @Created_at : 08/05/2018
	 *   @Update_at : 08/05/2018
	 * --------------------------------------------------------------------------
	 */
	
	namespace Luna\Component\Container;
	
	use Luna\Component\Bag\ParameterBag;
	use Luna\Component\HTTP\Request\Request;
	use Luna\Component\HTTP\Request\RequestBuilder;
	use Luna\Kernel;
	use Luna\KernelInterface;
	
	class LunaContainer
	{
		protected const KERNEL = '_kernel';
		protected const REQUEST = '_request';
		
		
		/** @var LunaContainer */
		protected static $_instance;
		
		/** @var ParameterBag */
		protected $container;
		
		/**
		 * LunaContainer constructor.
		 */
		protected function __construct()
		{
			$this->container = new ParameterBag();
		}
		
		/**
		 * Get the LunaContainer instance
		 * @return LunaContainer
		 */
		public static function getInstance(): LunaContainer
		{
			if(is_null(static::$_instance))
				static::$_instance = new static();
			
			return static::$_instance;
		}
		
		
		/* -------------------------------------------------------------------------- */
		/* KERNEL */
		
		/**
		 * @return KernelInterface
		 */
		public function getKernel(): KernelInterface
		{
			$kernel = $this->container->get(self::KERNEL);
			
			if (is_null($kernel) || is_a($kernel, KernelInterface::class) || is_subclass_of($kernel, KernelInterface::class)) {
				$kernel = new Kernel();
				$this->setKernel($kernel);
			}
			
			return $kernel;
		}
		
		/**
		 * @param KernelInterface $kernel
		 *
		 * @return self
		 */
		public function setKernel(KernelInterface $kernel): self
		{
			$this->container->set(self::KERNEL, $kernel);
			
			return $this;
		}
		
		
		/* -------------------------------------------------------------------------- */
		/* REQUEST */
		
		/**
		 * @return Request
		 */
		public function getRequest(): Request
		{
			$request = $this->container->get(self::REQUEST);
			
			if (is_null($request) || is_a($request, Request::class) || is_subclass_of($request, Request::class)) {
				$request = RequestBuilder::create();
				$this->setRequest($request);
			}
			
			return $request;
		}
		
		/**
		 * @param Request $request
		 *
		 * @return self
		 */
		public function setRequest(Request $request): self
		{
			$this->container->set(self::REQUEST, $request);
			
			return $this;
		}
	}
?>