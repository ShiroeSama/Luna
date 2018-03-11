<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : MetaData.php
	 *   @Created_at : 03/12/2017
	 *   @Update_at : 03/12/2017
	 * --------------------------------------------------------------------------
	 */
	
	namespace Luna\View;

	class MetaData
	{
		/**
		 * Contient le chemin du fichier des meta datas par défaut
		 * @var string
		 */
		protected $MetaDataPath = 'Config/metadata.php';

		/**
		 * Contient la route actuel
		 * @var string
		 */
		protected $route;

		/**
		 * Contient toutes les variables de MétaData
		 * @var array
		 */
		protected $metaData = [];


		/**
		 * Contient toutes les variables de MétaData
		 * @var string
		 */
		protected $title;

		/**
		 * Contient toutes les variables de MétaData
		 * @var string
		 */
		protected $description;

		/**
		 * Contient toutes les variables de MétaData
		 * @var string
		 */
		protected $keywords;
		
		
		/**
		 * MetaData constructor.
		 *
		 * @param string $route
		 * @param string|NULL $filePath
		 */
		public function __construct(string $route, string $filePath = NULL)
		{
			$this->route = $route;

			if(is_null($filePath))
				$filePath = $this->MetaDataPath;

			$this->metaData = require($filePath);

			$this->init();
		}

		protected function init()
		{			
			$this->title = (isset($this->metaData[$this->route]['Title']) ? $this->metaData[$this->route]['Title'] : '' );
			$this->description = (isset($this->metaData[$this->route]['Description']) ? $this->metaData[$this->route]['Description'] : '' );
			$this->keywords = (isset($this->metaData[$this->route]['Keywords']) ? $this->metaData[$this->route]['Keywords'] : '' );
		}
		
		
		/**
		 * Title Getter
		 *
		 * @return string
		 */
		public function getTitle(): string { return $this->title; }
		
		/**
		 * Title Setter
		 *
		 * @param string $title
		 */
		public function setTitle(string $title) { $this->title = $title; }

		/**
		 * Description Getter
		 *
		 * @return string
		 */
		public function getDescription(): string {  return $this->description; }
		
		/**
		 * Description Setter
		 *
		 * @param string $title
		 */
		public function setDescription(string $description) { $this->description = $description; }
		
		/**
		 * Keywords Getter
		 *
		 * @return string
		 */
		public function getKeywords(): string {  return $this->keywords; }
		
		/**
		 * Keywords Setter
		 *
		 * @param string $title
		 */
		public function setKeywords(string $keywords) { $this->keywords = $keywords; }


	}
?>