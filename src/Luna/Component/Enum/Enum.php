<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : Enum.php
	 *   @Created_at : 24/11/2016
	 *   @Update_at : 02/12/2017
	 * --------------------------------------------------------------------------
	 */

	namespace Luna\Utils\Enum;
	
	class Enum
	{
		/**
		 * Contient l'Enumération
		 * @var array
		 */
		protected $enum = [];
		
		/**
		 * Enum constructor.
		 * @param array $fields
		 */
		public function __construct(array $fields = [])
		{
			foreach ($fields as $field)
				$this->enum[] = $field;
		}

		/**
		 * Vérifie que la valeur en paramètre est dans l'énumeration
		 *
		 * @param $value
		 *
		 * @return bool
		 */
		public function isInEnum($value): bool
		{
			foreach ($this->enum as $key)
				if($key == $value)
					return true;
			return false;
		}

		/**
		 * Revoie l'énumeration
		 *
		 * @return array
		 */
		public function getEnum(): array { return $this->enum; }
	}
?>