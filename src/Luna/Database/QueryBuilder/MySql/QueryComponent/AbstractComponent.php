<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : AbstractComponent.php
     *   @Created_at : 29/03/2018
     *   @Update_at : 29/03/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Database\QueryBuilder\MySQL\QueryComponent;

    use Luna\Database\QueryBuilder\MySQL\QueryBuilder;

    class AbstractComponent
    {
        /** @var string */
        protected $queryString;

        /** @var QueryBuilder */
        protected $builder;

        /**
         * AbstractComponent constructor.
         * @param QueryBuilder $builder
         */
        public function __construct(QueryBuilder $builder)
        {
            $this->builder = $builder;
        }

        /**
         * @return string
         */
        public function getQueryString(): string
        {
            return trim($this->queryString);
        }

        public function validate(): QueryBuilder
        {
            $this->queryString = NULL;
            return $this->builder;
        }
    }
?>