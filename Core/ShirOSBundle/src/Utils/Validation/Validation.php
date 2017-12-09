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

	namespace ShirOSBundle\Utils\Validation;
	use ShirOSBundle\Utils\Exception\ValidationException;
	use ShirOSBundle\Utils\Validation\Sanitize\Sanitize;
	
	/**
	* Controller des Validation de Champs
	*/

	class Validation
	{
		/**
		 * Classe de Validation
		 * @var ValidationBuilder
		 */
		protected $BuilderModule;
		
        /**
         * @var array
         */
        protected $errors;

        /**
         * @var array
         */
        protected $values;
		
		/**
		 * @var array
		 */
		protected $rawValues;
		
		/**
		 * @var bool
		 */
		protected $valid;
		
		/**
		 * @var string
		 */
		protected $emptyMessage = "Le champ doit être renseigné";
		
		/**
		 * Validation constructor.
		 */
		public function __construct()
		{
			$this->BuilderModule = new ValidationBuilder();

            $this->errors = array();
            $this->values = array();
			$this->rawValues = array();
			
			$this->valid = true;
			$this->buildForm($this->BuilderModule);
		}

        /**
         * Form Builder Function
         * Allow to add differents check for the fields
         *
         * @param ValidationBuilder $builder
         */
        protected function buildForm(ValidationBuilder &$builder)
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
                    foreach ($fields as $key => $value) {

                        if (!$this->validateField($value)) {
                            $this->errors[$key] = $this->emptyMessage;
                            $this->valid = false;
                        }
	
	                    $type = $this->BuilderModule->getType($key);
	                    $message = $this->BuilderModule->getMessage($key);
                        $sanitizeType = $this->BuilderModule->getSanitizeType($key);
	                    $sanitizeMethod = $this->BuilderModule->getSanitizeMethod($key);
	
	                    if (!$type->validate($value)) {
		                    $this->errors[$key] = $message;
		                    $this->valid = false;
	                    }
	                    
	                    $this->rawValues[$key] = $value;
		
	                    $SanitizeModule = new Sanitize($sanitizeMethod, $sanitizeType);
	                    $this->values[$key] = $SanitizeModule->sanitize($value);
                    }
                } else {
                	throw new ValidationException();
                }
            }

			/**
			 * Verifie si un champ n'est pas vide
			 *
			 * @param string $field
			 *
			 * @return bool
			 */
			protected function validateField(string $field): bool
			{
				/* -- Cas où le champs ne récupére qu'un nombre entre 0 et * | Evite de retourer FALSE en cas de saisie de 0 dans ce champs -- */
					if ($field == "0")
						return true;

				return !empty($field);
			}
	}
?>