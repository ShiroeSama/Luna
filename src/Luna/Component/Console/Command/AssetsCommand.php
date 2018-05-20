<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : AssetsCommand.php
	 *   @Created_at : 16/05/2018
	 *   @Update_at : 19/05/2018
	 * --------------------------------------------------------------------------
	 */
	
	namespace Luna\Component\Console\Command;
	
	use Luna\Component\Console\Color;
	use Luna\Component\Console\Input\InputArgument;
	use Luna\Component\Console\Input\InputInterface;
	use Luna\Component\Console\Input\InputOption;
	use Luna\Component\Console\Output\OutputInterface;
	
	class AssetsCommand extends Command
	{
		/**
		 * @throws \Luna\Component\Exception\Console\InputArgumentException
		 */
		protected function configure()
		{
			$this
				->setName('luna:assets')
				->setDescription('Luna assets installation')
				->setDefinition([
					new InputOption('TestOption', '-t', 'Command Option'),
					new InputArgument('Test', InputArgument::OPTIONAL, 'Optionnel Param'),
					new InputArgument('Test 2', InputArgument::REQUIRED, 'Required Param')
				])
			;
		}
		
		protected function execute(InputInterface $input, OutputInterface $output)
		{
			// TODO : Execute the Command
			
			$output->writeln('Luna Assets', Color::FOREGROUND_BROWN);
		}
	}
?>