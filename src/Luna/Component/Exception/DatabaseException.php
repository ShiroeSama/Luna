<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : DatabaseException.php
	 *   @Created_at : 03/12/2017
	 *   @Update_at : 03/12/2017
	 * --------------------------------------------------------------------------
	 */
	
	namespace Luna\Utils\Exception;
	use \Exception;
	use Luna\Utils\HTTP\HTTP;

	/**
	* Classe représentant un exception d'erreur en base de données
	* Herite de Exception
	*/

	class DatabaseException extends ShirOSException
	{
		/**
		 * Constante d'erreur pour l'appel d'une méthode avec les mauvaises permissions
		 * @var int
		 */
		public const DATABASE_METHODE_NOT_ALLOWED_ERROR_CODE = HTTP::METHOD_NOT_ALLOWED;

		/**
		 * Constante d'erreur pour l'appel d'une méthode non implémentée
		 * @var int
		 */
		public const DATABASE_NOT_IMPLEMENTED_ERROR_CODE = HTTP::NOT_IMPLEMENTED;

		/**
		 * Constante d'erreur pour l'appel d'une méthode sur une mauvaise 'Repository'
		 * @var int
		 */
		public const DATABASE_BAD_GATEWAY_ERROR_CODE = HTTP::BAD_GATEWAY;


		/**
		 * DatabaseException constructor.
		 *
		 * @param int $code | Default Value = DATABASE_METHODE_NOT_ALLOWED_ERROR_CODE
		 * @param string $message | Default Value = NULL
		 * @param Exception $previous | Default Value = NULL
		 */
		public function __construct(int $code = self::DATABASE_METHODE_NOT_ALLOWED_ERROR_CODE, string $message = NULL, Exception $previous = NULL)
		{
			if (is_null($message)) {
				switch ($code) {
					case self::DATABASE_METHODE_NOT_ALLOWED_ERROR_CODE:
						$message = "Error Processing Request, You can't call this method";
						break;

					case self::DATABASE_NOT_IMPLEMENTED_ERROR_CODE:
						$message = "Error Processing Request, This method is not implemented";
						break;

					case self::DATABASE_BAD_GATEWAY_ERROR_CODE:
						$message = "Error Processing Request, This Repository doesn't exist";
						break;
					
					default:
						$message = "Error Processing Request";
						break;
				}
			}
			parent::__construct($message, $code, $previous);
		}
	}
?>