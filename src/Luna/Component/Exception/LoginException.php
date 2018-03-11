<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : LoginException.php
	 *   @Created_at : 03/12/2017
	 *   @Update_at : 03/12/2017
	 * --------------------------------------------------------------------------
	 */
	
	namespace Luna\Utils\Exception;
	use \Exception;
	use Luna\Utils\HTTP\HTTP;

	/**
	* Classe représentant un exception lors de l'authentification par token
	* Herite de Exception
	*/

	class LoginException extends ShirOSException
	{
		/**
		 * Constante d'erreur en cas d'échec de connexion
		 * @var int
		 */
		public const AUTHENTIFICATION_FAILED_ERROR_CODE = HTTP::UNAUTHORIZED;

		/**
		 * Constante d'erreur en cas d'échec de connexion par token
		 * @var int
		 */
		public const AUTHENTIFICATION_TOKEN_FAILED_ERROR_CODE = HTTP::UNAUTHORIZED_TOKEN;


		/**
		 * LoginException constructor.
		 *
		 * @param int $code | Default Value = AUTHENTIFICATION_FAILED_ERROR_CODE
		 * @param string $message | Default Value = NULL
		 * @param Exception $previous | Default Value = NULL
		 */
		public function __construct(int $code = self::AUTHENTIFICATION_FAILED_ERROR_CODE, string $message = NULL, Exception $previous = NULL)
		{
			if (is_null($message)) {
				switch ($code) {
					case self::AUTHENTIFICATION_FAILED_ERROR_CODE:
						$message = "Error Processing Request, Authentification Failed";
						break;

					case self::AUTHENTIFICATION_TOKEN_FAILED_ERROR_CODE:
						$message = "Error Processing Request, Authentification with Token Failed";
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