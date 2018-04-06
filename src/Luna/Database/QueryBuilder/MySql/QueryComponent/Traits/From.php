<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : From.php
     *   @Created_at : 29/03/2018
     *   @Update_at : 29/03/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Database\QueryBuilder\MySQL\QueryComponent\Traits;

    use Luna\Entity\Entity;

    trait From
    {
        /** @var string */
        protected $fromQuery;

        /** @var array */
        protected $fromPart = [];

        /* -------------------------------------------------------------------------- */
        /* QUERY */

        /**
         * FROM Part
         *
         * @param string $table
         * @param string|null $alias
         *
         * @return self
         */
        public function from(string $table, string $alias = NULL): self
        {
            if (class_exists($table) && is_a($table, Entity::class)) {
                /** @var Entity $entity */
                $entity = new $table();
                $table = $entity->getTable();
            }

            $fromQuery = $table;
            if(!is_null($alias)) {
                $fromQuery .= " {$alias}";
            }

            array_push($this->fromPart, $fromQuery);

            return $this;
        }


        /* -------------------------------------------------------------------------- */
        /* PREPARE QUERY */

        protected function prepareFromPart()
        {
            $this->fromQuery = 'FROM ';
            $this->fromQuery .= implode(', ', $this->fromPart);
            $this->fromQuery = " {$this->fromQuery} ";
        }
    }
?>