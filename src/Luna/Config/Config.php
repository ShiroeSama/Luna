<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : Config.php
	 *   @Created_at : 24/11/2016
	 *   @Update_at : 03/12/2017
	 * --------------------------------------------------------------------------
	 */

	namespace Luna;

	class Config
	{
		/**
		 * Contient l'instance de la classe
		 * @var Config
		 */
		protected static $_instance;


		/**
		 * Contient le chemin du fichier de config par défaut
		 * @var string
		 */
		protected static $configPath = 'Config/config.php';

		/**
		 * Contient toutes les variables de config
		 * @var array
		 */
		protected $settings = [];
		
		
		/**
		 * Config constructor, Singleton
		 *
		 * @param string $filePath
		 */
		protected function __construct(string $filePath) { $this->settings = require($filePath); }
		
		/**
		 * Retourne l'instance de la classe 'Config'
		 *
		 * @param string $filePath | Default Value = NULL
		 * @return Config
		 */
		public static function getInstance(string $filePath = NULL): Config
		{
			$re_instantiation = false;
			if(!is_null($filePath)) {
				$re_instantiation = ($filePath != static::$configPath);
				static::$configPath = $filePath;
			}
			
			if(is_null(static::$_instance) || $re_instantiation)
				static::$_instance = new static(static::$configPath);
			
			return static::$_instance;
		}
		
		/**
		 * Permet de récupèrer une variable de config
		 *
		 * @param string $key
		 * @return mixed
		 */
		public function get(string $key) { return $this->isInConfig($this->settings, $key); }

		/**
		 * Parcour Récursif des configs pour trouver la valeur souhaitée
		 *
		 * @param array $configs
		 * @param string $key
		 *
		 * @return mixed
		 */
		protected function isInConfig(array $configs, string $key)
		{
			$keyArray = explode('.', $key);
			$key = array_shift($keyArray);
			$keyString = implode('.', $keyArray);

			if(isset($configs[$key])) {
				$value = $configs[$key];

				if (is_array($value) && !empty($keyString)) {
					return $this->isInConfig($value, $keyString);
				}
				return $value;
			}

			return NULL;
		}
	}
?>