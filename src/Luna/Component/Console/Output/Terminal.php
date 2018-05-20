<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : Terminal.php
	 *   @Created_at : 16/05/2018
	 *   @Update_at : 19/05/2018
	 * --------------------------------------------------------------------------
	 */
	
	namespace Luna\Component\Console\Output;
	
	class Terminal implements OutputInterface
	{
		/** @var bool */
		protected $quiet = false;
		
		/**
		 * Write in the console
		 *
		 * @param null|string $text
		 * @param null|string $foreground_color
		 * @param null|string $background_color
		 * @return OutputInterface
		 */
		public function write(?string $text = NULL, ?string $foreground_color = NULL, ?string $background_color = NULL, bool $newLine = false): OutputInterface
		{
			if (is_null($text)) {
				$text = '';
			}
			
			if ($newLine) {
				$text .= "\n";
			}
			
			$string = $this->prepareString($text, $foreground_color, $background_color);
			
			if (!$this->quiet) {
				echo $string;
			}
			
			return $this;
		}
		
		/**
		 * Write line in the console
		 *
		 * @param null|string $text
		 * @param null|string $foreground_color
		 * @param null|string $background_color
		 * @return OutputInterface
		 */
		public function writeln(?string $text = NULL, ?string $foreground_color = NULL, ?string $background_color = NULL): OutputInterface
		{
			$this->write($text, $foreground_color, $background_color, true);
			return $this;
		}
		
		/**
		 * To hide the output text
		 *
		 * @param bool $quiet
		 *
		 * @return OutputInterface
		 */
		public function setQuiet(bool $quiet): OutputInterface
		{
			$this->quiet = $quiet;
			
			return $this;
		}
		
		/**
		 * Prepare the output
		 *
		 * @param string $text
		 * @param null|string $foreground_color
		 * @param null|string $background_color
		 * @return string
		 */
		protected function prepareString(string $text, ?string $foreground_color = NULL, ?string $background_color = NULL)
		{
			$string = '';
			$colored = false;
			
			if (!is_null($foreground_color)) {
				$colored = true;
				$string .= "\033[" . $foreground_color . "m";
			}
			
			if (!is_null($background_color)) {
				$colored = true;
				$string .= "\033[" . $background_color . "m";
			}
			
			$string .=  $text;
			
			if ($colored) {
				$string .= "\033[0m";
			}
			
			return $string;
		}
	}
?>