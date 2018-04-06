<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : Set.php
     *   @Created_at : 30/03/2018
     *   @Update_at : 30/03/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Database\QueryBuilder\MySQL\QueryComponent\Traits;

    trait Set
    {
        /** @var string */
        protected $setQuery;

        /** @var array */
        protected $setPart = [];

        /* -------------------------------------------------------------------------- */
        /* QUERY */

        /**
         * VALUE Part
         *
         * @param string $column
         * @param string $key
         *
         * @return self
         */
        public function set(string $column, string $key): self
        {
            $setString = "{$column} = {$key}";
            array_push($this->setPart, $setString);

            return $this;
        }


        /* -------------------------------------------------------------------------- */
        /* PREPARE QUERY */

        protected function prepareSetPart()
        {
            $this->setQuery = 'SET ';
            $this->setQuery .= implode(', ', $this->setPart);
            $this->setQuery = " {$this->setQuery} ";
        }
    }
?>