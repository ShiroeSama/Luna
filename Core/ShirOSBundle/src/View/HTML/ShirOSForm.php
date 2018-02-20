<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : ShirOSForm.php
	 *   @Created_at : 24/11/2016
	 *   @Update_at : 03/12/2017
	 * --------------------------------------------------------------------------
	 */

	namespace ShirOSBundle\View\HTML;

	use ShirOSBundle\Config;

	class ShirOSForm
	{
		/**
		 * Instance de la Classe de gestion des Configs
		 * @var Config
		 */
		protected $ConfigModule;
		
		/**
		 * Données utilisées pas le formulaire
		 * @var array
		 */
		protected $data;
		
		
		/**
		 * ShirOSForm constructor.
		 *
		 * @param mixed $data | Default Value = []
		 */
		public function __construct($data = [])
		{
			$this->ConfigModule = Config::getInstance();
			$this->data = $data;
		}

		/* ------------------------ Private Function ------------------------ */
		
			/**
			 * Récupère une valeur dans les données du formulaire
			 *
			 * @param string $index
			 *
			 * @return string|null
			 */
			protected function getValue(string $index): ?string
			{
				if(is_object($this->data)){
					return $this->data->$index;
				} elseif (isset($this->data[$index])){
					return $this->data[$index];
				} else {
					return NULL;
				}
			}

			/**
			 * Entoure / Encapsule du contenu HTML
			 *
			 * @param string $html
			 * @param string $balise | Default Value = NULL
			 *
			 * @return string
			 */
			protected function surround(string $html, string $balise = NULL): string
			{
				if($balise != NULL) {
					$baliseEnd = preg_replace('# class[^>]*?$#', '', $balise);
					$baliseEnd = preg_replace('# style[^>]*?$#', '', $baliseEnd);
					return "<{$balise}>{$html}</{$baliseEnd}>";
				} else {
					return $html;
				}
			}

			/**
			 * Récupère le Type de la balise
			 *
			 * @param array $options
			 *
			 * @return string
			 */
			protected function getType(array $options): string
			{
				if(isset($options['type']))
					return $options['type'];
				else
					return 'text';
			}

			/**
			 * Récupère la classe css à appliquer sur la balise
			 *
			 * @param array $options
			 * @param bool $error | Default Value = false
			 *
			 * @return string
			 */
			protected function getClass(array $options, bool $error = false): string
			{
				$error ? $error = 'formError' : $error = '';
				isset($options['class']) ? $class = $options['class'] . ' ' . $error : $class = $error;
				empty($class) ? $class = '' : $class = 'class="' . $class . '"';

				return $class;
			}

			/**
			 * Vérifie si la 'Checkbox' est cochée ou non
			 *
			 * @param string $name
			 * @param array $options
			 *
			 * @return bool
			 */
			protected function isChecked(string $name, array $options): bool
			{
				if(isset($options['checkedList'])) {
					$checkedList = $options['checkedList'];

					if (is_array($checkedList)) {
						foreach ($checkedList as $key => $value)
							if($value === $name)
								return true;
					} else if (is_string($checkedList)) {
						return $checkedList === $name;
					}					
				}

				return false;
			}

            /**
             * Vérifie si la balise à un id
             *
             * @param array $options
             *
             * @return bool|mixed
             */
			protected function hasId(array $options)
			{
				if(isset($options['id']) && !empty($options['id']))
					return $options['id'];
				return false;
			}

			/**
			 * Récupère la/les classes css pour former un bouton
			 *
			 * @param array $options
			 *
			 * @return string
			 */
			protected function getClassButton(array $options): string
			{
				if(isset($options['class'])) {
					$options['class'] = 'btn btn-primary ' . $options['class'];
 					return $this->getClass($options);
				} else
					return 'class="btn btn-primary"';
			}

			/**
			 * Récupère l'entourage/l'encapsulation de la balise
			 *
			 * @param array $options
			 *
			 * @return string|null
			 */
			protected function getSurround(array $options): ?string
			{
				if (!isset($options['surround_type']) && !isset($options['surround'])) {
					$surround = NULL;
				} else {
					isset($options['surround_type']) ? $type = $options['surround_type'] : $type = 'div';
					isset($options['surround']) ? $surround = $type . ' class="' . $options['surround'] . '"' : $surround = $type;
				}

				return $surround;
			}

			/**
			 * Récupère le placeholde de la balise
			 *
			 * @param string $name
			 * @param array $options
			 *
			 * @return string
			 */
			protected function getPlaceholder(string $name, array $options): string
			{
				if(isset($options['placeholder']))
					return $options['placeholder'];
				else
					return $name;
			}




		/* ------------------------ Public Function ------------------------ */

			/**
			 * Génére la balise 'input'
			 *
			 * @param string $name
			 * @param array $options | Default Value = []
			 * @param bool $error | Default Value = false
			 *
			 * @return string
			 */
			public function input(string $name, array $options = [], $error = false): string
			{
				/* Traitement du type d'input */

					$type = $this->getType($options);
					$class = $this->getClass($options, $error);
					$surround = $this->getSurround($options);
					$placeholder = $this->getPlaceholder($name, $options);

				/* Format de l'input */

					if($type === 'textarea')
						$input = "<textarea {$class} name=\"{$name}\" placeholder=\"{$placeholder}\">{$this->getValue($name)}</textarea>";
					else if($type === 'checkbox') {
						$attribute = '';

						if($this->isChecked($name, $options))
							$attribute = 'checked="checked"';

						$id = $this->hasId($options);
						if ($id) $input = "<input type=\"{$type}\" {$class} id=\"{$name}\" name=\"{$id}\" value=\"{$name}\" {$attribute}/><label for=\"{$name}\">" . $placeholder . "</label>";
						else $input = "<input type=\"{$type}\" {$class} id=\"{$name}\" name=\"{$name}\" value=\"{$name}\" {$attribute}/><label for=\"{$name}\">" . $placeholder . "</label>";

					} else if($type === 'radio') {
						$attribute = '';
						
						$id = $this->hasId($options);
						if ($id) {
							if($this->isChecked($name, $options))
								$attribute = 'checked';

							$input = "<input type=\"{$type}\" {$class} id=\"{$name}\" name=\"{$id}\" value=\"{$name}\" {$attribute}/><label for=\"{$name}\">" . $placeholder . "</label>";
						} else $input = "<input type=\"{$type}\" {$class} id=\"{$name}\" name=\"{$name}\" value=\"{$name}\" {$attribute}/><label for=\"{$name}\">" . $placeholder . "</label>";
						
					} else if($type === 'search')
						$input = "<input type=\"{$type}\" {$class} name=\"{$name}\" placeholder=\"{$placeholder}\" value=\"{$this->getValue($name)}\" />";
					else if($type === 'submit')
						$input =  "<input type=\"{$type}\" {$class} name=\"Stylesheet\" value=\"{$name}\" />";
					else
						$input = "<input type=\"{$type}\" {$class} name=\"{$name}\" placeholder=\"{$placeholder}\" value=\"{$this->getValue($name)}\" />";

				return $this->surround($input, $surround);
			}


			/**
			 * Génére la balise 'select'
			 *
			 * @param string $name
			 * @param array $items
			 * @param array $options | Default Value = []
			 *
			 * @return string
			 */
			public function select(string $name, array $items, array $options = []): string
			{
				/* Traitement des options */

					$class = $this->getClass($options);
					$surround = $this->getSurround($options);

				/* Format du Select */

					$input = "<select {$class} name=\"{$name}\">";

					foreach ($items as $key => $value) {
						$attributes = '';
						
						if($key == $this->getValue($name))
							$attributes = ' selected';

						$input .= "<option value='$key'$attributes>$value</option>";
					}

					$input .= '</select>';

				return $this->surround($input, $surround);
			}


			/**
			 * Génére le bouton 'submit'
			 *
			 * @param string $btn_name
			 * @param array $options | Default Value = []
			 *
			 * @return string
			 */
			public function submit(string $btn_name, array $options = []): string
			{
				/* Traitement des options */

					$class = $this->getClassButton($options);
					$surround = $this->getSurround($options);

				/* Format du Submit */

					switch ($btn_name) {
						case $this->ConfigModule->get('Login_Button'):
							$glyphicon = "<span class=\"glyphicon glyphicon-log-in\"></span>";
							break;

						case $this->ConfigModule->get('Logout_Button'):
							$glyphicon = "<span class=\"glyphicon glyphicon-log-out\"></span>";
							break;
						
						default:
							$glyphicon = '';
							break;
					}
					
					return $this->surround("<button type=\"submit\" {$class}>{$glyphicon} {$btn_name} </button>", $surround);
			}


			/**
			 * Génére le bouton 'submit' avec un id
			 *
			 * @param string $btn_name
			 * @param string $name
			 * @param string $value | Default Value = NULL
			 * @param array $options | Default Value = []
			 *
			 * @return string
			 */
			public function submitWithId(string $btn_name, string $name, string $value = NULL, array $options = []): string
			{
				/* Traitement des options */

					$class = $this->getClassButton($options);
					$surround = $this->getSurround($options);

				/* Format du Submit avec ID */

					switch ($btn_name) {
						case $this->ConfigModule->get('Login_Button'):
							$glyphicon = "<span class=\"glyphicon glyphicon-log-in\"></span>";
							break;

						case $this->ConfigModule->get('Logout_Button'):
							$glyphicon = "<span class=\"glyphicon glyphicon-log-out\"></span>";
							break;
						
						default:
							$glyphicon = '';
							break;
					}

					if(is_null($value) || empty($value))
						return $this->surround("<button type=\"submit\" name=\"{$name}\" value=\"{$btn_name}\" {$class}>{$glyphicon} {$btn_name} </button>", $surround);
					else
						return $this->surround("<button type=\"submit\" name=\"{$name}\" value=\"{$value}\" {$class}>{$glyphicon} {$btn_name} </button>", $surround);
			}
	}
?>