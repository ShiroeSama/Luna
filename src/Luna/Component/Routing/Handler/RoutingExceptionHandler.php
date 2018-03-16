<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : RoutingExceptionHandler.php
     *   @Created_at : 14/03/2018
     *   @Update_at : 14/03/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Component\Routing\Handler;

    use \Throwable;
    use \PDOException;

    use Luna\Utils\Exception\LoginException;
    use Luna\Utils\Exception\DatabaseException;


    class RoutingExceptionHandler
    {
        public function onKernelException(Throwable $throwable)
        {
            switch (get_class($throwable)) {
                case RoutingException::class:
                    break;

                case PDOException::class:
                    break;

                case DatabaseException::class:
                    break;

                case LoginException::class:
                    break;

                default:
                    break;
            }
        }


        /* catch (RouteException $re) {
					# Gére les Exceptions des Routes
					switch ($re->getCode()) {
						case RouteException::ROUTE_NOTFOUND_ERROR_CODE:
							$this->RenderModule->notFound($re->getMessage());
							break;

						case RouteException::ROUTE_CONTROLLER_NOTFOUND_ERROR_CODE:
							$this->RenderModule->notFound($re->getMessage());
							break;

						case RouteException::ROUTE_FORBIDDEN_ERROR_CODE:
							$this->RenderModule->forbidden($re->getMessage());
							break;

						case RouteException::ROUTE_METHODE_NOT_ALLOWED_ERROR_CODE:
							$this->RenderModule->error(HTTP::METHOD_NOT_ALLOWED, $re->getMessage());
							break;

						case RouteException::ROUTE_GONE_ERROR_CODE:
							$this->RenderModule->error(HTTP::GONE, $re->getMessage());
							break;

						case RouteException::ROUTE_INTERNAL_SERVER_ERROR_ERROR_CODE:
							$this->RenderModule->error(HTTP::INTERNAL_SERVER_ERROR, $re->getMessage());
							break;

						default:
							$this->RenderModule->internalServerError();
							break;
					}
				} catch (PDOException $pdo) {
					# Gére les Exceptions de Connexion à la Base de Données
					$this->RenderModule->internalServerError($pdo->getMessage());
				} catch (DatabaseException $dbe) {
					# Gére les Exceptions de Connexion à la Base de Données
					switch ($dbe->getCode()) {
						case DatabaseException::DATABASE_METHODE_NOT_ALLOWED_ERROR_CODE:
							$this->RenderModule->error(HTTP::METHOD_NOT_ALLOWED, $dbe->getMessage());
							break;

						case DatabaseException::DATABASE_NOT_IMPLEMENTED_ERROR_CODE:
							$this->RenderModule->error(HTTP::NOT_IMPLEMENTED, $dbe->getMessage());
							break;

						case DatabaseException::DATABASE_BAD_GATEWAY_ERROR_CODE:
							$this->RenderModule->error(HTTP::BAD_GATEWAY, $dbe->getMessage());
							break;

						default:
							$this->RenderModule->internalServerError();
							break;
					}
				} catch (LoginException $le) {
					# Gére les Exceptions du Login
					switch ($le->getCode()) {
						case LoginException::AUTHENTIFICATION_FAILED_ERROR_CODE:
							$this->RenderModule->error(HTTP::UNAUTHORIZED, $le->getMessage());
							break;
						default:
							$this->RenderModule->internalServerError();
							break;
					}
         */

    }
?>