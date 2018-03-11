<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : Validation.php
	 *   @Created_at : 24/11/2016
	 *   @Update_at : 03/12/2017
	 * --------------------------------------------------------------------------
	 */

	namespace Luna\Utils\Validation;
	use Luna\Config;
	use Luna\Utils\Exception\ValidationException;
	use Luna\Utils\Url\Url;
	use Luna\Utils\Validation\Sanitize\Sanitize;
	use Luna\Utils\Validation\Type\PhoneType;
	use Luna\Utils\Validation\Type\StringType;
	use Luna\Utils\Validation\Type\UrlType;
	
	/**
	* Controller des Validation de Champs
	*/

	class Validation
	{
		/** PARAMETERS */
		
		public const PARAM_MESSAGE = ValidationBuilder::PARAM_MESSAGE;
		public const PARAM_REQUIRED = ValidationBuilder::PARAM_REQUIRED;
		
		public const PARAM_SANITIZE = ValidationBuilder::PARAM_SANITIZE;
		public const PARAM_SANITIZE_TYPE = ValidationBuilder::PARAM_SANITIZE_TYPE;
		public const PARAM_SANITIZE_METHOD = ValidationBuilder::PARAM_SANITIZE_METHOD;
		public const PARAM_SANITIZE_EQUAL_TO = ValidationBuilder::PARAM_SANITIZE_EQUAL_TO;
		public const PARAM_SANITIZE_PROHIBITED_CHARACTERS = ValidationBuilder::PARAM_SANITIZE_PROHIBITED_CHARACTERS;
		
		
		/** DEFAULT ERROR MESSAGE */
		
		protected const ERROR_MESSAGE_EMPTY = "Le champ doit être renseigné";
		protected const ERROR_MESSAGE_TYPE = "Le champ ne correspond pas au type voulu";
		protected const ERROR_MESSAGE_EQUAL_TO = "Le champ ne correspond pas avec les valeurs attendues";
		
		
		/** ATTRIBUTES */
		
		/**
		 * Classe de Validation
		 * @var ValidationBuilder
		 */
		protected $BuilderModule;
		
		/**
		 * Instance de la Classe de gestion des Configs
		 * @var Config
		 */
		protected $ConfigModule;
		
        /**
         * @var array
         */
        protected $errors;

        /**
         * @var array
         */
        protected $values;
		
		/**
		 * Liste des types sur lesquels appliquer la fonction 'trim()'
		 * @var array
		 */
		protected $typeToTrim = [
			StringType::class,
			UrlType::class,
			PhoneType::class
		];
		
		/**
		 * @var array
		 */
		protected $rawValues;
		
		/**
		 * @var bool
		 */
		protected $valid;
		
		/**
		 * Validation constructor.
		 */
		public function __construct()
		{
			$this->BuilderModule = new ValidationBuilder();
			$this->ConfigModule = Config::getInstance();

            $this->errors = array();
            $this->values = array();
			$this->rawValues = array();
			
			$this->valid = true;
			$this->buildValidation($this->BuilderModule);
		}

        /**
         * Form Builder Function
         * Allow to add differents check for the fields
         *
         * @param ValidationBuilder $builder
         */
        protected function buildValidation(ValidationBuilder $builder)
        {
            //TODO : Redefine in the subclass, if you want to add your check
        }
		
		
		/* ------------------------ Getter Errors / Values ------------------------ */
		
			/**
			 * Return Errors
			 *
			 * @return array
			 */
			public function getErrors(): array { return $this->errors; }
		
			/**
			 * Return Sanitize Values
			 *
			 * @return array
			 */
			public function getValues(): array { return $this->values; }
		
			/**
			 * Return Raw Values
			 *
			 * @return array
			 */
			public function getRawValues(): array { return $this->rawValues; }
		
			/**
			 * Return Sanitize Values
			 *
			 * @return bool
			 */
			public function isValid(): bool { return $this->valid; }


		/* ------------------------ Fonctions des Tests de Champs ------------------------ */
		
			/**
			 * @param array $fields
			 * @throws ValidationException
			 */
			public function validateForm(array $fields)
            {
                if (!empty($fields)) {
                	$checkList = $this->BuilderModule->getCheckList();
                    foreach ($fields as $key => $value) {
                    	// Get information about the field
	                    $type = $this->BuilderModule->getType($key);
	                    $message = $this->BuilderModule->getMessage($key);
	                    $equalTo = $this->BuilderModule->getEqualTo($key);
	                    $required = $this->BuilderModule->getRequired($key);
                        $sanitizeType = $this->BuilderModule->getSanitizeType($key);
	                    $sanitizeMethod = $this->BuilderModule->getSanitizeMethod($key);
	                    $prohibitedCharacters = $this->BuilderModule->getProhibitedCharacters($key);
	                    
	                    // Test if the field is required
	                    if ($required) {
		                    if ($this->isEmpty($value)) {
			                    $this->errors[$key] = self::ERROR_MESSAGE_EMPTY;
			                    $this->valid = false;
		                    }
	                    } else {
		                    $this->values[$key] = (empty($this->values[$key]) ?  '' : $this->values[$key]);
		                    unset($checkList[$key]);
	                    }
	
                        // Check the value of the field
	                    if ($equalTo) {
	                        if ($this->isNotEqual($value, $equalTo)) {
		                        $this->errors[$key] = self::ERROR_MESSAGE_EQUAL_TO;
		                        $this->valid = false;
	                        }
	                    }
	
	                    // Remove start and end space
	                    if (in_array(get_class($type), $this->typeToTrim, true)) {
	                    	$value = trim($value);
	                    }
	                    
	                    // Check the type
	                    if (!$type->validate($value)) {
		                    $this->errors[$key] = ((!empty($message)) ? $message : self::ERROR_MESSAGE_TYPE);
		                    $this->valid = false;
	                    }

                        $this->rawValues[$key] = $value;
	                    
	                    // Sanitize
	                    $SanitizeModule = new Sanitize();
	                    $SanitizeModule->setSanitizeType($sanitizeType);
	                    $SanitizeModule->setSanitizeMethod($sanitizeMethod);
	                    $SanitizeModule->setProhibitedCharacters($prohibitedCharacters);
	                    
	                    $this->values[$key] = $SanitizeModule->sanitize($value);
                    }
		
	                /* $diff = array_diff_key($checkList, $fields);

                    foreach ($diff as $key => $value) {
	                    $required = $this->BuilderModule->getRequired($key);
	                    if ($required) {
		                    $this->errors[$key] = self::ERROR_MESSAGE_EMPTY;
		                    $this->valid = false;
	                    }
                    } */
                } else {
                	throw new ValidationException();
                }
            }

			/**
			 * Verifie si un champ n'est pas vide
			 *
			 * @param $field
			 *
			 * @return bool
			 */
			protected function isEmpty($field): bool
			{
				/* -- Cas où le champs ne récupére qu'un nombre entre 0 et * | Evite de retourer FALSE en cas de saisie de 0 dans ce champs -- */
					if ($field === '0')
						return false;

				return empty($field);
			}
		
			/**
			 * Verifie si un champ n'est pas vide
			 *
			 * @param string $field
			 *
			 * @return bool
			 */
			protected function isNotEqual(string $field, array $equalTo): bool
			{
				return !in_array($field, $equalTo, true);
			}
	}
?>