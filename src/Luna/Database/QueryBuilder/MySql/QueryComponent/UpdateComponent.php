<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : UpdateComponent.php
     *   @Created_at : 29/03/2018
     *   @Update_at : 29/03/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Database\QueryBuilder\MySQL\QueryComponent;

    use Luna\Database\QueryBuilder\MySQL\QueryBuilder;
    use Luna\Database\QueryBuilder\MySQL\QueryComponent\Traits\Set;
    use Luna\Database\QueryBuilder\MySQL\QueryComponent\Traits\Where;
    use Luna\Entity\Entity;

    class UpdateComponent extends AbstractComponent
    {
        /* -------------------------------------------------------------------------- */
        /* TRAITS */

        use Set;
        use Where;


        /* -------------------------------------------------------------------------- */
        /* ATTRIBUTES */

        /** @var string */
        protected $updatePart;

        /** @var string */
        protected $updateQuery;

        /**
         * SelectComponent constructor.
         *
         * @param QueryBuilder $builder
         * @param string $table
         */
        public function __construct(QueryBuilder $builder, string $table)
        {
            parent::__construct($builder);
            $this->update($table);
        }


        /* -------------------------------------------------------------------------- */
        /* QUERY */

        /**
         * INSERT Part
         *
         * @param string $table
         * @return UpdateComponent
         */
        protected function update(string $table): UpdateComponent
        {
            if (class_exists($table) && is_a($table, Entity::class)) {
                /** @var Entity $entity */
                $entity = new $table();
                $table = $entity->getTable();
            }

            $this->updateQuery = $table;

            return $this;
        }


        /* -------------------------------------------------------------------------- */
        /* PREPARE QUERY */

        protected function prepareUpdatePart()
        {
            $this->updateQuery = " UPDATE {$this->updatePart} ";
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
            $this->prepareUpdatePart();
            $this->prepareSetPart();
            $this->prepareWherePart();

            $this->queryString = $this->updateQuery
                . $this->setQuery
                . $this->whereQuery;

            return $this;
        }
    }
?>