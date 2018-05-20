<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : OutputInterface.php
	 *   @Created_at : 16/05/2018
	 *   @Update_at : 19/05/2018
	 * --------------------------------------------------------------------------
	 */
	
	namespace Luna\Component\Console\Output;
	
	interface OutputInterface
	{
		/**
		 * Write in the console
		 *
		 * @param null|string $text
		 * @param null|string $foreground_color
		 * @param null|string $background_color
		 *
		 * @return OutputInterface
		 */
		public function write(?string $text = NULL, ?string $foreground_color = NULL, ?string $background_color = NULL, bool $newLine = false): OutputInterface;
		
		/**
		 * Write line in the console
		 *
		 * @param null|string $text
		 * @param null|string $foreground_color
		 * @param null|string $background_color
		 *
		 * @return OutputInterface
		 */
		public function writeln(?string $text = NULL, ?string $foreground_color = NULL, ?string $background_color = NULL): OutputInterface;
		
		/**
		 * To hide the output text
		 *
		 * @param bool $quiet
		 *
		 * @return OutputInterface
		 */
		public function setQuiet(bool $quiet): OutputInterface;
	}
?>