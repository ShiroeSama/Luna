<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : Url.php
	 *   @Created_at : 03/12/2017
	 *   @Update_at : 03/12/2017
	 * --------------------------------------------------------------------------
	 */
	
	namespace ShirOSBundle\Utils\Url;
	
	class Url
	{
		/**
		 * Contient l'url de la page d'accueil
		 * @var string
		 */
		protected $homeUrl;
		
		/**
		 * Url constructor.
		 *
		 * @param string $homeUrl
		 */
		public function __construct(string $homeUrl) { $this->homeUrl= $homeUrl; }

		/**
		 * Vérifie que la valeur en paramètre est dans l'énumeration
		 *
		 * @param String $url | Default Value = ''
		 *
		 * @return string
		 */
		public function getUrl(string $url = NULL): string
		{
			if (is_null($url)) {
				return $this->homeUrl;
			} else {
				$url = explode('.', $url);
				if (is_array($url)) { $url = implode('/', $url); }
				return $this->homeUrl . '/' . $url;
			}
		}
	}
?>