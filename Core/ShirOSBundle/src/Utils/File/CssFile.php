<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : CssFile.php
	 *   @Created_at : 18/12/2016
	 *   @Update_at : 03/12/2017
	 * --------------------------------------------------------------------------
	 */

	namespace ShirOSBundle\Utils\File;
	use ShirOSBundle\Config;

	class CssFile
	{
		/**
		 * Instance de la Classe de gestion des Configs
		 * @var Config
		 */
		protected $ConfigModule;

		/**
		 * Liste des Caratères Interdit
		 * @var array
		 */
		protected $prohibitedCharacter = array(
			'#',
			'/',
			'\\',
			'.'
		);

		/**
		 * Liste des Dossier Interdit
		 * @var array
		 */
		protected $prohibitedFolder = array(
			'.',
			'..',
			'Users',
			'Fonts',
			'Ancien'
		);
		
		
		/**
		 * CssFile constructor.
		 */
		public function __construct() { $this->ConfigModule = Config::getInstance(); }


		/* ------------------------ Private Function ------------------------ */

			/**
			 * Reformate le nom de fichier Css (Fichier portant le nom de l'utilisateur connecté)
			 * Exemple :
			 * - User ('Toto') => Css File ('Toto.css')
			 * - User ('Test#1111') => Css File ('Test-1111.css')
			 *
			 * @param string $username
			 *
			 * @return string
			 */
			protected function formatUsername(string $username): string
			{
				foreach ($this->prohibitedCharacter as $c)
					$username = str_replace($c, '-', $username);

				return $username;
			}

			/**
			 * Retourne le dossier Css en fonction du Rang de l'utilisateur (Pour l'édition)
			 *
			 * @param string $username
			 * @param string $folder
			 * @param bool $admin
			 *
			 * @return string
			 */
			protected function stylesheetFolderByRank(string $folder, string $username, bool $admin): string
			{
				if ($admin) {
					return $folder;
				} else {
					$folder .= "Users/";
					$fileName = $username . ".css";
					$filePath = $folder . $fileName;

					if (!is_file($filePath))
						$this->createStylesheet($filePath);

					return $folder;
				}
			}

			/**
			 * Créer une feuille de style
			 *
			 * @param string $file
			 */
			protected function createStylesheet(string $file)
			{
				$flux = @fopen("{$file}","w");

				$html  = "/* ---- Construire vos balises ---- */\n";
				$html .= "/* .votreUsername-nomDeVotreBalise  */\n";
				$html .= "/* ---- END Construire vos balises ---- */\n";

				fwrite($flux,$html);
				fclose($flux);

				chmod($file, 0664);
			}

			/**
			 * Vérifie l'accès à un l'édition ou la lecture d'une feuille de style
			 *
			 * @param string $fileName
			 * @param string $username
			 * @param bool $admin
			 *
			 * @return bool
			 */
			protected function validAccess(string $fileName, string $username, bool $admin): bool { return ($admin ? true : (str_replace(".css", '', $fileName) == $username)); }


		/* ------------------------ Public Function ------------------------ */

			/**
			 * Retourne la liste des feuilles de style
			 *
			 * @param string $folder
			 * @param string $username
			 * @param bool $admin
			 *
			 * @return array
			 */
			public function getStylesheets(string $folder, string $username, bool $admin): array
			{
				$stylesheets = array();
				$username = $this->formatUsername($username);
	
				$folder = $this->stylesheetFolderByRank($folder, $username, $admin);
				$stylesheetsFolder = scandir($folder);

				if ($admin) {
					foreach ($stylesheetsFolder as $stylesheet) {
						if(in_array($stylesheet, $this->prohibitedFolder))
							continue;

						array_push($stylesheets, $stylesheet);
					}
				} else {
					$stylesheet = $username . '.css';
					array_push($stylesheets, $stylesheet);
				}
				
				return $stylesheets;
			}
		
			/**
			 * Retourne le contenu d'un feuille de style
			 *
			 * @param string $folder
			 * @param string $fileName
			 * @param string $username
			 * @param bool $admin
			 *
			 * @return null|string
			 */
			public function getStylesheet(string $folder, string $fileName, string $username, bool $admin): ?string
			{
				$username = $this->formatUsername($username);
				$folder = $this->stylesheetFolderByRank($folder, $username, $admin);
				$file = $folder . $fileName;

				$access = $this->validAccess($fileName, $username, $admin);
			
				if (is_file($file) && $access)
					return $file;
				else 
					return NULL;
			}

			/**
			 * Revoie si l'utilisateur à accès ou non à la feuille de style
			 *
			 * @param string $folder
			 * @param string $fileName
			 * @param string $username
			 * @param bool $admin
			 *
			 * @return bool
			 */
			public function showStylesheet(string $folder, string $fileName, string $username, bool $admin): bool
			{
				$username = $this->formatUsername($username);
				$folder = $this->stylesheetFolderByRank($folder, $username, $admin);
				$file = $folder . $fileName;

				$access = $this->validAccess($fileName, $username, $admin);

				return (is_file($file) && $access);
			}

			/**
			 * Permet l'edition d'une feuille de style
			 *
			 * @param string $folder
			 * @param string $fileName
			 * @param string $content
			 * @param string $username
			 * @param bool $admin
			 *
			 * @return bool
			 */
			public function editStylesheet(string $folder, string $fileName, string $content, string $username, bool $admin): bool
			{	
				$username = $this->formatUsername($username);			
				$folder = $this->stylesheetFolderByRank($folder, $username, $admin);
				$file = $folder . $fileName;

				$access = $this->validAccess($fileName, $username, $admin);

				if (is_file($file) && $access) {
					$flux = @fopen("{$file}","w");

					if ($flux) {
						fwrite($flux,"{$content}");
						fclose($flux);
						return true;
					} else
						return false;
				} else
					return false;
			}
	}
?>