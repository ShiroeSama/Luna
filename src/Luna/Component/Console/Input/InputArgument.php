<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : InputArgument.php
	 *   @Created_at : 19/05/2018
	 *   @Update_at : 19/05/2018
	 * --------------------------------------------------------------------------
	 */
	
	namespace Luna\Component\Console\Input;
	
	use Luna\Component\Exception\Console\InputArgumentException;
	
	class InputArgument
	{
		public const REQUIRED = 1;
		public const OPTIONAL = 2;
		
		/** @var string */
		protected $name;
		
		/** @var int */
		protected $mode;
		
		/** @var string */
		protected $description;
		
		/** @var mixed */
		protected $default;
		
		/**
		 * InputArgument constructor.
		 *
		 * @param string $name
		 * @param int $mode
		 * @param string $description
		 * @param mixed $default
		 *
		 * @throws InputArgumentException
		 */
		public function __construct(string $name, int $mode = self::OPTIONAL, string $description = '', $default = NULL)
		{
			if (!$this->checkMode($mode)) {
				throw new InputArgumentException("Argument mode '{$mode}' is not valid.");
			}
			
			$this->name = $name;
			$this->mode = $mode;
			$this->description = $description;
			$this->setDefault($default);
		}
		
		
		# -------------------------------------------------------------
		#   Prepare
		# -------------------------------------------------------------
		
		/**
		 * Prepare the default value
		 *
		 * @param null $default
		 * @throws InputArgumentException
		 */
		protected function setDefault($default = NULL)
		{
			if ($this->mode === self::REQUIRED && !is_null($default)) {
				throw new InputArgumentException('Default value can be set only for InputArgument::OPTIONAL mode.');
			}
			
			$this->default = $default;
		}
		
		
		/**
		 * Check if the mode exist
		 *
		 * @param int $mode
		 * @return bool
		 */
		protected function checkMode(int $mode): bool
		{
			switch ($mode) {
				case self::REQUIRED:
				case self::OPTIONAL:
					return true;
				default:
					return false;
			}
		}
		
		
		# -------------------------------------------------------------
		#   Getters
		# -------------------------------------------------------------
		
		/**
		 * @return string
		 */
		public function getName(): string
		{
			return $this->name;
		}
		
		/**
		 * @return int
		 */
		public function isRequired(): int
		{
			return $this->mode === self::REQUIRED;
		}
		
		/**
		 * @return int
		 */
		public function isOptional(): int
		{
			return $this->mode === self::OPTIONAL;
		}
		
		/**
		 * @return string
		 */
		public function getDescription(): string
		{
			return $this->description;
		}
		
		/**
		 * @return mixed
		 */
		public function getDefaultValue()
		{
			return $this->default;
		}
	}
?>