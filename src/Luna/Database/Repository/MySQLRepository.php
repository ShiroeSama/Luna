<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : MySQLRepository.php
	 *   @Created_at : 24/11/2016
	 *   @Update_at : 27/03/2017
	 * --------------------------------------------------------------------------
	 */

	namespace Luna\Database\Repository;

    use Luna\Component\Exception\RepositoryException;
    use \ReflectionClass;
    use \ReflectionProperty;
    use Luna\Database\QueryBuilder\MySQL\Query;
    use Luna\Database\QueryBuilder\MySQL\QueryBuilder;
    use Luna\Entity\Entity;

    class MySQLRepository implements Repository
	{
	    /** @var string */
	    protected $entityName;




        /* -------------------------------------------------------------------------- */
        /* FIND REQUEST */

        /**
         * FIND ALL
         *
         * @return array
         *
         * @throws RepositoryException
         * @throws \Luna\Component\Exception\DBException
         * @throws \Luna\Component\Exception\QueryComponentException
         */
        public function findAll(): array
        {
            if (is_null($this->entityName)) {
                throw new RepositoryException('Entity name is not define');
            }

            return $this->createBuilder()
                ->select('*')
                ->from($this->entityName)
                ->validate()
                ->getQuery()
                ->getResult();
        }

        /**
         * FIND BY
         *
         * @param array $criteria
         * @param string|NULL $orderBy
         * @param bool $strict
         *
         * @return array
         *
         * @throws RepositoryException
         * @throws \Luna\Component\Exception\DBException
         * @throws \Luna\Component\Exception\QueryComponentException
         */
        public function findBy(array $criteria = [], string $orderBy = NULL, bool $strict = false): array
        {
            return $this->find($criteria, $orderBy, false, $strict);
        }

        /**
         * FIND ONE BY
         *
         * @param array $criteria
         * @param bool $strict
         *
         * @return array|mixed
         *
         * @throws RepositoryException
         * @throws \Luna\Component\Exception\DBException
         * @throws \Luna\Component\Exception\QueryComponentException
         */
        public function findOneBy(array $criteria = [], bool $strict = false)
        {
            return $this->find($criteria, NULL, true, $strict);
        }




        /* -------------------------------------------------------------------------- */
        /* COUNT REQUEST */

        /**
         * COUNT
         *
         * @return int
         *
         * @throws RepositoryException
         * @throws \Luna\Component\Exception\DBException
         * @throws \Luna\Component\Exception\QueryComponentException
         */
        public function count(): int
        {
            if (is_null($this->entityName)) {
                throw new RepositoryException('Entity name is not define');
            }

            return $this->createBuilder()
                ->select('count(*) as length')
                ->from($this->entityName)
                ->validate()
                ->getQuery()
                ->setFetchMode(Query::FETCH_ASSOC)
                ->getResult(true)['length'];
        }




        /* -------------------------------------------------------------------------- */
        /* INSERT REQUEST */

        /**
         * @param Entity $entity
         *
         * @return Entity
         *
         * @throws RepositoryException
         * @throws \Luna\Component\Exception\DBException
         * @throws \Luna\Component\Exception\QueryComponentException
         */
        public function insert(Entity $entity): Entity
        {
            // Get the Object Property
            $reflectionClass = new ReflectionClass($entity);
            $properties = $reflectionClass->getProperties();


            // Prepare the Insert Component
            $builderQuery = $this->createBuilder()->insert(get_class($entity));


            // Call all getters to prepare the values ​​to insert
            /** @var ReflectionProperty $property */
            foreach ($properties as $property) {
                $propertyName = ucfirst($property->getName());

                $method = "get{$propertyName}";
                if (!method_exists($entity, $method)) {
                    throw new RepositoryException('Entity '.  get_class($entity) . " haven't getter for attribute $propertyName");
                }

                $value = $entity->$method();
                $builderQuery->value($propertyName, $value);
            }

            // Exec the Query
            return $builderQuery->validate()
                ->getQuery()
                ->getResult(true);
        }




        /* -------------------------------------------------------------------------- */
        /* SETTINGS */

        /**
         * Create the Query Builder
         *
         * @return QueryBuilder
         */
        protected function createBuilder(): QueryBuilder
        {
            return new QueryBuilder($this->entityName);
        }

        /**
         * FIND
         *
         * @param array $criteria
         * @param string|NULL $orderBy
         * @param bool $one
         * @param bool $strict
         *
         * @return array|mixed
         *
         * @throws RepositoryException
         * @throws \Luna\Component\Exception\DBException
         * @throws \Luna\Component\Exception\QueryComponentException
         */
        protected function find(array $criteria = [], string $orderBy = NULL, bool $one = false, bool $strict = false)
        {
            if (is_null($this->entityName)) {
                throw new RepositoryException('Entity name is not define');
            }

            $queryBuilder = $this->createBuilder()
                ->select('*')
                ->from($this->entityName);

            if (!empty($criteria)) {
                $whereKey = array_search(reset($criteria), $criteria);

                $searchParam = ":$whereKey";
                if (!$strict) {
                    $searchParam = "CONCAT(\"%\",{$searchParam},\"%\")";
                }

                $queryBuilder->where("$whereKey LIKE $searchParam");

                $andWhereArray = $criteria;
                unset($andWhereArray[$whereKey]);

                foreach ($andWhereArray as $key => $value) {
                    $searchParam = ":$whereKey";
                    if (!$strict) {
                        $searchParam = "CONCAT(\"%\",{$searchParam},\"%\")";
                    }
                    $queryBuilder->and();
                    $queryBuilder->where("$whereKey LIKE $searchParam");
                }
            }

            if (!is_null($orderBy)) {
                $queryBuilder->orderBy(":$orderBy");
            }

            $rawQuery = $queryBuilder->validate()->getQuery();
            $preparedQuery = $rawQuery->setParameters($criteria);

            return $preparedQuery->getResult($one);
        }
    }
?>