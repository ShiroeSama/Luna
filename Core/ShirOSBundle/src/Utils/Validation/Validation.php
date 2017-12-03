<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : Validation.php
	 *   @Created_at : 24/11/2016
	 *   @Update_at : 03/12/2017
	 * --------------------------------------------------------------------------
	 */

	namespace ShirOSBundle\Utils\Validation;

	/**
	* Controller des Validation de Champs
	*/

	class Validation
	{
		protected const PARAM_TEL = 'Phone';
		protected const PARAM_EMAIL = 'Email';
		protected const PARAM_NUMBER = 'Number';
		
		/**
		 * Regex pour les numéros de téléphone
		 * @var string
		 */
		protected $regexTel = "#^((\d{2}?){4}\d{2})$#";

		/**
		 * Regex pour les nombre
		 * @var string
		 */
		protected $regexNumber = "#^[\d\s]*$#";


		/* ------------------------ Fonctions des Tests de Champs ------------------------ */

			/**
			 * Verifie si un champ n'est pas vide
			 *
			 * @param string $field
			 *
			 * @return bool
			 */
			public function validateField(string $field): bool
			{
				/* -- Cas où le champs ne récupére qu'un nombre entre 0 et * | Evite de retourer FALSE en cas de saisie de 0 dans ce champs -- */
					if ($field == "0")
						return true;

				return !empty($field);
			}

			/**
			 * Verifie si un champ n'est pas vide
			 * Type disponible :
			 * - tel
			 * - email
			 * - number
			 *
			 * @param string $field
			 * @param string $type
			 *
			 * @return string
			 */
			public function validateFormat(string $field, string $type): string
			{
				switch ($type) {
					case $this::PARAM_TEL:
						return preg_match($this->regexTel,$field);
						break;

					case $this::PARAM_EMAIL:
						return filter_var($field, FILTER_VALIDATE_EMAIL);
						break;
						
					case $this::PARAM_NUMBER:
						return preg_match($this->regexNumber,$field);
						break;
					
					default:
						return $field;
						break;
				}
			}

			/**
			 * Verifie si le champ vaut l'une des valeurs souhaitées
			 *
			 * @param string $field
			 * @param array $value
			 *
			 * @return bool
			 */
			public function validateValue(string $field, array $value): bool { return in_array($field, $value); }

			/**
			 * Verifie si le password correspond au champ ConfirmPassword
			 *
			 * @param string $pass
			 * @param string $pass2
			 *
			 * @return bool
			 */
			public function validatePassword(string $pass, string $pass2): bool  { return $pass === $pass2; }
		
		

		/* ------------------------ Fonctions de Sanitize des Champs ------------------------ */

			/**
			 * Nettoie les Champs de Formulaires
			 *
			 * @param string $field
			 * @param string $type
			 *
			 * @return string
			 */
			public function sanitize(string $field, string $type = FILTER_SANITIZE_STRING): string { return filter_var($field, $type); }

			/**
			 * Nettoie le Champ de Recherche
			 *
			 * @param string $field
			 *
			 * @return string
			 */
			public function sanitizeSearch(string $field): string { return $this->sanitize($field, FILTER_SANITIZE_FULL_SPECIAL_CHARS); }

			/**
			 * Nettoie les Champs de Commentaires
			 *
			 * @param string $field
			 *
			 * @return string
			 */
			public function sanitizeForCommentsField(string $field): string
			{
				/* -- Suppression des Balises Js -- */
					$field = preg_replace('@<script[^>]*?>.*?</script>@si', '', $field);


				/* -- Suppression des Balises Css -- */
					$field = preg_replace('@<link [^>]*?>@si', '', $field);
					$field = preg_replace('@<style[^>]*?>.*?</style>@si', '', $field);

				/* -- Nettoyage des Signatures -- */
					$field = preg_replace('@<p class="signature">.*?</p>@si', '', $field);

				return $field;
			}
	}
?>