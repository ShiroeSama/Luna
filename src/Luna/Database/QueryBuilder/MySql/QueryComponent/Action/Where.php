<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : Where.php
     *   @Created_at : 29/03/2018
     *   @Update_at : 29/03/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Database\QueryBuilder\MySQL\QueryComponent\Action;

    trait Where
    {
        /** @var string */
        protected $queryWherePart;

        /**
         * WHERE Part
         *
         * @param string $condition
         * @return mixed
         */
        public function where(string $condition)
        {
            $this->queryWherePart = "WHERE {$condition}";
            return $this;
        }


        /**
         * AND WHERE Part
         * @param string $condition
         * @return mixed
         */
        public function andWhere(string $condition)
        {
            if (is_null($this->queryWherePart)) {
                $this->where($condition);
            } else {
                $this->queryWherePart .= "AND {$condition}";
            }

            return $this;
        }


        /**
         * OF WHERE Part
         * @param string $condition
         * @return mixed
         */
        public function orWhere(string $condition)
        {
            if (is_null($this->queryWherePart)) {
                $this->where($condition);
            } else {
                $this->queryWherePart .= "OR {$condition}";
            }

            return $this;
        }
    }
?>