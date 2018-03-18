<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : AnonymousEntity.php
	 *   @Created_at : 24/11/2016
	 *   @Update_at : 11/03/2017
	 * --------------------------------------------------------------------------
	 */
	
	namespace Luna\Entity;
	
	use Luna\Config;
	
	class AnonymousEntity
	{
		protected const METHOD_GET_PREFIXE = 'get';
		protected const METHOD_SET_PREFIXE = 'set';
		
		/** @var Config */
		protected $ConfigModule;
		
		/**
		 * AnonymousEntity constructor.
		 * @param array|null $array
		 */
		public function __construct(array $array = NULL)
		{
			$this->ConfigModule = Config::getInstance();
			
			if(!is_null($array)) {
				foreach ($array as $key => $value)
					$this->$key = $value;
			}
		}
		
		public function __get($key)
		{
			$key = lcfirst($key);
			
			$methodGetPrefixe = self::METHOD_GET_PREFIXE;
			$method = $methodGetPrefixe . ucfirst($key);
			
			if (method_exists($this, $method)) {
				$this->$key = $this->$method();
			} elseif (property_exists($this, $key)) {
				return $this->$key;
			} elseif (property_exists($this, ucfirst($key))) {
				$key = ucfirst($key);
				return $this->$key;
			} else {
				$this->$key = NULL;
			}
			
			return $this->$key;
		}
		
		public function __set($name, $value)
		{
			$methodSetPrefixe = self::METHOD_SET_PREFIXE;
			$method = $methodSetPrefixe . ucfirst($name);
			
			if (method_exists($this, $method)) {
				$this->$name($value);
			} elseif (property_exists($this, $name)) {
				$this->$name = $value;
			} elseif (property_exists($this, ucfirst($name))) {
				$name = ucfirst($name);
				$this->$name = $value;
			} else {
				$this->$name = $value;
			}
		}
	}
?>