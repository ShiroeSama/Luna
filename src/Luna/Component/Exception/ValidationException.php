<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : ValidationException.php
	 *   @Created_at : 07/12/2017
	 *   @Update_at : 07/12/2017
	 * --------------------------------------------------------------------------
	 */
	
	namespace Luna\Utils\Exception;
	use \Exception;
	use Luna\Utils\HTTP\HTTP;
	
	/**
	 * Classe représentant un exception lors d'erreur de routage
	 * Herite de Exception
	 */
	
	class ValidationException extends ShirOSException
	{
		/**
		 * Constante d'erreur en cas de liste de validation vide
		 * @var int
		 */
		public const VALIDATION_EMPTY_FIELD_LIST_ERROR_CODE = 0;
		
		/**
		 * Constante d'erreur en cas de validation inexistante d'un champ
		 * @var int
		 */
		public const VALIDATION_UNEXIST_FIELD_CHECK_ERROR_CODE = 1;
		
		
		/**
		 * RouteException constructor.
		 *
		 * @param int $code | Default Value = ROUTE_NOTFOUND_ERROR_CODE
		 * @param string $message | Default Value = NULL
		 * @param Exception $previous | Default Value = NULL
		 */
		public function __construct(int $code = self::VALIDATION_EMPTY_FIELD_LIST_ERROR_CODE, string $message = NULL, Exception $previous = NULL)
		{
			if (is_null($message)) {
				switch ($code) {
					case self::VALIDATION_EMPTY_FIELD_LIST_ERROR_CODE:
						$message = "Validation : Miss All Fields";
						break;
						
					case self::VALIDATION_UNEXIST_FIELD_CHECK_ERROR_CODE:
						$message = "Validation : Miss Field Check";
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