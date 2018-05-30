<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : Session.php
	 *   @Created_at : 27/05/2018
	 *   @Update_at : 27/05/2018
	 * --------------------------------------------------------------------------
	 */
	
	namespace Luna\Component\Session;
	
	use Luna\Component\Bag\ParameterBag;
	use Luna\Component\Bag\SessionBag;
	
	class Session implements SessionInterface
	{
		/** @var SessionBag */
		protected $bag;
		
		/**
		 * Session constructor.
		 */
		public function __construct()
		{
			$this->bag = new SessionBag();
		}
		
		/**
		 * Initialize the Session
		 */
		public function init()
		{
			if($this->bag->isEmpty()) {
				session_start();
			}
		}
		
		/**
		 *	Clear current session
		 */
		public function destroy()
		{
			session_destroy();
			$this->bag->replace([]);
		}
		
		
		
		
		/* ------------------------ Check ------------------------ */
		
		/**
		 *	Check is the session contains the authentication params
		 *
		 *	@return bool
		 */
		public function isAuth(): bool
		{
			return $this->bag->has(SessionInterface::AUTH);
		}
		
		
		
		
		/* ------------------------ Authentication Methods ------------------------ */
		
		/**
		 *	Initialize the Authentication Session
		 *
		 *	@param array $authenticationParams
		 */
		public function authInit(array $authenticationParams = [])
		{
			$this->init();
			$this->bag->set(SessionInterface::AUTH, $authenticationParams);
		}
		
		/**
		 *	Clear current authentication session
		 */
		public function authDestroy()
		{
			$this->bag->remove(SessionInterface::AUTH);
		}
		
		/**
		 * Get value in the Authentication Session Bag
		 *
		 * @param string $key
		 * @return string|null
		 */
		public function authGetValue(string $key) : ?string
		{
			if ($this->isAuth()) {
				$authBag = new ParameterBag($this->bag->get(SessionInterface::AUTH));
				return $authBag->get($key);
			}
			
			return NULL;
		}
	}
?>
