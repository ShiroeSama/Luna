<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : ValidationBuilder.php
     *   @Created_at : 07/12/2017
     *   @Update_at : 07/12/2017
     * --------------------------------------------------------------------------
     */

    namespace ShirOSBundle\Utils\Validation;
    
    use ShirOSBundle\Utils\Validation\Type\Type;
    use ShirOSBundle\Utils\Exception\ValidationException;
    use ShirOSBundle\Utils\Validation\Sanitize\Sanitize;

    /**
     * Controller des Validation de Champs
     */

    class ValidationBuilder
    {
    	public const PARAM_TYPE = 'Type';
	    public const PARAM_MESSAGE = 'Message';
	    public const PARAM_REQUIRED = 'Required';
	    
	    public const PARAM_SANITIZE = 'Sanitize';
	    public const PARAM_SANITIZE_TYPE = 'SanitizeType';
	    public const PARAM_SANITIZE_METHOD = 'SanitizeMethod';
    	
        /**
         * @var array
         */
        protected $checkList;

        /**
         * Validation constructor.
         */
        public function __construct()
        {
            $this->checkList = array();
        }
	
	    /* ------------------------ Private Function ------------------------ */
	
		    protected function optionMessage(array $options): string
		    {
			    return (isset($options[self::PARAM_MESSAGE]) ? $options[self::PARAM_MESSAGE] : '');
		    }
	
		    protected function optionRequired(array $options): bool
		    {
		    	if (isset($options[self::PARAM_REQUIRED])) {
		    		if (is_bool($options[self::PARAM_REQUIRED])){
		    			return $options[self::PARAM_REQUIRED];
				    }
			    }
			    
			    return true;
		    }
	    
	        protected function optionSanitizeType(array $options): string
	        {
		        return (isset($options[self::PARAM_SANITIZE][self::PARAM_SANITIZE_TYPE]) ? $options[self::PARAM_SANITIZE][self::PARAM_SANITIZE_TYPE] : FILTER_SANITIZE_STRING);
	        }
	
		    protected function optionSanitizeMethod(array $options): string
		    {
			    return (isset($options[self::PARAM_SANITIZE][self::PARAM_SANITIZE_METHOD]) ? $options[self::PARAM_SANITIZE][self::PARAM_SANITIZE_METHOD] : Sanitize::SANITIZE);
		    }
	    

        /* ------------------------ Add Check ------------------------ */

            public function add(Type $type, string $varName, array $options = []): ValidationBuilder
            {
            	$this->checkList[$varName] = [
            	    self::PARAM_TYPE => $type,
            	    self::PARAM_MESSAGE => $this->optionMessage($options),
		            self::PARAM_SANITIZE_TYPE => $this->optionSanitizeType($options),
		            self::PARAM_SANITIZE_METHOD => $this->optionSanitizeMethod($options),
		            self::PARAM_REQUIRED => $this->optionRequired($options)
	            ];
            	
            	return $this;
            }



        /* ------------------------ Checks Getter ------------------------ */
	
		    /**
		     * Return Check List
		     *
		     * @return array
		     */
		    public function getCheckList(): array { return $this->checkList; }
	
		    /**
		     * Return Type
		     *
		     * @param string $key
		     * @return null|Type
		     * @throws ValidationException
		     */
		    public function getType(string $key): ?Type
		    {
			    if (isset($this->checkList[$key])) {
				    return $this->checkList[$key][self::PARAM_TYPE];
			    } else {
				    throw new ValidationException(ValidationException::VALIDATION_UNEXIST_FIELD_CHECK_ERROR_CODE);
			    }
		    }
	
		    /**
		     * Return Error Message
		     *
		     * @param $key
		     * @return null|string
		     * @throws ValidationException
		     */
		    public function getMessage(string $key): ?string
		    {
			    if (isset($this->checkList[$key])) {
				    return $this->checkList[$key][self::PARAM_MESSAGE];
			    } else {
				    throw new ValidationException(ValidationException::VALIDATION_UNEXIST_FIELD_CHECK_ERROR_CODE);
			    }
		    }
	
		    /**
		     * Return Required
		     *
		     * @param string $key
		     * @return null|bool
		     * @throws ValidationException
		     */
		    public function getRequired(string $key): ?bool
		    {
			    if (isset($this->checkList[$key])) {
				    return $this->checkList[$key][self::PARAM_REQUIRED];
			    } else {
				    throw new ValidationException(ValidationException::VALIDATION_UNEXIST_FIELD_CHECK_ERROR_CODE);
			    }
		    }
	
		    /**
		     * Return Sanitize Type
		     *
		     * @param string $key
		     * @return null|string
		     * @throws ValidationException
		     */
		    public function getSanitizeType(string $key): ?string
		    {
			    if (isset($this->checkList[$key])) {
				    return $this->checkList[$key][self::PARAM_SANITIZE_TYPE];
			    } else {
				    throw new ValidationException(ValidationException::VALIDATION_UNEXIST_FIELD_CHECK_ERROR_CODE);
			    }
		    }
	
		    /**
		     * Return Sanitize Method
		     *
		     * @param string $key
		     * @return null|string
		     * @throws ValidationException
		     */
		    public function getSanitizeMethod(string $key): ?string
		    {
			    if (isset($this->checkList[$key])) {
				    return $this->checkList[$key][self::PARAM_SANITIZE_METHOD];
			    } else {
				    throw new ValidationException(ValidationException::VALIDATION_UNEXIST_FIELD_CHECK_ERROR_CODE);
			    }
		    }
    }
?>