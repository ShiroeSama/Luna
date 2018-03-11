<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : ShirOSException.php
	 *   @Created_at : 03/12/2017
	 *   @Update_at : 03/12/2017
	 * --------------------------------------------------------------------------
	 */
	
	namespace Luna\Utils\Exception;
	use \Exception;
	
	/**
	 * Classe pére des Exceptions du Bundle
	 * Herite de Exception
	 */
	
	class ShirOSException extends Exception
	{
		/**
		 * Gère l'affichage de l'exception
		 */
		public function __toString() { return __CLASS__ . ": [{$this->code}]: {$this->message}\n"; }
	}
	?>