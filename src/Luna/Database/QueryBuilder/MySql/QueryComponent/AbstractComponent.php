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

    use Luna\Component\Exception\QueryComponentException;
    use Luna\Database\QueryBuilder\MySQL\Query;
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
            $this->queryString = NULL;
        }

        /**
         * Validate the Query and build it
         *
         * @return AbstractComponent
         */
        public function validate(): AbstractComponent
        {
            return $this;
        }

        /**
         * @return Query
         * @throws QueryComponentException
         */
        public function getQuery(): Query
        {
            $query = trim($this->queryString);

            if (empty($this->queryString) || is_null($this->queryString)) {
                throw new QueryComponentException("You can't retrieve the query while it is empty");
            }

            return new Query($this->builder->getEntityName(), $query);
        }
    }
?>