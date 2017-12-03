<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : Authentication.php
	 *   @Created_at : 24/11/2016
	 *   @Update_at : 03/12/2017
	 * --------------------------------------------------------------------------
	 */
	
	namespace ShirOSBundle\Utils\Authentication;
	
	use ShirOSBundle\Config;
	use ShirOSBundle\Model\Model;
	use ShirOSBundle\Utils\Session\Session;
	use ShirOSBundle\Database\Gateway\Manager;

	use ShirOSBundle\Utils\Exception\LoginException;

	class Authentication
	{
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
		 * Instance d'un Manager
		 * @var Manager
		 */
		protected $manager;
		
		
		/**
		 * Authentication constructor.
		 *
		 * @param Manager|NULL $manager
		 */
		public function __construct(Manager $manager = NULL)
		{
			$this->ConfigModule = Config::getInstance();
			$this->SessionModule = Session::getInstance();
			
			if (!is_null($manager) && is_a($manager, 'ShirOSBundle\Database\Gateway\Manager')) {
				$this->manager = $manager;
			}
		}


		/* ------------------------ Fonctions Complémentaires ------------------------ */

			/**
			 * Retourne le tableau associatif contenant les informations d'authentification et de l'Utilisateur
			 *
			 * @param Model $user
			 *
			 * @return array
			 */
			protected function createAuthArray(Model $user): array
			{
				return array(
					$this->ConfigModule->get('ShirOS.Session.Id') => $user->login,
					$this->ConfigModule->get('ShirOS.Session.Name') => $user->login,
				);
			}

			/**
			 * Créer la Session de l'Utilisateur, en utilisant le Module de Session
			 *
			 * @param Model $user
			 */
			protected function createSession(Model $user)
			{
				$auth = $this->createAuthArray($user);

				/* -- Création de la Session -- */

					$this->SessionModule->authInit($auth);
			}
		

		/* ------------------------ Fonctions lier à l'utilisateur ------------------------ */

			/**
			 * Fonction permettant d'authentifier un utilisateur
			 *
			 * @param string $login
			 * @param string $password
			 *
			 * @return bool
			 *
			 * @throws LoginException
			 */
			public function login(string $login, string $password): bool
			{
				if (is_null($this->manager)) {
					throw new LoginException();
				}
				
				try {
					$user = $this->manager->getModel($this->ConfigModule->get('ShirOS.Database.Column.Auth_Login'), $login);
					
					if($user && is_a($user, 'ShirOSBundle\Model\Model')) {
						if($this->verify($password, $user->password)) {
							$this->createSession($user);
							return true;
						}
					}
				} catch (\Exception $e) {
					throw new LoginException();
				}
				
				return false;
			}


			/**
			 * Fonction permettant d'authentifier un utilisateur via un token
			 *
			 * @param string $token
			 *
			 * @return bool
			 *
			 * @throws LoginException
			 */
			public function loginWithToken(string $token): bool
			{
				if (is_null($this->manager)) {
					throw new LoginException(LoginException::AUTHENTIFICATION_TOKEN_FAILED_ERROR_CODE);
				}
				
				try {
					$user = $this->manager->getModel($this->ConfigModule->get('ShirOS.Database.Column.Auth_Login_Token'), $token);
					$login = $this->ConfigModule->get('ShirOS.Database.Column.Auth_Login');

					if($user && is_a($user, 'ShirOSBundle\Model\Model')) {
						if($token != $user->$login) {
							$this->createSession($user);

							/* -- Destruction du Token -- */
								$id = array(
									$this->ConfigModule->get('ShirOS.Database.IdIndex.Id_Column') => $this->ConfigModule->get('ShirOS.Database.Column.Auth_Login'),
									$this->ConfigModule->get('ShirOS.Database.IdIndex.Id_Value') => $user->$login
								);

								$tokenReset = array(
									$this->ConfigModule->get('ShirOS.Database.Column.Auth_Login') => $user->$login
								);

								$user = new Model($tokenReset);
								
								$this->manager->updateModel($id,$user);

							return true;
						}
					}
				} catch (\Exception $e) {
					throw new LoginException(LoginException::AUTHENTIFICATION_TOKEN_FAILED_ERROR_CODE);
				}
				
				return false;
			}


			/**
			 * Verifie si l'utilisateur est connecté
			 *
			 * @return bool
			 */
			public function logged(): bool
			{
				return $this->SessionModule->isAuthSession();
			}


			/**
			 * Déconnecte l'utilisateur
			 */
			public function logout()
			{
				/* -- Destruction de la Session -- */			
					$this->SessionModule->authDestroy();
			}
			

			/**
			 * Crypte une Donnée
			 *
			 * @param string $field
			 *
			 * @return string
			 */
			public function crypt(string $field): string
			{
				$options = [
					'cost' => $this->ConfigModule->get('ShirOS.Users.Crypt_Cost'),
				];

				return password_hash($field, PASSWORD_DEFAULT, $options);
			}
			

			/**
			 * Compare & Verify les données
			 *
			 * @param string $field
			 * @param string $fielddHash
			 *
			 * @return bool
			 */
			public function verify(string $field, string $fieldHash): bool
			{
				return password_verify($field, $fieldHash);
			}
	}
?>