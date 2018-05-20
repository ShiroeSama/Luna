<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : LunaException.php
	 *   @Created_at : 16/03/2018
	 *   @Update_at : 16/03/2018
	 * --------------------------------------------------------------------------
	 */
	
	namespace Luna\Component\Exception;
	use \Exception;
    use Luna\Component\HTTP\HTTP;
    use \Throwable;

	class LunaException extends Exception
	{
		public const DEFAULT_CODE = HTTP::INTERNAL_SERVER_ERROR;
		protected const DEFAULT_MESSAGE = 'Error Processing Request';

        /**
         * LunaException constructor.
         *
         * @param string|null $message
         * @param int $code
         * @param Throwable|null $throwable
         */
        public function __construct(string $message = NULL, int $code = NULL,  Throwable $throwable = NULL)
        {
        	if (is_null($code)) {
        		$code = static::DEFAULT_CODE;
	        }
        	
            if(is_null($message)) {
                $message = static::DEFAULT_MESSAGE;
            }

            parent::__construct($message, $code, $throwable);
        }

        public function __toString() { return __CLASS__ . ": [{$this->code}]: {$this->message}\n"; }
	}
?>