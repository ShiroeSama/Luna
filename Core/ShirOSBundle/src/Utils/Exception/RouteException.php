<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : RouteException.php
	 *   @Created_at : 03/12/2017
	 *   @Update_at : 03/12/2017
	 * --------------------------------------------------------------------------
	 */
	
	namespace ShirOSBundle\Utils\Exception;
	use \Exception;
	use ShirOSBundle\Utils\HTTP\HTTP;

	/**
	* Classe représentant un exception lors d'erreur de routage
	* Herite de Exception
	*/

	class RouteException extends ShirOSException
	{
		/**
		 * Constante d'erreur en cas de route inexistante
		 * @var int
		 */
		public const ROUTE_NOTFOUND_ERROR_CODE = HTTP::NOT_FOUND;

		/**
		 * Constante d'erreur en cas de controleur inexistante
		 * @var int
		 */
		public const ROUTE_CONTROLLER_NOTFOUND_ERROR_CODE = HTTP::NOT_FOUND_CONTROLLER;

		/**
		 * Constante d'erreur en cas de permissions insuffisante pour la route demandée
		 * @var int
		 */
		public const ROUTE_FORBIDDEN_ERROR_CODE = HTTP::FORBIDDEN;

		/**
		 * Constante d'erreur en cas d'appel de méthode avec des permissions insuffisante
		 * @var int
		 */
		public const ROUTE_METHODE_NOT_ALLOWED_ERROR_CODE = HTTP::METHOD_NOT_ALLOWED;

		/**
		 * Constante d'erreur en cas de ressource indisponible
		 * @var int
		 */
		public const ROUTE_GONE_ERROR_CODE = HTTP::GONE;


		/**
		 * RouteException constructor.
		 *
		 * @param int $code | Default Value = ROUTE_NOTFOUND_ERROR_CODE
		 * @param string $message | Default Value = NULL
		 * @param Exception $previous | Default Value = NULL
		 */
		public function __construct(int $code = self::ROUTE_NOTFOUND_ERROR_CODE, string $message = NULL, Exception $previous = NULL)
		{
			if (is_null($message)) {
				switch ($code) {
					case self::ROUTE_NOTFOUND_ERROR_CODE:
						$message = "Error Processing Request, Route Not Found";
						break;

					case self::ROUTE_CONTROLLER_NOTFOUND_ERROR_CODE:
						$message = "Error Processing Request, Controller Not Found";
						break;

					case self::ROUTE_FORBIDDEN_ERROR_CODE:
						$message = "Error Processing Request, You don't have permissions to access this Route";
						break;

					case self::ROUTE_METHODE_NOT_ALLOWED_ERROR_CODE:
						$message = "Error Processing Request, You don't have permissions to call this method";
						break;

					case self::ROUTE_GONE_ERROR_CODE:
						$message = "Error Processing Request, Resource for this route doesn't exist";
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