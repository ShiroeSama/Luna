<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : OrderBy.php
     *   @Created_at : 29/03/2018
     *   @Update_at : 29/03/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Database\QueryBuilder\MySQL\QueryComponent\Action;

    trait OrderBy
    {
        /** @var string */
        protected $orderByQuery;

        /** @var array */
        protected $orderByPart;

        /* -------------------------------------------------------------------------- */
        /* QUERY */

        /**
         * ORDER BY Part
         *
         * @param string $column
         *
         * @return mixed
         */
        public function orderBy(string $column)
        {
            array_push($this->orderByPart, $column);

            return $this;
        }


        /* -------------------------------------------------------------------------- */
        /* PREPARE QUERY */

        protected function prepareOrderByPart()
        {
            $this->orderByQuery = 'ORDER BY ';
            $this->orderByQuery .= implode(', ', $this->orderByPart);
            $this->orderByQuery = " {$this->orderByQuery} ";
        }
    }
?>