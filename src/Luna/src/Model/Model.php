<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : Model.php
	 *   @Created_at : 24/11/2016
	 *   @Update_at : 02/12/2017
	 * --------------------------------------------------------------------------
	 */

	namespace ShirOSBundle\Model;

	use ShirOSBundle\Config;
	use ShirOSBundle\Utils\Url\Url;

	class Model
	{
		/**
		 * Instance de la Classe de gestion des Configs
		 * @var Config
		 */
		protected $ConfigModule;

		/**
		 * Instance de la Classe de gestion des Url
		 * @var Url
		 */
		protected $UrlModule;
		
		
		/**
		 * Model constructor.
		 *
		 * @param array|NULL $array
		 */
		public function __construct(array $array = NULL)
		{
			$this->ConfigModule = Config::getInstance();
			$this->UrlModule = new Url();
			
			if(!is_null($array)) {
				foreach ($array as $key => $value)
					$this->$key = $value;
			}
		}

		/**
		 * Gérer les différents cas d'accés à une propriété ou méthode
		 *
		 * @param string $key
		 *
		 * @return mixed
		 */
		public function __get(string $key)
		{
			$key = lcfirst($key);
			$method = 'get' . ucfirst($key);
			
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
	}
?>