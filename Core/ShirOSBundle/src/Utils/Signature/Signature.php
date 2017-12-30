<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : Signature.php
	 *   @Created_at : 28/01/2017
	 *   @Update_at : 03/12/2017
	 * --------------------------------------------------------------------------
	 */

	namespace ShirOSBundle\Utils\Signature;
	use ShirOSBundle\Config;
	use ShirOSBundle\Database\Database;
	use ShirOSBundle\Model\Model;
	use ShirOSBundle\Database\Gateway\Manager;

	/**
	* Class servant a créer une news pour la page d'accueil
	* Herite de AppController
	*/

	class Signature
	{
		/**
		 * Instance de la Classe de gestion des Configs
		 * @var Config
		 */
		protected $ConfigModule;

		/**
		 * Nom de l'utilisateur
		 * @var string
		 */
		protected $name;

		/**
		 * Signature de l'utilisateur
		 * @var string
		 */
		protected $signature;
		
		
		/**
		 * Signature constructor.
		 *
		 * @param string $name
		 * @param string $signature
		 */
		public function __construct(string $name, string $signature)
		{
			$this->ConfigModule = Config::getInstance();

			$this->name = $name;
			$this->signature = $signature;
		}
		
		
		/**
		 * Modifie toute les signatures de l'utilisateur au traver d'une table
		 *
		 * @param Manager $manager
		 * @param string $oldSignatureId
		 */
		public function updateSignature(Manager $manager, string $oldSignatureId)
		{	
			$id = [
				Database::UPDATE_COLUMN => $this->ConfigModule->get('ShirOS.Database.Column.Signature_Id'),
				Database::UPDATE_VALUE  => $oldSignatureId
			];
			
			$value = [
				$this->ConfigModule->get('ShirOS.Database.Column.Signature_Id') => $this->name,
				$this->ConfigModule->get('ShirOS.Database.Column.Signature')    => $this->signature
			];

			$NewSignature = new Model($value);
			$manager->updateModel($id,$NewSignature);
		}
	}	
?>