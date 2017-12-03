<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : Core.php
	 *   @Created_at : 03/12/2017
	 *   @Update_at : 03/12/2017
	 * --------------------------------------------------------------------------
	 */
	
	namespace Core;
	
	class Core
	{
		protected static $_instance;
		protected $Bundles;
		
		protected const PARAM_MAIN_CLASS = 'MainClass';
		protected const PARAM_NAMESPACE = 'Namespace';
		
		protected function __construct()
		{
			$this->Bundles = array(
				[self::PARAM_MAIN_CLASS => 'ShirOSBundle\ShirOSBundle.php', self::PARAM_NAMESPACE => 'ShirOSBundle']
			);
		}
		
		public static function register()
		{
			if(is_null(self::$_instance))
				self::$_instance = new Core();
			
			$CoreModule = self::$_instance;
			$Bundles = $CoreModule->getBundles();
			
			foreach ($Bundles as $bundle) {
				require_once $CoreModule->getBundlePath($bundle);
				$bundle = $CoreModule->getBundleName($bundle);
				
				$bundle::register();
			}
		}
		
		public function getBundles() { return $this->Bundles; }
		protected function getBundlePath($bundle)
		{
			$bundlePath = $bundle[self::PARAM_MAIN_CLASS];
			return str_replace('\\', DIRECTORY_SEPARATOR, $bundlePath);
		}
		protected function getBundleName($bundle) { return $bundle[self::PARAM_NAMESPACE]; }
	}
?>