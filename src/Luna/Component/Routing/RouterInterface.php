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
     *   @Update_at : 26/03/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Component\Routing;

    use Luna\Component\HTTP\Request\RequestBuilder;

    interface RouterInterface
    {
        /**
         * Start the router and exec the routing system
         *
         * @param RequestBuilder $requestBuilder
         */
        public function init(RequestBuilder $requestBuilder);
    }
?>