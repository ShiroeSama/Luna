<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : SelectComponent.php
     *   @Created_at : 29/03/2018
     *   @Update_at : 29/03/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Database\QueryBuilder\MySQL\QueryComponent;

    use Luna\Database\QueryBuilder\MySQL\QueryBuilder;
    use Luna\Database\QueryBuilder\MySQL\QueryComponent\Action\From;
    use Luna\Database\QueryBuilder\MySQL\QueryComponent\Action\GroupBy;
    use Luna\Database\QueryBuilder\MySQL\QueryComponent\Action\OrderBy;
    use Luna\Database\QueryBuilder\MySQL\QueryComponent\Action\Where;

    class SelectComponent extends AbstractComponent
    {
        /* -------------------------------------------------------------------------- */
        /* ACTION */

        use From;
        use Where;
        use OrderBy;
        use GroupBy;


        /* -------------------------------------------------------------------------- */
        /* ATTRIBUTES */

        /** @var string */
        protected $selectQuery;

        /** @var array */
        protected $selectPart;

        /** @var string */
        protected $leftJoinQuery;

        /** @var array */
        protected $leftJoinPart;

        /**
         * SelectComponent constructor.
         *
         * @param QueryBuilder $builder
         * @param string $condition
         */
        public function __construct(QueryBuilder $builder, string $condition)
        {
            parent::__construct($builder);
            $this->select($condition);
        }


        /* -------------------------------------------------------------------------- */
        /* QUERY */

        /**
         * SELECT Part
         *
         * @param string $condition
         * @return SelectComponent
         */
        public function select(string $condition): SelectComponent
        {
            array_push($this->selectPart, $condition);

            return $this;
        }

        /**
         * LEFT JOIN Part
         *
         * @param string $table
         * @param string $keyword
         * @param string $condition
         *
         * @return SelectComponent
         */
        public function leftJoin(string $table, string $keyword, string $condition): SelectComponent
        {
            $leftJoinQuery = "LEFT JOIN {$table} {$keyword} {$condition}";
            array_push($this->leftJoinPart, $leftJoinQuery);

            return $this;
        }


        /* -------------------------------------------------------------------------- */
        /* PREPARE QUERY */

        protected function prepareSelectPart()
        {
            $this->selectQuery = 'SELECT ';
            $this->selectQuery .= implode(', ', $this->selectPart);
            $this->selectQuery = " {$this->selectQuery} ";
        }

        protected function prepareLeftJoinPart()
        {
            $this->leftJoinQuery = implode(' ', $this->leftJoinPart);
            $this->leftJoinQuery = " {$this->leftJoinQuery} ";
        }


        /* -------------------------------------------------------------------------- */
        /* VALIDATE */

        public function validate(): QueryBuilder
        {
            $this->prepareSelectPart();
            $this->prepareFromPart();
            $this->prepareLeftJoinPart();
            $this->prepareOrderByPart();
            $this->prepareGroupByPart();

            $this->queryString = $this->selectQuery
                . $this->fromQuery
                . $this->leftJoinQuery
                . $this->orderByQuery
                . $this->groupByQuery;

            return $this->builder;
        }
    }
?>