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
	
	use Luna\Component\Bag\ParameterBag;
	use Luna\Component\Exception\Console\ConsoleException;
	use Luna\Component\Utils\ClassManager;
	
	class InputArgv implements InputInterface
	{
		/** @var string */
		protected $scriptName;
		
		/** @var ParameterBag */
		protected $argv;
		
		/** @var ParameterBag */
		protected $arguments;
		
		/** @var ParameterBag */
		protected $options;
		
		/**
		 * InputArgv constructor.
		 */
		public function __construct(array $argv = NULL)
		{
			if (is_null($argv)) {
				$argv = $_SERVER['argv'];
			}
			
			$this->scriptName = array_shift($argv);
			$this->configure($argv);
		}
		
		protected function configure(array $argv)
		{
			$this->argv = new ParameterBag($argv);
			
			$this->arguments = new ParameterBag(array_filter($argv, __CLASS__ . '::argumentsFilterCallback', ARRAY_FILTER_USE_BOTH));
			$this->options = new ParameterBag(array_filter($argv, __CLASS__ . '::optionsFilterCallback', ARRAY_FILTER_USE_BOTH));
		}
		
		protected function optionsFilterCallback($var) : bool { return strpos($var, '-') === 0; }
		protected function argumentsFilterCallback($var) : bool { return strpos($var, '-') === false; }
		
		
		/**
		 * Check if the input bag is empty
		 *
		 * @return bool
		 */
		public function isEmpty(): bool
		{
			return $this->argv->isEmpty();
		}
		
		
		/**
		 * Check if the command contains specific option
		 *
		 * @return bool
		 */
		public function has(string $option): bool
		{
			return $this->argv->contains($option);
		}
		
		
		/**
		 * Get argument or options in the input bag
		 *
		 * @return string|null
		 */
		public function get(string $name): ?string
		{
			return $this->argv->get($name);
		}
		
		/**
		 * Get first input parameter
		 *
		 * @return string|null
		 */
		public function getFirst(): ?string
		{
			$parameter = $this->argv->all();
			return empty($parameter) ? NULL : reset($parameter);
		}
		
		/**
		 * Prepare input for command according to the command definition
		 * @throws ConsoleException
		 */
		public function bind(array $commandDefinitions)
		{
			$bindArgs = new ParameterBag();
			
			$args = $this->arguments->all();
			array_shift($args);
			$options = $this->options->all();
			
			$optionalDefinitions = [];
			foreach ($commandDefinitions as $definition) {
				if (ClassManager::is(InputArgument::class, $definition)) {
					/** @var InputArgument $definition */
					if ($definition->isRequired()) {
						$arg = array_shift($args);
						
						if (is_null($arg)) {
							throw new ConsoleException("Argument missing for definition '{$definition->getName()}'");
						}
						
						$bindArgs->set($definition->getName(), $arg);
					} elseif ($definition->isOptional()) {
						array_push($optionalDefinitions, $definition);
					}
				} elseif (ClassManager::is(InputOption::class, $definition)) {
					/** @var InputOption $definition */
					$option = array_shift($options);
					
					if (!is_null($option)) {
						$bindArgs->set($definition->getName(), $option);
					}
				}
			}
			
			/** @var InputArgument $definition */
			foreach ($optionalDefinitions as $definition) {
				$arg = array_shift($args);
				
				if (is_null($arg)) {
					$arg = $definition->getDefaultValue();
				}
				$bindArgs->set($definition->getName(), $arg);
			}
			
			$this->configure($bindArgs->all());
		}
		
		
		# -------------------------------------------------------------
		#   Argument
		# -------------------------------------------------------------
		
		/**
		 * Get arguments in the input bag
		 *
		 * @return string|null
		 */
		public function getArguments(): array
		{
			return $this->arguments->all();
		}
		
		
		# -------------------------------------------------------------
		#   Options
		# -------------------------------------------------------------
		
		/**
		 * Get options in the input bag
		 *
		 * @return string|null
		 */
		public function getOptions(): array
		{
			return $this->options->all();
		}
	}
?>