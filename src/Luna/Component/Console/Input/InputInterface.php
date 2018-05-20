<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : InputArgv.php
	 *   @Created_at : 15/05/2018
	 *   @Update_at : 19/05/2018
	 * --------------------------------------------------------------------------
	 */
	
	namespace Luna\Component\Console\Input;
	
	interface InputInterface
	{
		
		
		/**
		 * Check if the input bag is empty
		 *
		 * @return bool
		 */
		public function isEmpty(): bool;
		
		
		/**
		 * Check if the command contains specific option
		 *
		 * @return bool
		 */
		public function has(string $option): bool;
		
		
		/**
		 * Get argument or options in the input bag
		 *
		 * @return string|null
		 */
		public function get(string $name): ?string;
		
		/**
		 * Get first input parameter
		 *
		 * @return string|null
		 */
		public function getFirst(): ?string;
		
		/**
		 * Prepare input for command according to the command definition
		 *
		 * @param
		 */
		public function bind(array $commandDefinitions);
		
		
		# -------------------------------------------------------------
		#   Argument
		# -------------------------------------------------------------
		
		/**
		 * Get arguments in the input bag
		 *
		 * @return string|null
		 */
		public function getArguments(): array;
		
		
		# -------------------------------------------------------------
		#   Options
		# -------------------------------------------------------------
		
		/**
		 * Get options in the input bag
		 *
		 * @return string|null
		 */
		public function getOptions(): array;
	}
?>