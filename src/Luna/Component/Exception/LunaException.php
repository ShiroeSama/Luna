<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : LunaException.php
	 *   @Created_at : 16/03/2018
	 *   @Update_at : 16/03/2018
	 * --------------------------------------------------------------------------
	 */
	
	namespace Luna\Component\Exception;
	use \Exception;
	
	class LunaException extends Exception
	{
		public function __toString() { return __CLASS__ . ": [{$this->code}]: {$this->message}\n"; }
	}
?>