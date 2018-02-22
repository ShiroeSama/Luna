<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : Sanitize.php
	 *   @Created_at : 08/12/2017
	 *   @Update_at : 08/12/2017
	 * --------------------------------------------------------------------------
	 */
	
	namespace ShirOSBundle\Utils\Validation\Sanitize;
	
	/**
	 * Controller des Validation de Champs
	 */
	
	class Sanitize
	{
		/** SANITIZE CODE */
		
		public const SANITIZE = 0;
		public const SANITIZE_SEARCH = 1;
		public const SANITIZE_COMMENTS = 2;
		public const SANITIZE_CHARACTER = 3;
		
		/** PARAMETERS */
		
		public const PARAM_SANITIZE_TYPE = 'SanitizeType';
		public const PARAM_SANITIZE_METHOD = 'SanitizeMethod';
		public const PARAM_PROHIBITED_CHARACTERS = 'ProhibitedCharacters';
		
		/** ATTRIBUTES */
		
		/**
		 * @var string $sanitizeMethod
		 */
		protected $sanitizeMethod;
		
		/**
		 * @var bool $sanitize
		 */
		protected $sanitizeCode;
		
		/**
		 * @var string $type
		 */
		protected $type;
		
		/**
		 * Liste des Caratères Interdit
		 * @var array $prohibitedCharacter
		 */
		protected $prohibitedCharacters;
		
		/**
		 * Sanitize constructor.
		 */
		public function __construct(array $options = [])
		{
			$this->type = $this->optionSanitizeType($options);
			$this->sanitizeCode = $this->optionSanitizeMethod($options);
			$this->prohibitedCharacters = $this->optionProhibitedCharacters($options);
			
			switch ($this->sanitizeCode) {
				case self::SANITIZE :
					$this->sanitizeMethod = 'sanitizeField';
					break;
					
				case self::SANITIZE_SEARCH :
					$this->sanitizeMethod = 'sanitizeSearch';
					break;
					
				case self::SANITIZE_COMMENTS :
					$this->sanitizeMethod = 'sanitizeComments';
					break;
				
				case self::SANITIZE_CHARACTER :
					$this->sanitizeMethod = 'sanitizeCharacter';
					break;
					
				default:
					$this->sanitizeMethod = 'sanitizeField';
					break;
			}
		}
		
		
		/* ------------------------ Get Option Parameters ------------------------ */
		
			/**
			 * Permet de récupèrer le type du sanitize pour le champ
			 *
			 * @param array $options
			 *
			 * @return string
			 */
			protected function optionSanitizeType(array $options): string
			{
				return (isset($options[self::PARAM_SANITIZE_TYPE]) ? $options[self::PARAM_SANITIZE_TYPE] : FILTER_SANITIZE_STRING);
			}
			
			/**
			 * Permet de récupèrer lea méthode de sanitize pour le champ
			 *
			 * @param array $options
			 *
			 * @return string
			 */
			protected function optionSanitizeMethod(array $options): string
			{
				return (isset($options[self::PARAM_SANITIZE_METHOD]) ? $options[self::PARAM_SANITIZE_METHOD] : Sanitize::SANITIZE);
			}
			
			/**
			 * Permet de récupèrer lea méthode de sanitize pour le champ
			 *
			 * @param array $options
			 *
			 * @return array
			 */
			protected function optionProhibitedCharacters(array $options): array
			{
				return (isset($options[self::PARAM_PROHIBITED_CHARACTERS]) ? $options[self::PARAM_PROHIBITED_CHARACTERS] : []);
			}
		
		
		/* ------------------------ Fonctions de Sanitize des Champs ------------------------ */
		
		/**
		 * Nettoie la chaine de caratère
		 *
		 * @param $field
		 *
		 * @return mixed
		 */
		public function sanitize($field)
		{
			$sanitizeMethod = $this->sanitizeMethod;
			
			if (is_array($field)) {
				foreach ($field as $key => $value) {
					$field[$key] = $this->$sanitizeMethod($value);
				}
			} else {
				$field = $this->$sanitizeMethod($field);
			}
			
			return $field;
		}
		
		/* ------------------------ Private Function ------------------------ */
		
		/**
		 * Nettoie les Champs de Formulaires
		 *
		 * @param string $field
		 *
		 * @return string
		 */
		protected function sanitizeField(string $field): string { return filter_var($field, $this->type); }
		
		/**
		 * Nettoie le Champ de Recherche
		 *
		 * @param string $field
		 *
		 * @return string
		 */
		protected function sanitizeSearch(string $field): string
		{
			$this->type = FILTER_SANITIZE_FULL_SPECIAL_CHARS;
			return $this->sanitizeField($field);
		}
		
		/**
		 * Nettoie les Champs de Commentaires
		 *
		 * @param string $field
		 *
		 * @return string
		 */
		protected function sanitizeComments(string $field): string
		{
			/* -- Suppression des Balises Js -- */
			$field = preg_replace('@<script[^>]*?>.*?</script>@si', '', $field);
			
			
			/* -- Suppression des Balises Css -- */
			$field = preg_replace('@<link [^>]*?>@si', '', $field);
			$field = preg_replace('@<style[^>]*?>.*?</style>@si', '', $field);
			
			/* -- Nettoyage des Signatures -- */
			$field = preg_replace('@<p class="signature">.*?</p>@si', '', $field);
			
			return $field;
		}
		
		/**
		 * Nettoie le Champ en suppriment ou en remplaçant les caractères voulue.
		 *
		 * @param string $field
		 *
		 * @return string
		 */
		protected function sanitizeCharacter(string $field): string
		{
			foreach ($this->prohibitedCharacters as $character) {
				switch ($character) {
					case '/':
						$field = str_replace($character, ':', $field);
						break;
						
					case '.':
						$field = str_replace($character, '', $field);
						break;
						
					default:
						$field = str_replace($character, '-', $field);
						break;
				}
			}
			
			return $this->sanitizeField($field);
		}
	}
	?>