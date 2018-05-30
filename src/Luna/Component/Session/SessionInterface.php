<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : SessionInterface.php
	 *   @Created_at : 27/05/2018
	 *   @Update_at : 27/05/2018
	 * --------------------------------------------------------------------------
	 */
	
	namespace Luna\Component\Session;
	
	interface SessionInterface
	{
		public const AUTH = 'Authentication';
		
		/**
		 * Initialize the Session
		 */
		public function init();
		
		/**
		 *	Clear current session
		 */
		public function destroy();
		
		
		
		
		/* ------------------------ Check ------------------------ */
		
		/**
		 *	Check is the session contains the authentication params
		 *
		 *	@return bool
		 */
		public function isAuth(): bool;
		
		
		
		
		/* ------------------------ Authentication Methods ------------------------ */
		
		/**
		 *	Initialize the Authentication Session
		 *
		 *	@param array $authenticationParams
		 */
		public function authInit(array $authenticationParams = []);
		
		/**
		 *	Clear current authentication session
		 */
		public function authDestroy();
		
		/**
		 * Get value in the Authentication Session Bag
		 *
		 * @param string $key
		 * @return string|null
		 */
		public function authGetValue(string $key) : ?string;
	}
?>
