<?php

    /**
     * --------------------------------------------------------------------------
     *   @Copyright : License MIT 2017
     *
     *   @Author : Alexandre Caillot
     *   @WebSite : https://www.shiros.fr
     *
     *   @File : ParameterBag.php
     *   @Created_at : 19/04/2018
     *   @Update_at : 07/05/2018
     * --------------------------------------------------------------------------
     */

    namespace Luna\Component\Bag;

    class ParameterBag implements \IteratorAggregate, \Countable
    {
        /**
         * Parameter storage.
         */
        protected $parameters;

        /**
         * @param array $parameters
         */
        public function __construct(array $parameters = [])
        {
            $this->parameters = $parameters;
        }

        /**
         * Returns the parameters.
         *
         * @return array
         */
        public function all()
        {
            return $this->parameters;
        }

        /**
         * Returns the parameter keys.
         *
         * @return array
         */
        public function keys()
        {
            return array_keys($this->parameters);
        }

        /**
         * Replaces the current parameters by a new set.
         *
         * @param array $parameters
         */
        public function replace(array $parameters = [])
        {
            $this->parameters = $parameters;
        }

        /**
         * Add some elements in the Bag
         *
         * @param array $parameters
         */
        public function add(array $parameters = [])
        {
            $this->parameters = array_merge($this->parameters, $parameters);
        }

        /**
         * Add an element in the Bag
         *
         * @param mixed $key
         * @param mixed $value
         *
         * @return self
         */
        public function set($key, $value): self
        {
            $this->parameters[$key] = $value;

            return $this;
        }

        /**
         * Returns an element of the Bag, but if doesn't exist a default value is returned
         *
         * @param mixed $key
         * @param mixed $default
         *
         * @return mixed
         */
        public function get($key, $default = NULL)
        {
            return array_key_exists($key, $this->parameters) ? $this->parameters[$key] : $default;
        }

        /**
         * Check if an element exist in the Bag
         *
         * @param mixed $key
         *
         * @return bool
         */
        public function has($key): bool
        {
            if (is_array($key)) {
                foreach ($key as $value) {
                    if (!array_key_exists($value, $this->parameters)) {
                        return false;
                    }
                }

                return true;
            } else {
                return array_key_exists($key, $this->parameters);
            }
        }

        /**
         * Removes a parameter of the Bag
         *
         * @param mixed $key
         */
        public function remove($key): void
        {
            unset($this->parameters[$key]);
        }

        /**
         * Returns an iterator for parameters
         *
         * @return \Iterator
         */
        public function getIterator(): \Iterator
        {
            return new \ArrayIterator($this->parameters);
        }

        /**
         * Returns the size of the Bag
         *
         * @return int
         */
        public function count(): int
        {
            return count($this->parameters);
        }

        /**
         * Check if the Bag is empty
         *
         * @return bool
         */
        public function isEmpty(): bool
        {
            return empty($this->parameters);
        }
    }
?>
