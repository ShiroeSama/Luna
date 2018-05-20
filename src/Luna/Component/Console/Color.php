<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : Color.php
	 *   @Created_at : 17/05/2018
	 *   @Update_at : 17/05/2018
	 * --------------------------------------------------------------------------
	 */
	
	namespace Luna\Component\Console;
	
	class Color
	{
		# -------------------------------------------------------------
		#   Foreground Colors
		# -------------------------------------------------------------
		
		public const FOREGROUND_BLACK = '0;30';
		public const FOREGROUND_DARK_GRAY = '1;30';
		public const FOREGROUND_LIGHT_GRAY = '1;37';
		public const FOREGROUND_BLUE = '0;34';
		public const FOREGROUND_LIGHT_BLUE = '1;34';
		public const FOREGROUND_GREEN = '0;32';
		public const FOREGROUND_LIGHT_GREEN = '1;32';
		public const FOREGROUND_CYAN = '0;36';
		public const FOREGROUND_LIGHT_CYAN = '1;36';
		public const FOREGROUND_RED = '0;31';
		public const FOREGROUND_LIGHT_RED = '1;31';
		public const FOREGROUND_PURPLE = '0;35';
		public const FOREGROUND_LIGHT_PURPLE = '1;35';
		public const FOREGROUND_BROWN = '0;33';
		public const FOREGROUND_YELLOW = '1;33';
		public const FOREGROUND_WHITE = '1;37';
		
		
		# -------------------------------------------------------------
		#   Background Colors
		# -------------------------------------------------------------
		
		public const BACKGROUND_BLACK = '40';
		public const BACKGROUND_RED = '41';
		public const BACKGROUND_GREEN = '42';
		public const BACKGROUND_YELLOW = '43';
		public const BACKGROUND_BLUE = '44';
		public const BACKGROUND_MAGENTA = '45';
		public const BACKGROUND_CYAN = '46';
		public const BACKGROUND_LIGHT_GRAY = '47';
	}
?>