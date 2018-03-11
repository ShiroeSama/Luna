<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : Mailer.php
	 *   @Created_at : 09/04/2017
	 *   @Update_at : 03/12/2017
	 * --------------------------------------------------------------------------
	 */

	namespace Luna\Utils\Mail;

	use Luna\Config;
	
	class Mailer
	{
		/**
		 * Instance de la Classe de gestion des Configs
		 * @var Config
		 */
		protected $ConfigModule;
		
		/**
		 * Caratère de retour à la ligne
		 * @var string
		 */
		protected $passage_ligne;

		/**
		 * Délimiteur block mail
		 * @var string
		 */
		protected $boundary;

		/**
		 * Regex pour les Mails
		 * @var string
		 */
		protected $regexMail = "#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#";
		
		
		/**
		 * Mailer constructor.
		 */
		public function __construct()
		{
			$this->boundary = "-----=" . md5(mt_rand());
			$this->ConfigModule = Config::getInstance();
		}


		/* -------- Fonctions Annexes pour l'envoi de Mail -------- */

			/**
			 * Créer l'en-tête du mail en fonction du type de mail
			 *
			 * @param string $mail
			 */
			protected function headerFormat(string $mail)
			{
				if (!preg_match($this->regexMail, $mail))
					$this->passage_ligne = "\r\n";
				else
					$this->passage_ligne = "\n";
			}

			/**
			 * Assigne l'en-tête au mail
			 *
			 * @return string
			 */
			protected function setHeader(): string
			{
				$header  = 'Content-Type: text/html; charset="UTF8"' . $this->passage_ligne;
				$header .= 'Content-Transfer-Encoding: 8bit' . $this->passage_ligne;
				$header .= 'X-Mailer: PHP/' . phpversion() . $this->passage_ligne;

				return $header;
			}




		/* -------- Spécialisation de type de Mail -------- */

			/**
			 * Envoi un Message aux Utilisateurs abonnés aux News
			 *
			 * @param string $title
			 * @param string $content
			 * @param array $emails
			 *
			 * @return bool
			 */
			public function News(string $title, string $content, array $emails): bool
			{
				$send = true;
				foreach ($emails as $email)
				{
					$this->headerFormat($email);

					$header  = 'From: ' . $this->ConfigModule->get("ShirOS.Mail.WebMaster_Email") . $this->passage_ligne;
					$header .= 'Reply-To: ' . $this->ConfigModule->get("ShirOS.Mail.WebMaster_Email") . $this->passage_ligne;
					$header .= $this->setHeader();
					
					$to      = $email;
					$subject = $title;


					$message = $this->ConfigModule->get("ShirOS.Mail.Template");
					$message = str_replace("%title", $title , $message);
					$message = str_replace("%content", $content , $message);

					$send &= mail($to, $subject, $message, $header);
				}

				return $send;
			}

			/**
			 * Envoi un Message aux Utilisateurs pour la validation du leurs Emails
			 *
			 * @param string $email
			 * @param string $name
			 * @param string $content
			 *
			 * @return bool
			 */
			public function Subscribe(string $email, string $name, string $content): bool
			{
				$this->headerFormat($email);

				$header  = 'From: ' . $this->ConfigModule->get("ShirOS.Mail.WebMaster_Email") . $this->passage_ligne;
				$header .= 'Reply-To: ' . $this->ConfigModule->get("ShirOS.Mail.WebMaster_Email") . $this->passage_ligne;
				$header .= $this->setHeader();
				

				$to      = $email;
				$subject = 'Confirmation de votre Inscription';

				$message = $this->ConfigModule->get("ShirOS.Mail.Template");
				$message = str_replace("%title", "Hi {$name} !" , $message);
				$message = str_replace("%content", $content , $message);

				$send = mail($to, $subject, $message, $header);
				return $send;
			}

			/**
			 * Envoi un Message aux Utilisateurs pour la Reinitialisation du leurs Mot de Passe
			 *
			 * @param string $email
			 * @param string $name
			 * @param string $content
			 *
			 * @return bool
			 */
			public function Password(string $email, string $name, string $content): bool
			{
				$this->headerFormat($email);

				$header  = 'From: ' . $this->ConfigModule->get("ShirOS.Mail.WebMaster_Email") . $this->passage_ligne;
				$header .= 'Reply-To: ' . $this->ConfigModule->get("ShirOS.Mail.WebMaster_Email") . $this->passage_ligne;
				$header .= $this->setHeader();
				

				$to      = $email;
				$subject = 'Confirmation de changement de mot de passe';

				$message = $this->ConfigModule->get("ShirOS.Mail.Template");
				$message = str_replace("%title", "Hi {$name} !" , $message);
				$message = str_replace("%content", $content , $message);

				$send = mail($to, $subject, $message, $header);
				return $send;
			}

			/**
			 * Envoi un Message aux Utilisateurs pour la validation du leurs Emails
			 *
			 * @param string $email
			 * @param string $name
			 * @param string $content
			 *
			 * @return bool
			 */
			public function Email(string $email, string $name, string $content): bool
			{
				$this->headerFormat($email);
				
				$header  = 'From: ' . $this->ConfigModule->get("ShirOS.Mail.WebMaster_Email") . $this->passage_ligne;
				$header .= 'Reply-To: ' . $this->ConfigModule->get("ShirOS.Mail.WebMaster_Email") . $this->passage_ligne;
				$header .= $this->setHeader();
				

				$to      = $email;
				$subject = 'Validation de votre Adresse Email';
				
				$message = $this->ConfigModule->get("ShirOS.Mail.Template");
				$message = str_replace("%title", "Hi {$name} !" , $message);
				$message = str_replace("%content", $content , $message);

				$send = mail($to, $subject, $message, $header);
				return $send;
			}
	}
?>