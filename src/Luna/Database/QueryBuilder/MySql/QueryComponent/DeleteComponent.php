<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : DeleteComponent.php
     *   @Created_at : 29/03/2018
     *   @Update_at : 29/03/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Database\QueryBuilder\MySQL\QueryComponent;

    use Luna\Database\QueryBuilder\MySQL\QueryBuilder;
    use Luna\Database\QueryBuilder\MySQL\QueryComponent\Traits\Where;
    use Luna\Entity\Entity;

    class DeleteComponent extends AbstractComponent
    {
        /* -------------------------------------------------------------------------- */
        /* TRAITS */

        use Where;


        /* -------------------------------------------------------------------------- */
        /* ATTRIBUTES */

        /** @var string */
        protected $deleteQuery;

        /** @var array */
        protected $deletePart = [];


        /**
         * SelectComponent constructor.
         *
         * @param QueryBuilder $builder
         * @param string $table
         */
        public function __construct(QueryBuilder $builder, string $table)
        {
            parent::__construct($builder);
            $this->delete($table);
        }


        /* -------------------------------------------------------------------------- */
        /* QUERY */

        /**
         * INSERT Part
         *
         * @param string $table
         * @return DeleteComponent
         */
        protected function delete(string $table): DeleteComponent
        {
            if (class_exists($table) && is_a($table, Entity::class)) {
                /** @var Entity $entity */
                $entity = new $table();
                $table = $entity->getTable();
            }

            $this->deletePart = $table;

            return $this;
        }


        /* -------------------------------------------------------------------------- */
        /* PREPARE QUERY */

        protected function prepareDeletePart()
        {
            $this->deleteQuery = " DELETE FROM {$this->deletePart} ";
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
            $this->prepareDeletePart();
            $this->prepareWherePart();

            $this->queryString = $this->deleteQuery . $this->whereQuery;

            return $this;
        }
    }
?>