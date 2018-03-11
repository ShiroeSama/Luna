<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : Entity.php
	 *   @Created_at : 24/11/2016
	 *   @Update_at : 11/03/2017
	 * --------------------------------------------------------------------------
	 */

	namespace Luna\Entity;

	use Luna\Config;
	use Luna\Utils\Url\Url;

	class Entity
	{
		/** @var Config */
		protected $ConfigModule;

		/** @var Url */
		protected $UrlModule;
		
		/**
		 * Entity constructor.
		 *
		 * @param array|NULL $array
		 */
		public function __construct(array $array = NULL)
		{
			$this->ConfigModule = Config::getInstance();
			$this->UrlModule = new Url();
			
			if(!is_null($array)) {
				foreach ($array as $key => $value)
					if (property_exists($this, $key)) {
						$this->$key = $value;
					} else {
						// TODO : Throw EntityException
					}
			}
		}
	}
?>