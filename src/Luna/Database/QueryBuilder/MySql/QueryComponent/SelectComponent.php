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
    use Luna\Database\QueryBuilder\MySQL\QueryComponent\Traits\From;
    use Luna\Database\QueryBuilder\MySQL\QueryComponent\Traits\GroupBy;
    use Luna\Database\QueryBuilder\MySQL\QueryComponent\Traits\OrderBy;
    use Luna\Database\QueryBuilder\MySQL\QueryComponent\Traits\Where;
    use Luna\Entity\Entity;

    class SelectComponent extends AbstractComponent
    {
        /* -------------------------------------------------------------------------- */
        /* TRAITS */

        use From;
        use Where;
        use OrderBy;
        use GroupBy;


        /* -------------------------------------------------------------------------- */
        /* ATTRIBUTES */

        /** @var string */
        protected $selectQuery;

        /** @var array */
        protected $selectPart = [];

        /** @var string */
        protected $leftJoinQuery;

        /** @var array */
        protected $leftJoinPart = [];

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
            if (class_exists($table) && (is_a($table, Entity::class) or is_subclass_of($table, Entity::class))) {
                /** @var Entity $entity */
                $entity = new $table();
                $table = $entity->getTable();
            }

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

        /**
         * Validate the Query and build it
         *
         * @return AbstractComponent
         */
        public function validate(): AbstractComponent
        {
            $this->prepareSelectPart();
            $this->prepareFromPart();
            $this->prepareLeftJoinPart();
            $this->prepareWherePart();
            $this->prepareOrderByPart();
            $this->prepareGroupByPart();

            $this->queryString = $this->selectQuery
                . $this->fromQuery
                . $this->leftJoinQuery
                . $this->whereQuery
                . $this->orderByQuery
                . $this->groupByQuery;

            return $this;
        }
    }
?>