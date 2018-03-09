<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : HTTP.php
	 *   @Created_at : 24/11/2016
	 *   @Update_at : 03/12/2017
	 * --------------------------------------------------------------------------
	 */
	
	namespace ShirOSBundle\Utils\HTTP;

	class HTTP
	{
		/* ------------------------ Code ------------------------ */

			/**
			 * Requête traitée avec succès.
			 * Code HTTP
			 *
			 * @var int
			 */
			public const OK = 200;


			/**
			 * Requête traitée avec succès et création d’un document.
			 * Code HTTP
			 *
			 * @var int
			 */
			public const CREATED = 201;


			/**
			 * Requête traitée, mais sans garantie de résultat.
			 * Code HTTP
			 *
			 * @var int
			 */
			public const ACCEPTED = 202;


			/**
			 * Requête traitée avec succès mais pas d’information à renvoyer.
			 * Code HTTP
			 *
			 * @var int
			 */
			public const NO_CONTENT = 204;
		
		
			/**
			 * Une partie seulement de la ressource a été transmise.
			 * Code HTTP
			 *
			 * @var int
			 */
			public const PARTIAL_CONTENT = 206;
		
		
		/**
			 * Document déplacé de façon permanente.
			 * Code HTTP
			 *
			 * @var int
			 */
			public const MOVED_PERMANENTLY = 301;
			
			/**
			 * Une authentification est nécessaire pour accéder à la ressource.
			 * Code HTTP
			 *
			 * @var int
			 */
			public const UNAUTHORIZED = 401;
			
			/**
			 * Une authentification par token est nécessaire pour accéder à la ressource.
			 * Code HTTP
			 *
			 * @var int
			 */
			public const UNAUTHORIZED_TOKEN = 4011;
			
			/**
			 * Le serveur a compris la requête, mais refuse de l'exécuter. Contrairement à l'erreur 401, s'authentifier ne fera aucune différence. 
			 * Sur les serveurs où l'authentification est requise, cela signifie généralement que l'authentification a été acceptée mais que les droits d'accès ne permettent pas au client d'accéder à la ressource.
			 * Code HTTP
			 *
			 * @var int
			 */
			public const FORBIDDEN = 403;
			
			/**
			 * Ressource non trouvée.
			 * Code HTTP
			 *
			 * @var int
			 */
			public const NOT_FOUND = 404;

			/**
			 * Controleur non trouvée.
			 * Code HTTP
			 *
			 * @var int
			 */
			public const NOT_FOUND_CONTROLLER = 4041;

			/**
			 * Méthode de requête non autorisée.
			 * Code HTTP
			 *
			 * @var int
			 */
			public const METHOD_NOT_ALLOWED = 405;

			/**
			 * La ressource n'est plus disponible et aucune adresse de redirection n’est connue.
			 * Code HTTP
			 *
			 * @var int
			 */
			public const GONE = 410;
		
			/**
			 * Champs d’en-tête de requête « range » incorrect.
			 * Code HTTP
			 *
			 * @var int
			 */
			public const REQUESTED_RANGE_UNSATISFIABLE = 416;

			/**
			 * « Je suis une théière ». Ce code est défini dans la RFC 23245 datée du premier avril 1998, Hyper Text Coffee Pot Control Protocol.
			 * Code HTTP
			 *
			 * @var int
			 */
			public const IM_A_TEAPOT = 418;

			/**
			 * Erreur interne du serveur.
			 * Code HTTP
			 *
			 * @var int
			 */
			public const INTERNAL_SERVER_ERROR = 500;

			/**
			 * Fonctionnalité réclamée non supportée par le serveur.
			 * Code HTTP
			 *
			 * @var int
			 */
			public const NOT_IMPLEMENTED = 501;

			/**
			 * Mauvaise réponse envoyée à un serveur intermédiaire par un autre serveur.
			 * Code HTTP
			 *
			 * @var int
			 */
			public const BAD_GATEWAY = 502;

		/* ------------------------ Code Name ------------------------ */
		
			/**
			 * Retourne le code correcte
			 *
			 * @param int $code
			 *
			 * @return int
			 */
			public static function getCode(int $code): int
			{
				switch ($code) {
					case self::OK:
						return self::OK;
						break;

					case self::CREATED:
						return self::CREATED;
						break;
						
					case self::ACCEPTED:
						return self::ACCEPTED;
						break;
						
					case self::NO_CONTENT:
						return self::NO_CONTENT;
						break;
					
					case self::PARTIAL_CONTENT:
						return self::PARTIAL_CONTENT;
						break;
						
					case self::MOVED_PERMANENTLY:
						return self::MOVED_PERMANENTLY;
						break;
						
					case self::UNAUTHORIZED:
						return self::UNAUTHORIZED;
						break;
						
					case self::FORBIDDEN:
						return self::FORBIDDEN;
						break;
						
					case self::NOT_FOUND:
						return self::NOT_FOUND;
						break;
						
					case self::METHOD_NOT_ALLOWED:
						return self::METHOD_NOT_ALLOWED;
						break;
						
					case self::GONE:
						return self::GONE;
						break;
					
					case self::REQUESTED_RANGE_UNSATISFIABLE:
						return self::REQUESTED_RANGE_UNSATISFIABLE;
						break;
						
					case self::IM_A_TEAPOT:
						return self::IM_A_TEAPOT;
						break;
						
					case self::INTERNAL_SERVER_ERROR:
						return self::INTERNAL_SERVER_ERROR;
						break;
						
					case self::NOT_IMPLEMENTED:
						return self::NOT_IMPLEMENTED;
						break;
						
					case self::BAD_GATEWAY:
						return self::BAD_GATEWAY;
						break;
					
					default:
						return self::IM_A_TEAPOT;
						break;
				}
			}
		
			/**
			 * Retourne le nom du code
			 *
			 * @param int $code
			 *
			 * @return string
			 */
			public static function getName(int $code): string
			{
				switch ($code) {
					case self::OK:
						return 'OK';
						break;
					
					case self::CREATED:
						return 'Content Created';
						break;
					
					case self::ACCEPTED:
						return 'Accepted';
						break;
					
					case self::NO_CONTENT:
						return 'No Content';
						break;
					
					case self::PARTIAL_CONTENT:
						return 'No Content';
						break;
					
					case self::MOVED_PERMANENTLY:
						return 'Moved Permanently';
						break;
					
					case self::UNAUTHORIZED:
						return 'Unauthorized';
						break;
					
					case self::FORBIDDEN:
						return 'Forbidden';
						break;
					
					case self::NOT_FOUND:
						return 'Not Found';
						break;
					
					case self::METHOD_NOT_ALLOWED:
						return 'Method Not Allowed';
						break;
					
					case self::GONE:
						return 'Gone';
						break;
					
					case self::REQUESTED_RANGE_UNSATISFIABLE:
						return 'Requested range unsatisfiable';
						break;
					
					case self::IM_A_TEAPOT:
						return 'I\'m a Teapot';
						break;
					
					case self::INTERNAL_SERVER_ERROR:
						return 'Internal Server Error';
						break;
					
					case self::NOT_IMPLEMENTED:
						return 'Not Implemented';
						break;
					
					case self::BAD_GATEWAY:
						return 'Bad Gateway';
						break;
					
					default:
						return 'I\'m a Teapot';
						break;
				}
			}

		/* ------------------------ Code Header ------------------------ */
		
			/**
			 * Genère l'en-tête de requête HTTP
			 *
			 * @param int $code
			 * @param array $options
			 */
			public static function generateHeader(int $code, array $options = [])
			{
				if (!headers_sent()) {
					$header = self::getHeader($code);
					
					header($header);
					
					if (!empty($options)) {
						foreach ($options as $option) {
							header($option);
						}
					}
				}
				
				
			}
		
		
			/**
			 * Récupère l'en-tête correspondant au code
			 *
			 * @param int $code
			 *
			 * @return string
			 */
			public static function getHeader(int $code): string
			{
				switch ($code) {
					case self::OK:
						return self::getHeader_200();
						break;

					case self::CREATED:
						return self::getHeader_201();
						break;
						
					case self::ACCEPTED:
						return self::getHeader_202();
						break;
						
					case self::NO_CONTENT:
						return self::getHeader_204();
						break;
					
					case self::PARTIAL_CONTENT:
						return self::getHeader_206();
						break;
						
					case self::MOVED_PERMANENTLY:
						return self::getHeader_301();
						break;
						
					case self::UNAUTHORIZED:
						return self::getHeader_401();
						break;
						
					case self::FORBIDDEN:
						return self::getHeader_403();
						break;
						
					case self::NOT_FOUND:
						return self::getHeader_404();
						break;
						
					case self::METHOD_NOT_ALLOWED:
						return self::getHeader_405();
						break;
						
					case self::GONE:
						return self::getHeader_410();
						break;
					
					case self::REQUESTED_RANGE_UNSATISFIABLE:
						return self::getHeader_417();
						break;
						
					case self::IM_A_TEAPOT:
						return self::getHeader_418();
						break;
						
					case self::INTERNAL_SERVER_ERROR:
						return self::getHeader_500();
						break;
						
					case self::NOT_IMPLEMENTED:
						return self::getHeader_501();
						break;
						
					case self::BAD_GATEWAY:
						return self::getHeader_502();
						break;
					
					default:
						return self::getHeader_418();
						break;
				}
			}
		
		
			/**
			 * @return string
			 */
			private static function getHeader_200(): string { return 'HTTP/1.1 ' . self::OK . ' Ok'; }
			
			/**
			 * @return string
			 */
			private static function getHeader_201(): string  { return 'HTTP/1.1 ' . self::CREATED . ' Created'; }
		
			/**
			 * @return string
			 */
			private static function getHeader_202(): string  { return 'HTTP/1.1 ' . self::ACCEPTED . ' Accepted'; }
		
			/**
			 * @return string
			 */
			private static function getHeader_204(): string  { return 'HTTP/1.1 ' . self::NO_CONTENT . ' No Content'; }
		
			/**
			 * @return string
			 */
			private static function getHeader_206(): string  { return 'HTTP/1.1 ' . self::NO_CONTENT . ' Partial Content'; }
		
			/**
			 * @return string
			 */
			private static function getHeader_301(): string  { return 'HTTP/1.1 ' . self::MOVED_PERMANENTLY . ' Moved Permanently'; }
		
			/**
			 * @return string
			 */
			private static function getHeader_401(): string  { return 'HTTP/1.1 ' . self::UNAUTHORIZED . ' Unauthorized'; }
			
			/**
			 * @return string
			 */
			private static function getHeader_403(): string  { return 'HTTP/1.1 ' . self::FORBIDDEN . ' Forbidden'; }
		
			/**
			 * @return string
			 */
			private static function getHeader_404(): string  { return 'HTTP/1.1 ' . self::NOT_FOUND . ' Not Found'; }
		
			/**
			 * @return string
			 */
			private static function getHeader_405(): string  { return 'HTTP/1.1 ' . self::METHOD_NOT_ALLOWED . ' Method not Allowed'; }
		
			/**
			 * @return string
			 */
			private static function getHeader_410(): string  { return 'HTTP/1.1 ' . self::GONE . ' Gone'; }
		
			/**
			 * @return string
			 */
			private static function getHeader_417(): string  { return 'HTTP/1.1 ' . self::IM_A_TEAPOT . ' Requested range unsatisfiable'; }
		
			/**
			 * @return string
			 */
			private static function getHeader_418(): string  { return 'HTTP/1.1 ' . self::IM_A_TEAPOT . ' Im a teapot'; }
		
			/**
			 * @return string
			 */
			private static function getHeader_500(): string  { return 'HTTP/1.1 ' . self::INTERNAL_SERVER_ERROR . ' Internal Server Error'; }
		
			/**
			 * @return string
			 */
			private static function getHeader_501(): string  { return 'HTTP/1.1 ' . self::NOT_IMPLEMENTED . ' Not Implemented'; }
		
			/**
			 * @return string
			 */
			private static function getHeader_502(): string  { return 'HTTP/1.1 ' . self::BAD_GATEWAY . ' Bad Gateway'; }
	}
?>