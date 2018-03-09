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
		 * Contient le PS_Type de la Config (PS : Prefixe / Suffixe)
		 * @var string
		 */
		protected $PS_Type;
		
		/**
		 * Contient le nom du dossier des 'Gateway'
		 * @var string
		 */
		protected $FolderNameGateway;
		
		/**
		 * Contient le nom du dossier des 'Models'
		 * @var string
		 */
		protected $FolderNameModel;
		
		/**
		 * Contient le prefixe ou suffixe des 'Gateway'
		 * @var string
		 */
		protected $FileNameGateway;
		
		/**
		 * Contient le prefixe ou suffixe des 'Models'
		 * @var string
		 */
		protected $FileNameModel;
		
		
		/**
		 * NameSupervisor constructor, Singleton
		 */
		protected function __construct() {
			$this->ConfigModule = Config::getInstance();
			
			$this->PS_Type = $this->ConfigModule->get('ShirOS.Namespace.PS_Type');
			$this->FolderNameGateway = $this->ConfigModule->get('ShirOS.Name.Folder.Namespace.Gateway');
			$this->FolderNameModel = $this->ConfigModule->get('ShirOS.Name.Folder.Namespace.Model');
			$this->FileNameGateway = $this->ConfigModule->get('ShirOS.Name.File.Namespace.Gateway');
			$this->FileNameModel = $this->ConfigModule->get('ShirOS.Name.File.Namespace.Model');
		}

		/**
		 * Retourne l'instance de la classe 'NameSupervisor'
		 *
		 * @return NameSupervisor
		 */
		public static function getInstance(): NameSupervisor
		{
			if(is_null(static::$_instance))
				static::$_instance = new static();
			return static::$_instance;
		}

		/**
		 * Retourne le chemin du model associé à la 'Gateway'
		 *
		 * @param string $path
		 *
		 * @return string
		 */
		public function gatewayPath_To_modelPath(string $path): string
		{
			$path = str_replace($this->FolderNameGateway, $this->FolderNameModel, $path);

			switch ($this->PS_Type) {
				case 'Prefixe':
				case 'Suffixe':
					return
						$path = str_replace($this->FileNameGateway, $this->FileNameModel, $path);
					break;
				
				default:
					return $path;
					break;
			}
		}
		
		/**
		 * Retourne le nom de la classe sans le Prefixe ou Suffixe de celle-ci
		 *
		 * @param string $gatewayNamespace
		 *
		 * @return string
		 */
		public function getGatewayName(string $gatewayNamespace): string {
			$explode = explode('\\', $gatewayNamespace);
			return end($explode);
		}
		
		/**
		 * Retourne le nom de la classe sans le Prefixe ou Suffixe de celle-ci
		 *
		 * @param string $name
		 *
		 * @return string
		 */
		public function removePSTo(string $name): string {
			return str_replace($this->FileNameGateway, '', $name);
		}
	}

?>