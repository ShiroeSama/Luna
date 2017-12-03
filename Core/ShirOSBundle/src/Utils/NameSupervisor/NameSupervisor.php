<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : NameSupervisor.php
	 *   @Created_at : 10/07/2017
	 *   @Update_at : 03/12/2017
	 * --------------------------------------------------------------------------
	 */

	namespace ShirOSBundle\Utils\NameSupervisor;
	use ShirOSBundle\Config;

	class NameSupervisor
	{
		/**
		 * Instance de la Classe de gestion des Configs
		 * @var Config
		 */
		protected $ConfigModule;

		/**
		 * Contient l'instance de la classe
		 * @var NameSupervisor
		 */
		protected static $_instance;
		
		
		/**
		 * NameSupervisor constructor, Singleton
		 */
		protected function __construct() { $this->ConfigModule = Config::getInstance(); }

		/**
		 * Retourne l'instance de la classe 'NameSupervisor'
		 *
		 * @return NameSupervisor
		 */
		public static function getInstance(): NameSupervisor
		{
			if(is_null(self::$_instance))
				self::$_instance = new NameSupervisor();
			return self::$_instance;
		}

		/**
		 * Retourne le chemin du model associé à la 'Gateway'
		 *
		 * @param string $path
		 *
		 * @return string
		 */
		public function GatewayModel_Path(string $path): string
		{
			$path = str_replace($this->ConfigModule->get('ShirOS.Name.Folder.Namespace.Gateway'), $this->ConfigModule->get('ShirOS.Name.Folder.Namespace.Model'), $path);

			switch ($this->ConfigModule->get('ShirOS.Namespace.PS_Type')) {
				case 'Prefixe':
				case 'Suffixe':
					return str_replace($this->ConfigModule->get('ShirOS.Name.File.Namespace.Gateway'), $this->ConfigModule->get('ShirOS.Name.File.Namespace.Model'), $path);
					break;
				
				default:
					return $path;
					break;
			}
		}

		/**
		 * Retourne le 'Model' prefixé ou suffixé de la valeur de config
		 *
		 * @param string $name
		 *
		 * @return string
		 */
		public function PS_Model(String $name): string
		{
			switch ($this->ConfigModule->get('ShirOS.Namespace.PS_Type')) {
				case 'Prefixe':
					return $this->ConfigModule->get('ShirOS.Name.File.Namespace.Model') . $name;
					break;

				case 'Suffixe':
					return $name . $this->ConfigModule->get('ShirOS.Name.File.Namespace.Model');
					break;
					
				default:
					return $name;
					break;
			}
		}

		/**
		 * Retourne la 'Gateway' prefixé ou suffixé de la valeur de config
		 *
		 * @param string $name
		 *
		 * @return string
		 */
		public function PS_Gateway(string $name): string
		{
			switch ($this->ConfigModule->get('ShirOS.Namespace.PS_Type')) {
				case 'Prefixe':
					return $this->ConfigModule->get('ShirOS.Name.File.Namespace.Gateway') . $name;
					break;

				case 'Suffixe':
					return $name . $this->ConfigModule->get('ShirOS.Name.File.Namespace.Gateway');
					break;

				default:
					return $name;
					break;
			}
		}
	}

?>