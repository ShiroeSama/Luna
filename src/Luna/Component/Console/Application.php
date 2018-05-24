<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : Application.php
	 *   @Created_at : 15/05/2018
	 *   @Update_at : 19/05/2018
	 * --------------------------------------------------------------------------
	 */
	
	namespace Luna\Component\Console;
	
	use Luna\Component\Bag\ParameterBag;
	use Luna\Component\Console\Command\Command;
	use Luna\Component\Console\Input\InputArgument;
	use Luna\Component\Console\Input\InputInterface;
	use Luna\Component\Console\Input\InputOption;
	use Luna\Component\Console\Output\OutputInterface;
	use Luna\Component\Console\Output\Terminal;
	use Luna\Component\DI\DependencyInjector;
	use Luna\Component\Exception\ConfigException;
	use Luna\Component\Exception\Console\ConsoleException;
	use Luna\Component\Exception\DependencyInjectorException;
	use Luna\Component\Utils\ClassManager;
	use Luna\Config\Config;
	use Luna\Kernel;
	use Luna\KernelInterface;
	
	class Application
	{
		protected const APP_SUBSCRIBER = 'Application';
		
		protected const KEY_OTHERS = 'others';
		
		/** @var KernelInterface */
		protected $kernel;
		
		/** @var Config */
		protected $ConfigModule;
		
		/** @var DependencyInjector */
		protected $DIModule;
		
		/** @var ParameterBag */
		protected $commands;
		
		/** @var bool */
		protected $autoExit = true;
		
		
		# -------------------------------------------------------------
		#   Default Options
		# -------------------------------------------------------------
		
		/** @var ParameterBag */
		protected $defaultOptions;
		
		/** @var InputOption */
		protected $helpOption;
		
		/** @var InputOption */
		protected $quietOption;
		
		/** @var InputOption */
		protected $versionOption;
		
		
		# -------------------------------------------------------------
		#   Options
		# -------------------------------------------------------------
		
		/** @var bool */
		protected $help = false;
		
		/** @var bool */
		protected $version = false;
		
		
		/**
		 * Application constructor.
		 */
		public function __construct()
		{
			$this->kernel = new Kernel();
			$this->ConfigModule = Config::getInstance();
			$this->DIModule = new DependencyInjector();
			
			$this->helpOption = new InputOption('Help', '-h', 'Display this help message');
			$this->quietOption = new InputOption('Quiet', '-q', 'Do not output any message');
			$this->versionOption = new InputOption('Version', '-V', 'Display this application version');
			
			$this->defaultOptions = new ParameterBag([
				$this->helpOption,
				$this->quietOption,
				$this->versionOption
			]);
		}
		
		/**
		 * @param InputInterface $input
		 *
		 * @return int
		 */
		public function run(InputInterface $input): int
		{
			$output = new Terminal();
			$exitCode = 0;
			
			try {
				$this->registerCommands();
				
				if ($input->isEmpty()) {
					$this->displayHelp($output);
					return 0;
				} else {
					$parameter = $input->getFirst();
					
					$command = NULL;
					$callCommandProcess = strpos($parameter, '-') === 0 ? false : true;
					if ($callCommandProcess) {
						$command = $this->commandProcess($input);
					}
					
					$exec = $this->optionsProcess($input, $output, $command);
					
					if ($exec && $callCommandProcess) {
						$exitCode = $command->run($input, $output);
					}
				}
			} catch (\Throwable $throwable) {
				if (!ClassManager::is(ConsoleException::class, $throwable)) {
					$throwable = new ConsoleException($throwable->getMessage(), ConsoleException::DEFAULT_CODE, $throwable);
				}
				
				$this->displayError($throwable, $output);
				$exitCode = (int) $throwable->getCode();
			}
			
			if ($this->autoExit) {
				if ($exitCode > 255) {
					$exitCode = 255;
				}
				
				exit($exitCode);
			}
			
			return $exitCode;
		}
		
		
		# -------------------------------------------------------------
		#   Prepare
		# -------------------------------------------------------------
		
		/**
		 * @throws ConfigException
		 * @throws DependencyInjectorException
		 */
		protected function registerCommands()
		{
			$subscribers = $this->ConfigModule->getSubscriber(self::APP_SUBSCRIBER);
			
			$this->commands = new ParameterBag();
			foreach ($subscribers as $subscriber) {
				if (ClassManager::is(Command::class, $subscriber)) {
					/** @var Command $command */
					$command = $this->DIModule->callConstructor($subscriber);
					
					$commandName = $command->getName();
					$rootName = $this->getRootName($commandName);
					
					if (is_null($rootName)) {
						$rootName = self::KEY_OTHERS;
					}
					
					$commands = $this->commands->get($rootName);
					if (is_null($commands) || !is_array($commands)) {
						$commands = [$commandName => $command];
					} else {
						$commands[$commandName] = $command;
					}
					
					$this->commands->set($rootName, $commands);
				}
			}
			
			$this->commands->keySort();
		}
		
		/**
		 * @param string $name
		 * @return null|string
		 */
		protected function getRootName(string $name): ?string
		{
			$separators = [':', '.', '_', '-'];
			
			$rootName = false;
			foreach ($separators as $separator) {
				$rootName = strstr($name, $separator, true);
				if ($rootName) {
					break;
				}
			}
			
			return $rootName ? $rootName : NULL;
		}
		
		/**
		 * @return bool
		 */
		public function isAutoExit(): bool
		{
			return $this->autoExit;
		}
		
		/**
		 * @param bool $autoExist
		 *
		 * @return self
		 */
		public function setAutoExit(bool $autoExit): self
		{
			$this->autoExit = $autoExit;
			
			return $this;
		}
		
		
		# -------------------------------------------------------------
		#   Commands Process
		# -------------------------------------------------------------
		
		/**
		 * @param InputInterface $input
		 *
		 * @return Command
		 *
		 * @throws ConsoleException
		 */
		protected function commandProcess(InputInterface $input): Command
		{
			$parameter = $input->getFirst();
			
			foreach ($this->commands as $values) {
				/** @var Command $command */
				foreach ($values as $command) {
					if ($parameter == $command->getName()) {
						return $command;
					}
				}
			}
			
			throw new ConsoleException("The command '{$parameter}' doesn't exist.");
		}
		
		
		# -------------------------------------------------------------
		#   Options Process
		# -------------------------------------------------------------
		
		/**
		 * @param InputInterface $input
		 * @param OutputInterface $output
		 * @param null|Command $command
		 *
		 * @return bool
		 *
		 * @throws ConsoleException
		 */
		protected function optionsProcess(InputInterface $input, OutputInterface $output, ?Command $command = NULL): bool
		{
			$options = $input->getOptions();
			foreach ($options as $option) {
				$exist = false;
				
				/** @var InputOption $inputOption */
				foreach ($this->defaultOptions as $inputOption) {
					$exist = $this->inputOptionProcess($inputOption, $option, $output);
					if ($exist) { break; }
				}
				
				if (!$exist) {
					if (!is_null($command)) {
						$commandDefinitions = $command->getDefinition();
						
						/** @var InputOption $inputOption */
						foreach ($commandDefinitions as $definition) {
							if (ClassManager::is(InputOption::class, $definition)) {
								$exist = $this->inputOptionProcess($definition, $option, $output);
								if ($exist) { break; }
							}
						}
					}
					
					if (!$exist) {
						throw new ConsoleException("Option '{$option}' doesn't exist. Check the console options.");
					}
				}
			}
			
			if ($this->help) {
				if (is_null($command)) {
					$this->displayHelp($output);
				} else {
					$this->displayCommandHelp($command, $output);
				}
				
				return false;
			}
			
			return true;
		}
		
		/**
		 * Check if options exist and the type of this
		 *
		 * @param InputOption $inputOption
		 * @param $option
		 * @param OutputInterface $output
		 *
		 * @return bool
		 */
		protected function inputOptionProcess(InputOption $inputOption, $option, OutputInterface $output)
		{
			$exist = false;
			if ($inputOption->equal($option)) {
				$exist = true;
				
				$this->help = $inputOption->equal($this->helpOption);
				$output->setQuiet($inputOption->equal($this->quietOption));
				$this->version = $inputOption->equal($this->versionOption);
			}
			
			return $exist;
		}
		
		
		# -------------------------------------------------------------
		#   Displays
		# -------------------------------------------------------------
		
		/**
		 * Display the version of the application
		 *
		 * @param OutputInterface $output
		 */
		protected function displayVersion(OutputInterface $output)
		{
			if ($this->version) {
				// TODO : Display Luna Version
			}
		}
		
		
		/**
		 * Display the bin/console information
		 *
		 * @param OutputInterface $output
		 */
		protected function displayHelp(OutputInterface $output)
		{
			$this->displayVersion($output);
			
			$output
				# ----------------------------------------------------------
				# Usage
				
				->writeln('Usage :', Color::FOREGROUND_BROWN)
				
				->write(str_repeat(' ', 2))
				->write('php ')
				->write('bin/console', Color::FOREGROUND_GREEN)
				->writeln(' command [options] [arguments]')
				
				->writeln()
				
				
				# ----------------------------------------------------------
				# Options
				
				->writeln('Options :', Color::FOREGROUND_BROWN)
			;
			
			/** @var InputOption $option */
			foreach ($this->defaultOptions as $option) {
				$output->write(str_repeat(' ', 2));
					
				if (is_null($option->getShortcut())) {
					$output->write($option->getLongName(), Color::FOREGROUND_GREEN);
				} else {
					$output->write($option->getShortcut() . ', ' . $option->getLongName(), Color::FOREGROUND_GREEN);
				}
				
				$output->writeln("\t " . $option->getDescription());
			}
			
			$output
				->writeln()
				
				
				# ----------------------------------------------------------
				# Commands
				
				->writeln('Available commands :', Color::FOREGROUND_BROWN)
			;
			
			foreach ($this->commands as $key => $values) {
				
				$output
					->write(str_repeat(' ', 2))
					->writeln($key, Color::FOREGROUND_CYAN)
				;
				
				/** @var Command $command */
				foreach ($values as $command) {
					if (!is_null($command->getName())) {
						$output
							->write(str_repeat(' ', 4))
							->write('- ')
							->write($command->getName(), Color::FOREGROUND_GREEN)
							->write(' ')
							->writeln($command->getDescription())
						;
					}
				}
			}
			
			$output->writeln();
		}
		
		
		/**
		 * Display the command help
		 *
		 * @param Command $command
		 * @param OutputInterface $output
		 */
		protected function displayCommandHelp(Command $command, OutputInterface $output)
		{
			$this->displayVersion($output);
			
			$output
				# ----------------------------------------------------------
				# Usage
				
				->writeln('Usage :', Color::FOREGROUND_BROWN)
				
				->write(str_repeat(' ', 2))
				->write('php ')
				->write('bin/console', Color::FOREGROUND_GREEN)
				->writeln(" {$command->getName()} [options] [arguments]")
				
				->writeln()
				
				# ----------------------------------------------------------
				# Description
				
				->writeln('Description :', Color::FOREGROUND_BROWN)
				
				->write(str_repeat(' ', 2))
				->writeln($command->getDescription())
				
				->writeln()
				
				
				# ----------------------------------------------------------
				# Options
				
				->writeln('Options :', Color::FOREGROUND_BROWN)
			;
			
			/** @var InputOption $option */
			foreach ($this->defaultOptions as $option) {
				$this->displayOption($option, $output);
			}
			
			foreach ($command->getDefinition() as $definition) {
				if (ClassManager::is(InputOption::class, $definition)) {
					/** @var InputOption $definition */
					$this->displayOption($definition, $output);
				}
			}
			
			$output
				->writeln()
				
				
				# ----------------------------------------------------------
				# Arguments
				
				->writeln('Arguments :', Color::FOREGROUND_BROWN)
			;
			
			foreach ($command->getDefinition() as $definition) {
				if (ClassManager::is(InputArgument::class, $definition)) {
					/** @var InputArgument $definition */
					$output
						->write(str_repeat(' ', 2))
						->write($definition->getName(), Color::FOREGROUND_GREEN)
					;
					
					$output->write("\t");
					if ($definition->isRequired()) {
						$output->write('REQUIRED', Color::FOREGROUND_RED);
					} elseif ($definition->isOptional()) {
						$defaultValue = $definition->getDefaultValue();
						
						if (is_null($defaultValue)) {
							$defaultValue = 'NULL';
						} elseif (is_bool($defaultValue)) {
						 	$defaultValue = ($defaultValue) ? 'true' : 'false';
						}
						
						$output
							->write('OPTIONAL', Color::FOREGROUND_CYAN)
							->write(" ({$defaultValue})")
						;
					}
					
					$output->writeln("\t " . $definition->getDescription());
				}
			}
			
			$output->writeln();
		}
		
		/**
		 * Display Options
		 *
		 * @param ConsoleException $exception
		 * @param OutputInterface $output
		 */
		protected function displayOption(InputOption $option, OutputInterface $output)
		{
			$output->write(str_repeat(' ', 2));
			
			if (is_null($option->getShortcut())) {
				$output->write($option->getLongName(), Color::FOREGROUND_GREEN);
			} else {
				$output->write($option->getShortcut() . ', ' . $option->getLongName(), Color::FOREGROUND_GREEN);
			}
			
			$output->writeln("\t " . $option->getDescription());
		}
		
		
		/**
		 * Display all throwable (Error)
		 *
		 * @param ConsoleException $exception
		 * @param OutputInterface $output
		 */
		protected function displayError(ConsoleException $exception, OutputInterface $output)
		{
			$this->displayVersion($output);
			
			$message = str_repeat(' ', 4) . $exception->getMessage() . str_repeat(' ', 4);
			
			$messageLen = strlen($message);
			$whitespaceLine = str_repeat(' ', $messageLen);
			
			$output
				->writeln($whitespaceLine, NULL, Color::BACKGROUND_RED)
				->writeln($message, Color::FOREGROUND_WHITE, Color::BACKGROUND_RED)
				->writeln($whitespaceLine, NULL, Color::BACKGROUND_RED)
				->writeln()
			;
		}
	}
?>

