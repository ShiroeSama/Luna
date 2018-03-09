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
		/* ---- CONSTANTE ---- */
		
		protected const ERROR_CLASS = 'formError';
		
		public const OPTIONS_SURROUND_TYPE = 'Surround_Type';
		public const OPTIONS_SURROUND = 'Surround';
		
		
		/* ---- ATTRIBUTS ---- */
		
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
		
		/**
		 * Récupère une valeur dans les données du formulaire
		 *
		 * @param string $index
		 *
		 * @return string|null
		 */
		protected function getValue(string $index): ?string
		{
			if(is_object($this->data)){ return $this->data->$index; }
			elseif (isset($this->data[$index])){ return $this->data[$index]; }
			else { return NULL; }
		}
		
		
		
		/* ------------------------ Generate Fields Function ------------------------ */
		
			/**
			 * INPUT (Text)
			 *
			 * @param string $id
			 * @param string|null $placeholder
			 * @param string|null $class
			 * @param array $surroundOptions
			 * @param bool $error
			 *
			 * @return string
			 */
			public function input(string $type, string $id, ?string $placeholder = NULL, ?string $class = NULL, array $surroundOptions = [], $error = false): string
			{
				/* Traitement du type d'input */
				
					$class = $this->getClass($class, $error);
					$placeholder = $this->getPlaceholder($id, $placeholder);
				
				/* Format de l'input */
				
					$input = "<input type='{$type}' {$class} name=\"{$id}\" placeholder=\"{$placeholder}\" value=\"{$this->getValue($id)}\" />";
				
				return $this->surround($input, $surroundOptions);
			}
			
			/**
			 * INPUT (Text)
			 *
			 * @param string $id
			 * @param string|null $placeholder
			 * @param string|null $class
			 * @param array $surroundOptions
			 * @param bool $error
			 *
			 * @return string
			 */
			public function field(string $id, ?string $placeholder = NULL, ?string $class = NULL, array $surroundOptions = [], $error = false): string
			{
				return $this->input('text', $id, $placeholder, $class, $surroundOptions, $error);
			}
			
			/**
			 * INPUT (Password)
			 *
			 * @param string $id
			 * @param string|null $placeholder
			 * @param string|null $class
			 * @param array $surroundOptions
			 * @param bool $error
			 *
			 * @return string
			 */
			public function password(string $id, ?string $placeholder = NULL, ?string $class = NULL, array $surroundOptions = [], $error = false): string
			{
				return $this->input('password', $id, $placeholder, $class, $surroundOptions, $error);
			}
		
			/**
			 * INPUT (Search)
			 *
			 * @param string $id
			 * @param string|null $placeholder
			 * @param string|null $class
			 * @param array $surroundOptions
			 * @param bool $error
			 *
			 * @return string
			 */
			public function search(string $id, ?string $placeholder = NULL, ?string $class = NULL, array $surroundOptions = [], $error = false): string
			{
				return $this->input('search', $id, $placeholder, $class, $surroundOptions, $error);
			}

            /**
             * INPUT (EMAIL)
             *
             * @param string $id
             * @param string|null $placeholder
             * @param string|null $class
             * @param array $surroundOptions
             * @param bool $error
             *
             * @return string
             */
            public function email(string $id, ?string $placeholder = NULL, ?string $class = NULL, array $surroundOptions = [], $error = false): string
            {
                return $this->input('email', $id, $placeholder, $class, $surroundOptions, $error);
            }
			
			/**
			 * TEXTAREA
			 *
			 * @param string $id
			 * @param string|null $placeholder
			 * @param string|null $class
			 * @param array $surroundOptions
			 * @param bool $error
			 *
			 * @return string
			 */
			public function textarea(string $id, ?string $placeholder = NULL, ?string $class = NULL, array $surroundOptions = [], $error = false): string
			{
				/* Traitement du type d'input */
				
					$class = $this->getClass($class, $error);
					$placeholder = $this->getPlaceholder($id, $placeholder);
				
				/* Format de l'input */
				
					$input = "<textarea {$class} name=\"{$id}\" placeholder=\"{$placeholder}\">{$this->getValue($id)}</textarea>";
				
				return $this->surround($input, $surroundOptions);
			}
			
			/**
			 * INPUT (Checkbox)
			 *
			 * @param string $id
			 * @param string $value
			 * @param mixed $checkedList
			 * @param string|null $placeholder
			 * @param string|null $class
			 * @param array $surroundOptions
			 *
			 * @return string
			 */
			public function checkbox(string $id, string $value, $checkedList, ?string $placeholder = NULL, ?string $class = NULL, array $surroundOptions = []): string
			{
				/* Traitement du type d'input */
				
				$checked = '';
				$class = $this->getClass($class);
				$placeholder = $this->getPlaceholder($id, $placeholder);
				
				if($this->isChecked($value, $checkedList)) {
					$checked = 'checked="checked"';
				}
				
				/* Format de l'input */
				
				$input = "<input type='checkbox' {$class} id=\"{$id}\" name=\"{$id}\" value=\"{$value}\" {$checked}/><label for=\"{$id}\">{$placeholder}</label>";
				
				return $this->surround($input, $surroundOptions);
			}
			
			/**
			 * INPUT (Radio)
			 *
			 * @param string $id
			 * @param string $value
			 * @param string $checkedValue
			 * @param string|null $placeholder
			 * @param string|null $class
			 * @param array $surroundOptions
			 *
			 * @return string
			 */
			public function radio(string $id, string $value, string $checkedValue, ?string $placeholder = NULL, ?string $class = NULL, array $surroundOptions = []): string
			{
				/* Traitement du type d'input */
				
					$checked = '';
					$class = $this->getClass($class);
					$placeholder = $this->getPlaceholder($id, $placeholder);
				
					if($this->isChecked($value, $checkedValue)) {
						$checked = 'checked';
					}
				
				/* Format de l'input */
				
					$input = "<input type='radio' {$class} id=\"{$id}\" name=\"{$id}\" value=\"{$value}\" {$checked}/><label for=\"{$id}\">{$placeholder}</label>";
				
				return $this->surround($input, $surroundOptions);
			}
		
			/**
			 * SELECT
			 *
			 * @param string $id
			 * @param array $items
			 * @param null|string $class
			 * @param array $surroundOptions
			 *
			 * @return string
			 */
			public function select(string $id, array $items, ?string $class = NULL, array $surroundOptions = []): string
			{
				/* Traitement des options */
				
				$class = $this->getClass($class);
				
				/* Format du Select */
				
				$input = "<select {$class} name='{$id}'>";
				
				foreach ($items as $key => $value) {
					$selected = '';
					
					if($key == $this->getValue($id))
						$selected = 'selected';
					
					$input .= "<option value='{$key}' {$selected}>{$value}</option>";
				}
				
				$input .= '</select>';
				
				return $this->surround($input, $surroundOptions);
			}
		
			/**
			 * SUBMIT
			 *
			 * @param string $name
			 * @param null|string $class
			 * @param array $surroundOptions
			 *
			 * @return string
			 */
			public function submit(string $name, ?string $class = NULL, array $surroundOptions = []): string
			{
				return $this->getSubmitButton(NULL, $name, NULL, $class, $surroundOptions);
			}
			
			/**
			 * SUBMIT
			 *
			 * @param string $id
			 * @param string $name
			 * @param null|string $class
			 * @param array $surroundOptions
			 *
			 * @return string
			 */
			public function submitWithId(string $id, string $name, ?string $value, ?string $class, array $surroundOptions = []): string
			{
				return $this->getSubmitButton($id, $name, $value, $class, $surroundOptions);
			}
		
			
		
		/* ------------------------ Render Function ------------------------ */

			/**
			 * SURROUND
			 *
			 * @param string $html
			 * @param string $balise | Default Value = NULL
			 *
			 * @return string
			 */
			protected function surround(string $html, array $surroundOptions = []): string
			{
				if (!key_exists(self::OPTIONS_SURROUND_TYPE, $surroundOptions)
					&& !key_exists(self::OPTIONS_SURROUND, $surroundOptions)) {
					return $html;
				}
				
				$surroundType = 'div';
				if (key_exists(self::OPTIONS_SURROUND_TYPE, $surroundOptions)) {
					$surroundType = $surroundOptions[self::OPTIONS_SURROUND_TYPE];
				}
				
				$tag = $surroundType;
				$tagEnd = $surroundType;
				
				if (key_exists(self::OPTIONS_SURROUND, $surroundOptions)) {
					$tag .= ' class="' . $surroundOptions[self::OPTIONS_SURROUND] . '"';
				}
				
				return "<{$tag}>{$html}</{$tagEnd}>";
			}
		
			/**
			 * SUBMIT BUTTON
			 *
			 * @param string $id
			 * @param string $name
			 * @param null|string $class
			 * @param array $surroundOptions
			 *
			 * @return string
			 */
			public function getSubmitButton(?string $id, string $name, ?string $value, ?string $class, array $surroundOptions = []): string
			{
				/* Traitement des options */
				
				$class = $this->getClassButton($class);
				
				/* Format du Submit */
				
				switch ($name) {
					case $this->ConfigModule->get('Login_Button'):
						$glyphicon = "<span class='glyphicon glyphicon-log-in' /> ";
						break;
					
					case $this->ConfigModule->get('Logout_Button'):
						$glyphicon = "<span class='glyphicon glyphicon-log-out' /> ";
						break;
					
					default:
						$glyphicon = '';
						break;
				}
				
				if (is_null($id)) {
					$button = "<button type='submit' {$class}>{$glyphicon}{$name}</button>";
				} else {
					if (is_null($value)) { $value = $name; }
					$button = "<button type='submit' name=\"{$id}\" value=\"{$value}\" {$class}>{$glyphicon}{$name}</button>";
				}
				
				return $this->surround($button, $surroundOptions);
			}
		
			
		
		/* ------------------------ Treatment Function ------------------------ */
		
			/**
			 * Récupère la classe css à appliquer sur la balise
			 *
			 * @param null|string $class
			 * @param bool $error
			 *
			 * @return string
			 */
			protected function getClass(?string $class, bool $error = false): string
			{
				$firstClassElement = true;
				$classAttribute = '';
				
				if (!is_null($class)) {
					if ($firstClassElement) {
						$classAttribute = 'class="' . $class;
						$firstClassElement = false;
					} else {
						$classAttribute .= " {$class}";
					}
				}
				
				if ($error) {
					if ($firstClassElement) {
						$classAttribute = 'class="' . self::ERROR_CLASS;
						$firstClassElement = false;
					} else {
						$classAttribute .= ' ' . self::ERROR_CLASS;
					}
				}
				
				return ((empty($classAttribute)) ? '' : $classAttribute . '"');
			}
		
			/**
			 * Récupère la/les classes css pour former un bouton
			 *
			 * @param null|string $class
			 *
			 * @return string
			 */
			protected function getClassButton(?string $class): string
			{
				$class = ((is_null($class)) ? 'btn btn-primary' : 'btn btn-primary ' . $class);
				return $this->getClass($class);
			}
			
			/**
			 * Récupère le placeholde de la balise
			 *
			 * @param string $name
			 * @param null|string $placeholder
			 *
			 * @return string
			 */
			protected function getPlaceholder(string $name, ?string $placeholder): string { return ((is_null($placeholder)) ? $name : $placeholder); }
			
			/**
			 * Vérifie si la 'Checkbox' est cochée ou non
			 *
			 * @param string $name
			 * @param mixed $checkedList
			 *
			 * @return bool
			 */
			protected function isChecked(string $name, $checkedList): bool
			{
				if (is_array($checkedList)) {
					foreach ($checkedList as $key => $value)
						if($value === $name)
							return true;
				} else if (is_string($checkedList)) {
					return $checkedList === $name;
				}
				
				return false;
			}
	}
?>