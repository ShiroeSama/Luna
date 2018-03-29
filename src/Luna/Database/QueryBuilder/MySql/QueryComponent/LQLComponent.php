<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : LQLComponent.php
     *   @Created_at : 29/03/2018
     *   @Update_at : 29/03/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Database\QueryBuilder\MySQL\QueryComponent;

    use Luna\Database\QueryBuilder\MySQL\QueryBuilder;

    class LQLComponent extends AbstractComponent
    {
        /**
         * LQLComponent constructor.
         *
         * @param QueryBuilder $builder
         * @param string $queryString
         */
        public function __construct(QueryBuilder $builder, string $queryString)
        {
            parent::__construct($builder);
            $this->queryString = $queryString;
        }
    }
?>