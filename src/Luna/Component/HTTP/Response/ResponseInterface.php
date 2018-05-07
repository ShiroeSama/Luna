<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : ResponseInterface.php
     *   @Created_at : 07/05/2018
     *   @Update_at : 07/05/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Component\HTTP\Request;

    interface ResponseInterface
    {
        /**
         * Prepare the response header.
         * Like HTTP Version, Content-Type, Status Code, ...
         *
         * @return void
         */
        public function getHeaders(): void;


        /**
         * Get the HTTP Status Code
         *
         * @return int
         */
        public function getStatusCode(): int;

        /**
         * Show the result of the request.
         *
         * @return void
         */
        public function getContent();
    }
?>