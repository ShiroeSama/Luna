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
	
	use Luna\Component\Utils\ClassManager;
	
	class InputOption
	{
		/** @var string */
		protected $name;
		
		/** @var string */
		protected $longName;
		
		/** @var ?string */
		protected $shortcut;
		
		/** @var string */
		protected $description;
		
		/**
		 * InputArgument constructor.
		 *
		 * @param string $name
		 * @param null|string $shortcut
		 * @param string $description
		 */
		public function __construct(string $name, ?string $shortcut = NULL, string $description = '')
		{
			if (strpos($name, '--') === 0) {
				$name = substr($name, 2);
				$longName = strtolower($name);
			} else {
				$longName = '--' . strtolower($name);
			}
			
			$this->name = $name;
			$this->longName = $longName;
			$this->shortcut = $shortcut;
			$this->description = $description;
		}
		
		public function equal($option): bool
		{
			if (ClassManager::is(InputOption::class, $option)) {
				/** @var InputOption $option */
				return $this->getName() === $option->getName()
					&& $this->getLongName() === $option->getLongName()
					&& $this->getShortcut() === $option->getShortcut();
			} elseif (is_string($option)) {
				return $this->getLongName() === $option or $this->getShortcut() === $option;
			}
			
			return false;
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
		 * @return string
		 */
		public function getLongName(): string
		{
			return $this->longName;
		}
		
		/**
		 * @return null|string
		 */
		public function getShortcut(): ?string
		{
			return $this->shortcut;
		}
		
		/**
		 * @return string
		 */
		public function getDescription(): string
		{
			return $this->description;
		}
	}
?>