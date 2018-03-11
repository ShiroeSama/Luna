<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : VideoFile.php
	 *   @Created_at : 18/12/2016
	 *   @Update_at : 03/12/2017
	 * --------------------------------------------------------------------------
	 */

	namespace Luna\Utils\File;

	/**
	* Génére un fichier Css pour un Utilisateur
	*/

	class VideoFile
	{
		/**
		 * Liste des Dossier Interdit
		 * @var Array
		 */
		protected $prohibitedFolder = array(
			'.',
			'..',
			'- Divers -'
		);

		/**
		 * Regex pour les Saisons
		 * @var String
		 */
		protected $regexSaison = "#^Saison#";

		/**
		 * Regex pour les Films
		 * @var String
		 */
		protected $regexFilm = "#^Films#";

		/**
		 * Regex pour les OAV
		 * @var String
		 */
		protected $regexOAV = "#^OAV#";

		/**
		 * Regex pour les Episodes Spéciaux
		 * @var String
		 */
		protected $regexEpSpecial = "#^Spéciaux#";


		/* ------------------------ Private Function ------------------------ */

			/**
			 * Récupèrer les fichiers vidéos contenu dans un dossier
			 *
			 * @param String $rootFolder
			 * @param Array $folderName
			 *
			 * @return Array
			 */
			protected function getMovies(String $rootFolder, Array $folderName) {
				$folder = array();
				$movies = array();

				foreach ($folderName as $name) {
					$path = $rootFolder . '/' . $name;
					$moviesFolder = scandir($path);

					foreach ($moviesFolder as $movie) {
						if(in_array($movie, $this->prohibitedFolder))
							continue;

						//$movie = str_replace('.mp4', '', $movie);
						array_push($movies, $movie);
					}

					$movies = array(
						'numberOfMovies' => sizeof(glob($path . "/*.*")),
						'movies' => $movies
					);

					$folder[$name] = $movies;
				}
				
				return $folder;
			}



		/* ------------------------ Public Function ------------------------ */

			/**
			 * Récupèrer les épisodes pour les différentes saisons d'une serie
			 *
			 * @param String $rootFolder
			 *
			 * @return Array
			 */
			public function getSaison(String $rootFolder)
			{
				$mangaForlder = scandir($rootFolder);
				$folderName = array();

				foreach ($mangaForlder as $name) {
					if(in_array($name, $this->prohibitedFolder) || !preg_match($this->regexSaison, $name))
						continue;

					array_push($folderName, $name);
				}

				return $this->getMovies($rootFolder, $folderName);
			}


			/**
			 * Récupèrer les films
			 *
			 * @param String $rootFolder
			 *
			 * @return Array
			 */
			public function getFilms(String $rootFolder)
			{
				$mangaForlder = scandir($rootFolder);
				$folderName = array();

				foreach ($mangaForlder as $name) {
					if(in_array($name, $this->prohibitedFolder) || !preg_match($this->regexFilm, $name))
						continue;

					array_push($folderName, $name);
				}

				return $this->getMovies($rootFolder, $folderName);
			}


			/**
			 * Récupèrer les OAV (Episode Bonus) d'une série
			 *
			 * @param String $rootFolder
			 *
			 * @return Array
			 */
			public function getOAV(String $rootFolder)
			{
				$mangaForlder = scandir($rootFolder);
				$folderName = array();

				foreach ($mangaForlder as $name) {
					if(in_array($name, $this->prohibitedFolder) || !preg_match($this->regexOAV, $name))
						continue;

					array_push($folderName, $name);
				}

				return $this->getMovies($rootFolder, $folderName);
			}


			/**
			 * Récupèrer les episodes spéciaux d'une série
			 *
			 * @param String $rootFolder
			 *
			 * @return Array
			 */
			public function getSpeciaux(String $rootFolder)
			{
				$mangaForlder = scandir($rootFolder);
				$folderName = array();

				foreach ($mangaForlder as $name) {
					if(in_array($name, $this->prohibitedFolder) || !preg_match($this->regexEpSpecial, $name))
						continue;

					array_push($folderName, $name);
				}

				return $this->getMovies($rootFolder, $folderName);
			}
	}
?>