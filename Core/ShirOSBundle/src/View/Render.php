<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : Render.php
	 *   @Created_at : 03/12/2017
	 *   @Update_at : 03/12/2017
	 * --------------------------------------------------------------------------
	 */
	
	namespace ShirOSBundle\View;
	use ShirOSBundle\Config;
	use ShirOSBundle\Utils\HTTP\HTTP;
	use ShirOSBundle\ApplicationService;
	use ShirOSBundle\Utils\Session\Session;
	
	class Render
	{
		/**
		 * Instance de la Classe de gestion des Configs
		 * @var ApplicationService
		 */
		protected $ApplicationModule;

		/**
		 * Instance de la Classe de gestion des Configs
		 * @var Config
		 */
		protected $ConfigModule;

		/**
		 * Instance de la Classe de gestion des Sessions
		 * @var Session
		 */
		protected $SessionModule;

		/**
		 * Contient le chemin du dossier contenant les vues
		 * @var string
		 */
		protected $viewPath;

		/**
		 * Contient le chemin du dossier contenant les vues d'erreurs
		 * @var string
		 */
		protected $errorViewPath;

		/**
		 * Contient le chemin du dossier contenant les vues d'erreurs du bundle
		 * @var string
		 */
		protected $bundleErrorViewPath;

		/**
		 * Contient le chemin du dossier contenant les templates
		 * @var string
		 */
		protected $templatePath;

		/**
		 * Nom du fichier template pour l'en-tête de page
		 * @var string
		 */
		protected $templateHeader;

		/**
		 * Nom du fichier template pour le pieds de page
		 * @var string
		 */
		protected $templateFooter;
		
		/**
		 * Render constructor.
		 */
		public function __construct()
		{
			$this->ApplicationModule = ApplicationService::getInstance();
			$this->ConfigModule = Config::getInstance();
			$this->SessionModule = Session::getInstance();

			$this->viewPath =  $this->ConfigModule->get('ShirOS.Path.View');
			$this->errorViewPath = $this->ConfigModule->get('ShirOS.Path.Error');
			$this->bundleErrorViewPath = SHIROS_ROOT . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'Errors';
			$this->templatePath = $this->ConfigModule->get('ShirOS.Path.Template');
			$this->templateHeader = $this->ConfigModule->get('ShirOS.Name.File.Template.Header');
			$this->templateFooter = $this->ConfigModule->get('ShirOS.Name.File.Template.Footer');
		}


		/* ------------------------ View ------------------------ */

			/**
			 * Rend la View correspondant a celle demander en paramètre
			 *
			 * @param string $view
			 * @param array $variables | Default Value = []
			 * @param int $code | Default Value = HTTP::OK
			 */
			public function show(string $view, array $variables = [], int $code = HTTP::OK)
			{
				HTTP::generateHeader($code);

				$variables['ConfigModule'] = $this->ConfigModule;
				$variables['SessionModule'] = $this->SessionModule;

				extract($variables);

				require ($this->templatePath . DIRECTORY_SEPARATOR . $this->templateHeader . '.php');
				require ($this->viewPath . DIRECTORY_SEPARATOR . str_replace('.', DIRECTORY_SEPARATOR, $view) . '.php');
				require ($this->templatePath . DIRECTORY_SEPARATOR . $this->templateFooter . '.php');
			}

			/**
			 * Permet l'inclusion d'une vue
			 *
			 * @param string $view
			 * @param array $variables | Default Value = []
			 */
			public function include(string $view, array $variables = [])
			{
				$variables['ConfigModule'] = $this->ConfigModule;
				$variables['SessionModule'] = $this->SessionModule;
				extract($variables);

				require ($this->viewPath . DIRECTORY_SEPARATOR . str_replace('.', DIRECTORY_SEPARATOR, $view) . '.php');
			}	

			/**
			 * Fonction appelant la page Forbidden (403)
			 *
			 * @param string $message | Default Value = NULL
			 */
			public function forbidden(string $message = NULL)
			{
				HTTP::generateHeader(HTTP::FORBIDDEN);

				$ApplicationModule = $this->ApplicationModule;
				$ConfigModule = $this->ConfigModule;

				$error = HTTP::getName(HTTP::FORBIDDEN);
				if(!is_null($message)) { $error = $message; }

				$view = $this->ConfigModule->get('ShirOS.Name.File.Error.Forbidden');
				$fileUser = $this->errorViewPath . DIRECTORY_SEPARATOR . str_replace('.', DIRECTORY_SEPARATOR, $view) . '.php';
				$fileBundle = $this->bundleErrorViewPath . DIRECTORY_SEPARATOR . str_replace('.', DIRECTORY_SEPARATOR, $view) . '.php';

				require (file_exists($fileUser) ? $fileUser : $fileBundle);
			}

			/**
			 * Fonction appelant la page NotFound (404)
			 *
			 * @param string $message | Default Value = NULL
			 */
			public function notFound(string $message = NULL)
			{
				HTTP::generateHeader(HTTP::NOT_FOUND);

				$ApplicationModule = $this->ApplicationModule;
				$ConfigModule = $this->ConfigModule;

				$error = HTTP::getName(HTTP::NOT_FOUND);
				if(!is_null($message)) { $error = $message; }

				$view = $this->ConfigModule->get('ShirOS.Name.File.Error.NotFound');
				$fileUser = $this->errorViewPath . DIRECTORY_SEPARATOR . str_replace('.', DIRECTORY_SEPARATOR, $view) . '.php';
				$fileBundle = $this->bundleErrorViewPath . DIRECTORY_SEPARATOR . str_replace('.', DIRECTORY_SEPARATOR, $view) . '.php';
				
				require (file_exists($fileUser) ? $fileUser : $fileBundle);
			}

			/**
			 * Fonction appelant la page InternalServerError (500)
			 *
			 * @param string $message | Default Value = NULL
			 */
			public function internalServerError(string $message = NULL)
			{
				HTTP::generateHeader(HTTP::INTERNAL_SERVER_ERROR);

				$ApplicationModule = $this->ApplicationModule;
				$ConfigModule = $this->ConfigModule;

				$error = HTTP::getName(HTTP::INTERNAL_SERVER_ERROR);
				if(!is_null($message)) { $error = $message; }

				$view = $this->ConfigModule->get('ShirOS.Name.File.Error.InternalServerError');
				$fileUser = $this->errorViewPath . DIRECTORY_SEPARATOR . str_replace('.', DIRECTORY_SEPARATOR, $view) . '.php';
				$fileBundle = $this->bundleErrorViewPath . DIRECTORY_SEPARATOR . str_replace('.', DIRECTORY_SEPARATOR, $view) . '.php';

				require (file_exists($fileUser) ? $fileUser : $fileBundle);
			}

			/**
			 * Fonction appelant une page d'erreur avec un header HTTP approprié.
			 *
			 * @param int $code
			 * @param string $message | Default Value = NULL
			 */
			public function error(int $code, string $message = NULL)
			{
				HTTP::generateHeader($code);

				$ApplicationModule = $this->ApplicationModule;
				$ConfigModule = $this->ConfigModule;
				$codeName = HTTP::getName($code);
				
				$error = "Error.";
				if(!is_null($message)) { $error = $message; }

				$view = $this->ConfigModule->get('ShirOS.Name.File.Error.OtherError');
				$fileUser = $this->errorViewPath . DIRECTORY_SEPARATOR . str_replace('.', DIRECTORY_SEPARATOR, $view) . '.php';
				$fileBundle = $this->bundleErrorViewPath . DIRECTORY_SEPARATOR . str_replace('.', DIRECTORY_SEPARATOR, $view) . '.php';

				require (file_exists($fileUser) ? $fileUser : $fileBundle);
			}
		}
?>