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
        public function onRoutingException(Throwable $throwable)
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


    }
?>