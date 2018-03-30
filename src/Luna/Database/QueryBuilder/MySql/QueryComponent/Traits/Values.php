<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : Values.php
     *   @Created_at : 29/03/2018
     *   @Update_at : 29/03/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Database\QueryBuilder\MySQL\QueryComponent\Traits;

    trait Values
    {
        /** @var string */
        protected $valuesQuery;

        /** @var array */
        protected $valuesPart;

        /* -------------------------------------------------------------------------- */
        /* QUERY */

        /**
         * VALUE Part
         *
         * @param string $key
         *
         * @return self
         */
        public function value(string $key): self
        {
            array_push($this->valuesPart, $key);

            return $this;
        }

        /**
         * VALUES Part
         *
         * @param array $keys
         *
         * @return self
         */
        public function values(array $keys): self
        {
            $valuesString = implode(', ', $keys);
            $valuesString = "({$valuesString})";

            return $this->value($valuesString);
        }


        /* -------------------------------------------------------------------------- */
        /* PREPARE QUERY */

        protected function prepareValuesPart()
        {
            $this->valuesQuery = 'VALUES ';
            $this->valuesQuery .= implode(', ', $this->valuesPart);
            $this->valuesQuery = " {$this->valuesQuery} ";
        }
    }
?>