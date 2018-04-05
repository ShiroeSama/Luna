<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : InsertComponent.php
     *   @Created_at : 29/03/2018
     *   @Update_at : 29/03/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Database\QueryBuilder\MySQL\QueryComponent;

    use Luna\Database\QueryBuilder\MySQL\QueryBuilder;
    use Luna\Database\QueryBuilder\MySQL\QueryComponent\Traits\Values;
    use Luna\Entity\Entity;

    class InsertComponent extends AbstractComponent
    {
        /* -------------------------------------------------------------------------- */
        /* TRAITS */

        use Values;


        /* -------------------------------------------------------------------------- */
        /* ATTRIBUTES */

        /** @var string */
        protected $insertPart;

        /** @var string */
        protected $insertQuery;

        /**
         * SelectComponent constructor.
         *
         * @param QueryBuilder $builder
         * @param string $table
         */
        public function __construct(QueryBuilder $builder, string $table)
        {
            parent::__construct($builder);
            $this->insert($table);
        }


        /* -------------------------------------------------------------------------- */
        /* QUERY */

        /**
         * INSERT Part
         *
         * @param string $table
         * @return InsertComponent
         */
        protected function insert(string $table): InsertComponent
        {
            if (class_exists($table) && is_a($table, Entity::class)) {
                /** @var Entity $entity */
                $entity = new $table();
                $table = $entity->getTable();
            }

            $this->insertPart = $table;

            return $this;
        }


        /* -------------------------------------------------------------------------- */
        /* PREPARE QUERY */

        protected function prepareInsertPart()
        {
            $this->insertQuery = " INSERT INTO {$this->insertPart} ";
        }


        /* -------------------------------------------------------------------------- */
        /* VALIDATE */

        /**
         * Validate the Query and build it
         *
         * @return AbstractComponent
         * @throws \Luna\Component\Exception\QueryComponentException
         */
        public function validate(): AbstractComponent
        {
            $this->prepareInsertPart();
            $this->prepareValuesPart();

            $this->queryString = $this->insertQuery . $this->valuesQuery;

            return $this;
        }
    }
?>