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
        /** @var array */
        protected $updateColumns = [];

        /** @var string */
        protected $setQuery;

        /** @var array */
        protected $setPart = [];

        /** @var array */
        protected $paramsBag = [];

        /* -------------------------------------------------------------------------- */
        /* QUERY */

        /**
         * VALUE Part
         *
         * @param string $key
         *
         * @param $value
         * @return self
         */
        public function set(string $key, $value): self
        {
            $this->paramsBag[$key] = $value;
            array_push($this->updateColumns, $key);
            array_push($this->setPart, "{$key} = :{$key}");

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