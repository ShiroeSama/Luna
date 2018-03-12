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
	    protected const ROOT_CONFIG = 'Luna';

	    protected const DEFAULT_GENERAL_CONFIG_PATH = LUNA_CONFIG_DIR . '/config.php';
        protected const DEFAULT_DATABASE_CONFIG_PATH = LUNA_CONFIG_DIR . '/database.php';

        protected const GENERAL_CONFIG_PATH = LUNA_CONFIG_DIR . '/config.php';
        protected const DATABASE_CONFIG_PATH = LUNA_CONFIG_DIR . '/database.php';


		/** @var Config */
		protected static $_instance;

		/**
		 * Default config vars
		 * @var array
		 */
		protected $defaultSettings = [];

        /**
         * Config vars
         * @var array
         */
        protected $settings = [];
		
		
		/**
		 * Config constructor (Singleton)
		 */
		protected function __construct()
        {
            # Default Config
            $this->getConfigFile(self::DEFAULT_GENERAL_CONFIG_PATH);
            $this->getConfigFile(self::DEFAULT_DATABASE_CONFIG_PATH, 'Database');

            # Config
            $this->getConfigFile(self::GENERAL_CONFIG_PATH, NULL, false);
            $this->getConfigFile(self::DATABASE_CONFIG_PATH, 'Database', false);
		}


        /**
         * Get the Config instance
         * @return Config
         */
        public static function getInstance(): Config
        {
            if(is_null(static::$_instance))
                static::$_instance = new static();

            return static::$_instance;
        }


        /* -------------------------------------------------------------------------- */
        /* GETTER */

            /**
             * Allow to take the value for a key in the config vars
             *
             * @param string $key
             * @return mixed
             */
            public function get(string $key)
            {
                $value = $this->keyExistIn($this->settings, $key);

                if (!is_null($value)) {
                    return $value;
                } else {
                    $value = $this->keyExistIn($this->defaultSettings, $key);
                    if (is_null($value)) {
                        // TODO : Throw ConfigException
                    }

                    return $value;
                }
            }

            /**
             * Check if a value exists for the key
             *
             * @param array $configs
             * @param string $key
             *
             * @return mixed
             */
            protected function keyExistIn(array $configs, string $key)
            {
                $keyArray = explode('.', $key);
                $key = array_shift($keyArray);
                $keyString = implode('.', $keyArray);

                if(isset($configs[$key])) {
                    $value = $configs[$key];

                    if (is_array($value) && !empty($keyString)) {
                        return $this->keyExistIn($value, $keyString);
                    }
                    return $value;
                }

                return NULL;
            }


        /* -------------------------------------------------------------------------- */
        /* CONFIGURATION */

            /**
             * @param string $path
             * @param string $groupName
             * @param bool $defaultConfig
             */
            protected function getConfigFile(string $path, ?string $groupName = NULL, bool $defaultConfig = true)
            {
                $settingsName = 'defaultSettings';
                if (!$defaultConfig) {
                    $settingsName = 'settings';
                }

                if (empty($this->$settingsName)) {
                    $this->$settingsName = [self::ROOT_CONFIG => []];
                }

                if (is_file($path)) {
                    if (is_null($groupName)) {
                        $this->$settingsName[self::ROOT_CONFIG] = require($path);
                    } else {
                        $this->$settingsName[self::ROOT_CONFIG][$groupName] = require($path);
                    }
                } else {
                    if ($defaultConfig) {
                        // TODO : ReadFilesException
                    }
                }
            }



	}
?>