<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : Command.php
	 *   @Created_at : 16/05/2018
	 *   @Update_at : 19/05/2018
	 * --------------------------------------------------------------------------
	 */
	
	namespace Luna\Component\Console\Command;
	
	use Luna\Component\Console\Input\InputInterface;
	use Luna\Component\Console\Output\OutputInterface;
	use Luna\Component\Exception\Console\CommandException;
	
	abstract class Command
	{
		/** @var string */
		protected $name;
		
		/** @var string */
		protected $description;
		
		/** @var array */
		protected $definition;
		
		/**
		 * Command constructor.
		 */
		public function __construct()
		{
			$this->configure();
		}
		
		
		# -------------------------------------------------------------
		#   Configuration
		# -------------------------------------------------------------
		
		/**
		 * Configure the current command.
		 */
		protected function configure()
		{}
		
		
		# -------------------------------------------------------------
		#   Run
		# -------------------------------------------------------------
		
		/**
		 * Run the command
		 *
		 * @param InputInterface $input
		 * @param OutputInterface $output
		 *
		 * @return int
		 * @throws CommandException
		 */
		public function run(InputInterface $input, OutputInterface $output): int
		{
			if (is_null($this->name)) {
				throw new CommandException('The name of the command cannot be null');
			}
			if (is_null($this->description)) {
				throw new CommandException('The description of the command cannot be null');
			}
			if (is_null($this->definition)) {
				$this->definition = [];
			}
			
			// Prepare input for command according to the command definition
			$input->bind($this->definition);
			
			// Execute the command
			$statusCode = $this->execute($input, $output);
			
			// Return Status Code
			return is_numeric($statusCode) ? (int) $statusCode : 0;
		}
		
		
		# -------------------------------------------------------------
		#   Command
		# -------------------------------------------------------------
		
		/**
		 * Configure the current command.
		 *
		 * @param InputInterface $input
		 * @param OutputInterface $output
		 *
		 * @return null|int
		 * @throws CommandException
		 */
		protected function execute(InputInterface $input, OutputInterface $output)
		{
			throw new CommandException('You must override the execute() method in the concrete command class.');
		}
		
		
		# -------------------------------------------------------------
		#   Others
		# -------------------------------------------------------------
		
		/**
		 * @return string|null
		 */
		public function getName(): ?string
		{
			return $this->name;
		}
		
		/**
		 * @param string $name
		 *
		 * @return self
		 */
		public function setName(string $name): self
		{
			$this->name = $name;
			return $this;
		}
		
		/**
		 * @return string|null
		 */
		public function getDescription(): ?string
		{
			return $this->description;
		}
		
		/**
		 * @param string $description
		 *
		 * @return self
		 */
		public function setDescription(string $description): self
		{
			$this->description = $description;
			return $this;
		}
		
		/**
		 * @return array
		 */
		public function getDefinition(): array
		{
			return $this->definition;
		}
		
		/**
		 * @param array $definition
		 *
		 * @return self
		 */
		public function setDefinition(array $definition): self
		{
			$this->definition = $definition;
			return $this;
		}
	}
?>