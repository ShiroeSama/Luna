<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : RouterInterface.php
     *   @Created_at : 14/03/2018
     *   @Update_at : 07/05/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Component\Routing;

    use Luna\Component\HTTP\Request\Request;
    use Luna\Component\HTTP\Request\ResponseInterface;

    interface RouterInterface
    {
        /**
         * Start the router and exec the routing system
         *
         * @param Request $request
         *
         * @return ResponseInterface
         */
        public function init(Request $request): ResponseInterface;
    }
?>