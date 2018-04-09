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

    use Luna\Component\Exception\QueryComponentException;

    trait Values
    {
        /** @var string */
        protected static $VALUE_METHOD = 'Value';

        /** @var string */
        protected static $VALUES_METHOD = 'Values';

        /** @var ?string */
        protected $insertMethod = NULL;

        /** @var array */
        protected $insertColumns = [];

        /** @var string */
        protected $valuesQuery;

        /** @var array */
        protected $valuePart = [];

        /** @var array */
        protected $valuesPart = [];

        /** @var array */
        protected $paramsBag = [];

        /** @var int */
        protected $count = 0;

        /* -------------------------------------------------------------------------- */
        /* QUERY */

        /**
         * VALUE Part
         *
         * @param string $key
         * @param $value
         *
         * @return self
         */
        public function value(string $key, $value): self
        {
            if (is_null($this->insertMethod) || $this->insertMethod == self::$VALUE_METHOD) {
                if (is_null($this->insertMethod)) {
                    $this->insertMethod = self::$VALUE_METHOD;
                }

                $this->paramsBag[$key] = $value;
                array_push($this->insertColumns, $key);
                array_push($this->valuePart, ":{$key}");
            }

            return $this;
        }

        /**
         * VALUES Part
         *
         * @param array $datas
         *
         * @return self
         */
        public function values(array $datas): self
        {
            if (is_null($this->insertMethod) || $this->insertMethod == self::$VALUES_METHOD) {
                if (is_null($this->insertMethod)) {
                    $this->insertMethod = self::$VALUES_METHOD;

                    $keys = array_keys($datas);
                    $this->insertColumns = $keys;
                }

                foreach ($datas as &$key => &$value) { $key = ":{$key}_{$this->count}"; }
                unset($key);
                unset($value);
                $this->count++;

                $this->paramsBag = array_merge($this->paramsBag, $datas);

                $keys = array_keys($datas);
                $valuesString = implode(', ', $keys);
                $valuesString = "({$valuesString})";
                array_push($this->valuesPart, $valuesString);
            }

            return $this;
        }


        /* -------------------------------------------------------------------------- */
        /* PREPARE QUERY */

        /**
         * @throws QueryComponentException
         */
        protected function prepareValuesPart()
        {
            $this->valuesQuery = 'VALUES ';

            switch ($this->insertMethod) {
                case self::$VALUE_METHOD:
                    $this->valuesQuery .= implode(', ', $this->valuePart);
                    $this->valuesQuery = "({$this->valuesQuery})";
                    break;

                case self::$VALUES_METHOD:
                    $this->valuesQuery .= implode(', ', $this->valuesPart);
                    $this->valuesQuery = " {$this->valuesQuery} ";
                    break;

                default:
                    throw new QueryComponentException("You can't validate the insert query because no values ​​have been inserted");
            }
        }
    }
?>