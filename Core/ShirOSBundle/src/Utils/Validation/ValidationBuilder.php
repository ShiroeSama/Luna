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

        /* ------------------------ Add Check ------------------------ */

            public function add(Type $type, string $varName, string $message = '', string $sanitizeMethod = Sanitize::SANITIZE, string $sanitizeType = FILTER_SANITIZE_STRING): ValidationBuilder
            {
	            $this->checkList[$varName] = [
            	    self::PARAM_TYPE => $type,
            	    self::PARAM_MESSAGE => $message,
		            self::PARAM_SANITIZE_TYPE => $sanitizeType,
		            self::PARAM_SANITIZE_METHOD => $sanitizeMethod
	            ];
            	
            	return $this;
            }



        /* ------------------------ Checks Getter ------------------------ */
	
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
    }
?>