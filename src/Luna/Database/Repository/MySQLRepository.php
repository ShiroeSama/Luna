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
	    protected $entity;

        protected function createBuilder(): QueryBuilder
        {
            return new QueryBuilder($this->entity);
        }

        /**
         * @return array
         *
         * @throws RepositoryException
         */
        public function findAll(): array
        {
            if (is_null($this->entity)) {
                throw new RepositoryException('Entity var is not define');
            }

            return $this->createBuilder()
                ->select('*')
                ->from($this->entity)
                ->getQuery()
                ->getResult();
        }


        /**
         * @param array $criteria
         * @param string|NULL $orderBy
         * @param bool $one
         * @param bool $strict
         *
         * @return array|mixed
         *
         * @throws RepositoryException
         * @throws \Luna\Component\Exception\DBException
         */
        protected function find(array $criteria = [], string $orderBy = NULL, bool $one = false, bool $strict = false)
        {
            if (is_null($this->entity)) {
                throw new RepositoryException('Entity var is not define');
            }

            $queryBuilder = $this->createBuilder()
                ->select('*')
                ->from($this->entity);

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


        /**
         * @param array $criteria
         * @param string|NULL $orderBy
         * @param bool $strict
         *
         * @return array
         *
         * @throws RepositoryException
         * @throws \Luna\Component\Exception\DBException
         */
        public function findBy(array $criteria = [], string $orderBy = NULL, bool $strict = false): array
        {
            return $this->find($criteria, $orderBy, false, $strict);
        }


        /**
         * @param array $criteria
         * @param bool $strict
         *
         * @return array|mixed
         *
         * @throws RepositoryException
         * @throws \Luna\Component\Exception\DBException
         */
        public function findOneBy(array $criteria = [], bool $strict = false)
        {
            return $this->find($criteria, NULL, true, $strict);
        }


        /**
         * @return int
         *
         * @throws RepositoryException
         * @throws \Luna\Component\Exception\DBException
         */
        public function count(): int
        {
            if (is_null($this->entity)) {
                throw new RepositoryException('Entity var is not define');
            }

            return $this->createBuilder()
                ->select('count(*) as length')
                ->from($this->entity)
                ->validate()
                ->getQuery()
                ->setFetchMode(Query::FETCH_ASSOC)
                ->getResult(true)['length'];
        }


        /**
         * @param Entity $entity
         *
         * @return Entity
         *
         * @throws RepositoryException
         * @throws \Luna\Component\Exception\DBException
         */
        public function insert(Entity $entity): Entity
        {
            if (is_null($this->entity)) {
                throw new RepositoryException('Entity var is not define');
            }

            $reflectionClass = new ReflectionClass($this->entity);
            $properties = $reflectionClass->getProperties();

            $builderQuery = $this->createBuilder()
                ->insert(get_class($this->entity));

            $values = [];
            /** @var ReflectionProperty $property */
            foreach ($properties as $property) {
                $propertyName = ucfirst($property->getName());

                $method = "get{$propertyName}";
                if (!method_exists($entity, $method)) {
                    throw new RepositoryException('Entity '.  get_class($entity) . " haven't getter for attribute $propertyName");
                }

                $value = $entity->$method();
                array_push($values, $value);
            }

            $resultId = $builderQuery->validate()
                ->getQuery()
                ->getResult();

            return $this->findOneBy(['id' => $resultId]);
        }
    }
?>