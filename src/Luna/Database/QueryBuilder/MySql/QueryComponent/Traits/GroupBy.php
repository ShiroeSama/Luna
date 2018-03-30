<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : GroupBy.php
     *   @Created_at : 29/03/2018
     *   @Update_at : 29/03/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Database\QueryBuilder\MySQL\QueryComponent\Traits;

    trait GroupBy
    {
        /** @var string */
        protected $groupByQuery;

        /** @var array */
        protected $groupByPart;

        /* -------------------------------------------------------------------------- */
        /* QUERY */

        /**
         * GROUP BY Part
         *
         * @param string $column
         *
         * @return self
         */
        public function groupBy(string $column): self
        {
            array_push($this->groupByPart, $column);

            return $this;
        }


        /* -------------------------------------------------------------------------- */
        /* PREPARE QUERY */

        protected function prepareGroupByPart()
        {
            $this->groupByQuery = 'GROUP BY ';
            $this->groupByQuery .= implode(', ', $this->groupByPart);
            $this->groupByQuery = " {$this->groupByQuery} ";
        }
    }
?>