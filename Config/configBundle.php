<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : configBundle.php
	 *   @Created_at : 02/12/2017
	 *   @Update_at : 02/12/2017
	 * --------------------------------------------------------------------------
	 */
	
	/*
	|--------------------------------------------------------------------------
	| Constante
	|--------------------------------------------------------------------------
	|
	*/

	$appRoot = str_replace(DIRECTORY_SEPARATOR . basename(__DIR__), '', __DIR__);			
	define('APP_ROOT', $appRoot);


    /*
    |--------------------------------------------------------------------------
    | Config
    |--------------------------------------------------------------------------
    |
    |   Contient toutes les variables de Configuration
    |
    */

    $Config = [

        /*
        |--------------------------------------------------------------------------
        | Server
        |--------------------------------------------------------------------------
        |
        |   Permet de Définir le Nom, l'Autheur, la page d'accueil du site
        |
        */

        'Server' => [
            'Name'      => '',
            'Author'    => '',
            'Homepage'  => '',
        ],

        /*
        |--------------------------------------------------------------------------
        | ShirOS
        |--------------------------------------------------------------------------
        |
        |   Contient toutes les variables du Framework
        */

        'ShirOS' => [

            /*
            |--------------------------------------------------------------------------
            | Database
            |--------------------------------------------------------------------------
            |
            |   Informations de connexion à/aux Base(s) de données.
            |   Ainsi que d'autre paramètres de configuration de la Base de Données pour le Framework
            |
            |   Contient :
			|       - Le Type de Driver à utiliser
			|       - Le Type de Fetch (Récupèration des données) à utiliser
            |	    - Les Indentifiants de Connexion
            |	    - Les Noms des Colonnes Utiles au Framework
            |
            */

            'Database' => [

                /*
                |--------------------------------------------------------------------------
                | Database Driver
                |--------------------------------------------------------------------------
                |
                |   Selection du type de persistance à utiliser
                |
                */

                'Driver' => [
                    'MySQL_PDO' => true,
                ],
	
	            /*
				|--------------------------------------------------------------------------
				| Database FetchMode
				|--------------------------------------------------------------------------
				|
				|   Selection du type de récupèration de données
	            |   Mettre 'Current' à 'None' pour ne pas changer le fetch par défaut de PDO (Array Assoc)
	            |
				*/
	
	            'FetchMode' => [
	            	'Current' => 'FETCH_CLASS',
		            'Name' => [
			            'Fetch_Class' => 'FETCH_CLASS',
			            'Fetch_Into' => 'FETCH_INTO',
					]
	            ],


                /*
                |--------------------------------------------------------------------------
                | Database Connexion
                |--------------------------------------------------------------------------
                |
                |   Identifiants de connexion à la base de données
				|
				|   'dbUser' => Identifiant de connexion (Username)
				|   'dbPass' => Mot de passe
				|   'dbHost' => Ip du serveur de base de données
				|   'dbName' => Nom de la base de données
                |
                */

                'Connect' => [
                    'dbUser' => '',
                    'dbPass' => '',
                    'dbHost' => '',
                    'dbName' => '',
                ],


                /*
                |--------------------------------------------------------------------------
                | Database Column
                |--------------------------------------------------------------------------
                |
                |   Contient le nom des colonnes nécéssaire au fonction du Framework
                |
                */

                'Column' => [
                    'Auth_Login'        => 'email',
                    'Auth_Login_Token'  => 'token',
                    'Signature_Id'      => 'signatureId',
                    'Signature'         => 'signature',
                ],

                /*
                |--------------------------------------------------------------------------
                | Database Id Index Update
                |--------------------------------------------------------------------------
                |
				|   Nom des index du tableau '$id' à utiliser lors d'un update.
				|   Permet au Framework de savoir le nom de la colonne 'Primary Key'.
				|   Ainsi que la valeur de cette colonne pour effectuer la mise à jour des données
                |
                |   Exemple :
                |	    - $id = array(
                |           $ConfigModule->get('ShirOS.Database.IdIndex.Id_Column') => 'username'
                |           $ConfigModule->get('ShirOS.Database.IdIndex.Id_Value') => 'Shiroe_sama'
                |       );
                |
                |   Pour avoir un tableau associatif :
	            |	    - $id = array(
	            |           'ColumnName'    => 'username'
	            |           'Value'         => 'Shiroe_sama'
	            |       );
                |
                |   Ce qui permet à la sérialisation de s'effectuer correctement
                |
                */

                'IdIndex' => [
                    'Id_Column' => 'ColumnName',
                    'Id_Value'  => 'Value',
                ]
            ],

            /*
            |--------------------------------------------------------------------------
            | Les Paths
            |--------------------------------------------------------------------------
            |
            |   Chemins nécessaires pour le Framework
            |
            |   Namespace
            |       |- Gateway (Chemin des Gateway de l'application)
            |
            |   Error       (Chemin des vues d'erreurs de l'application)    | Exemple : '.App.View.Errors'
            |   View        (Chemin des vues de l'application)              | Exemple : '.App.View'
            |   Template    (Chemin du/des templates de l'application)      | Exemple : '.App.View.Templates'
            |
            */

            'Path' => [
                'Namespace' => [
                    'Gateway' => 'App\\Gateway\\',
                ],
                'Error'     => APP_ROOT . '',
                'View'      => APP_ROOT . '',
                'Template'  => APP_ROOT . '',
            ],

            /*
            |--------------------------------------------------------------------------
            | Nommage
            |--------------------------------------------------------------------------
            |
            |   Nommage des Fichiers et Classes de l'Application
            |
            |   Folder
            |       |- Namespace
            |           |- Model    (Nom du Dossier contenant les Models/Entities)
            |           |- Gateway  (Nom du Dossier contenant les Gateway)
            |   File
            |       |- Namespace
            |           |- Model    (Prefixe ou Suffixe d'un Model/Entity)  Exemple: 'class UserModel {}'   => 'UserModel.php'
            |           |- Gateway  (Prefixe ou Suffixe d'une Gateway)      Exemple: 'class UserGateway {}' => 'UserGateway.php'
            |       |- Error
            |           |- NotFound             (Nom du Fichier pour la vue '404 Not Found')
            |           |- Forbidden            (Nom du Fichier pour la vue '403 Forbidden')
            |           |- InternalServerError  (Nom du Fichier pour la vue '500 Internal Server Error')
            |           |- OtherError           (Nom du Fichier pour la vue des autres erreurs)
            |       |- Template
            |           |- Header   (Nom du Fichier template pour l'en-tête)
            |           |- Footer   (Nom du Fichier template pour le pied de page)
            |
            */

            'Name' => [
                'Folder' => [
                    'Namespace' => [
                        'Model'     => 'Model',
                        'Gateway'   => 'Gateway',
                    ],
                ],
                'File' => [
                    'Namespace' => [
                        'Model'     => 'Model',
                        'Gateway'   => 'Gateway',
                    ],
                    'Error' => [
                        'NotFound'              => 'NotFound',
                        'Forbidden'             => 'Forbidden',
                        'InternalServerError'   => 'InternalServerError',
                        'OtherError'            => 'Error',
                    ],
                    'Template' => [
                        'Header' => 'Header',
                        'Footer' => 'Footer',
                    ],
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | Les Namespace
            |--------------------------------------------------------------------------
            |
            |   Permet de préciser au Framework, l'utilisation d'un préfixe ou suffixe dans le nom des Models et Gateway
            |
            |   3 Choix :
            |	    - 'None', Aucun Prefixe ou Suffixe;
            |	    - 'Prefixe', Un prefixe est existant;
            |	    - 'Suffixe', Un suffixe est existant;
            |
            */

            'Namespace' => [
                'PS_Type' => 'Suffixe',
            ],


            /*
            |--------------------------------------------------------------------------
            | Les Sessions
            |--------------------------------------------------------------------------
            |
            |   Variable gérant la création d'une session basique
            |
            |   Id      => Contiendra l'id de la Session
            |       | Exemple :
            |           session_name($auth[$ConfigModule->get('ShirOS.Session.Id')]);
            |
            |   Name    => Contiendra le nom de l'utilisateur connecté
            |       | Exemple : Pour la création d'une Session utilisateur
            |           return array(
			|				$ConfigModule->get('ShirOS.Session.Id')     => $user->$id,
			|				$ConfigModule->get('ShirOS.Session.Name')   => $user->$login,
			|			);
            |
            |   Url_Ban => Contient la liste des méthodes à ne pas gérer dans le système de navigation
            |       | Exemple :
            |           Lors de l'utilisation du '$SessionModule->navSet();' les urls contenant les chaines de caratères
            |           de 'Url_Ban' ne seront pas sauvegardé dans la session de navigation.
            |
            */

            'Session' => [
                'Id'        => 'Id',
                'Name'      => 'Username',
                'Url_Ban'   => [
                    'video',
                    'inscription',
                    'profilBox',
                    'menu',
                    'login',
                    'add',
                    'edit',
                    'delete'
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | Les Mails
            |--------------------------------------------------------------------------
            |
			|   Utilise la fonction 'mail' de PHP
            |   Contient l'email source, celle de l'application ainsi que le template du mail
            |
            */

            'Mail' => [
                'WebMaster_Email' => '',
                'Template' =>
                    "
                    <div>
                        <div>
                            <div>
                                <a>%title</a>
                            </div>
            
                            <div>
                                %content
                            </div>
                        </div>
                    </div>",
            ],


            /*
            |--------------------------------------------------------------------------
            | Users
            |--------------------------------------------------------------------------
            |
            |   Coût de chiffrement des mots de passe (Par Défaut => 12)
            |
            */

            'Users' => [
                'Crypt_Cost' => 12,
            ],


            /*
            |--------------------------------------------------------------------------
            | HTML Element
            |--------------------------------------------------------------------------
            |
            |   Nom de certains éléments HTML (Formulaire) qui seront généré différement des éléments 'simple'
            |   par la classe de création de formulaire.
            |
            |   Exemple :
            |       - $form->submit($ConfigModule->get('ShirOS.HTML.Login_Button'));
            |       - Affichage => '<button type="submit" class="btn btn-primary"> <span class="glyphicon glyphicon-log-in"></span> Connexion </button>'
            |
            */

            'HTML' => [
                'Login_Button'  => 'Connexion',
                'Logout_Button' => 'Déconnexion',
            ],


    /*
    |--------------------------------------------------------------------------
    | End Config
    |--------------------------------------------------------------------------
    |
    */

        ]
    ];


    /*
    |--------------------------------------------------------------------------
    | Configuration
    |--------------------------------------------------------------------------
    |
    */
	
	$Config['ShirOS']['Path']['View'] = str_replace('.', DIRECTORY_SEPARATOR, $Config['ShirOS']['Path']['View']);
    $Config['ShirOS']['Path']['Error'] = str_replace('.', DIRECTORY_SEPARATOR, $Config['ShirOS']['Path']['Error']);
    $Config['ShirOS']['Path']['Template'] = str_replace('.', DIRECTORY_SEPARATOR, $Config['ShirOS']['Path']['Template']);


	/*
	|--------------------------------------------------------------------------
	| Return Config
	|--------------------------------------------------------------------------
	|
	*/

	return $Config;
?>