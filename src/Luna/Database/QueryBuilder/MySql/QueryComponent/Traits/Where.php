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

    namespace Luna\Database\QueryBuilder\MySQL\QueryComponent\Traits;

    trait Where
    {
        /** @var string */
        protected $whereQuery;

        /** @var array */
        protected $wherePart;

        /* -------------------------------------------------------------------------- */
        /* QUERY */

        /**
         * WHERE Part
         *
         * @param string $condition
         *
         * @return self
         */
        public function where(string $condition): self
        {
            array_push($this->wherePart, $condition);

            return $this;
        }

        /**
         * AND WHERE Part
         *
         * @return self
         */
        public function and(): self
        {
            array_push($this->wherePart, 'AND');

            return $this;
        }

        /**
         * OR WHERE Part
         *
         * @return self
         */
        public function or(): self
        {
            array_push($this->wherePart, 'OR');

            return $this;
        }


        /* -------------------------------------------------------------------------- */
        /* PREPARE QUERY */

        protected function prepareWherePart()
        {
            $this->whereQuery = 'WHERE ';
            $this->whereQuery .= implode(' ', $this->wherePart);
            $this->whereQuery = " {$this->whereQuery} ";
        }
    }
?>