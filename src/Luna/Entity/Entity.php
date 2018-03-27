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
	
	class Entity
	{
	    /** @var string */
	    protected $table;

		/** @var Config */
		protected $ConfigModule;
		
		/**
		 * Entity constructor.
		 */
		public function __construct()
		{
			$this->ConfigModule = Config::getInstance();
		}

		public function getTable(): string
        {
            return $this->table;
        }
		
		public function __get($key) {}
		public function __set($name, $value) {}
	}
?>