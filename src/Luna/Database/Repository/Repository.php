<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : Repository.php
	 *   @Created_at : 02/12/2017
	 *   @Update_at : 11/03/2018
	 * --------------------------------------------------------------------------
	 */
	
	namespace Luna\Database\Repository;
	
	use Luna\Component\Exception\RepositoryException;
    use Luna\Entity\Entity;

    interface Repository
	{
        /**
         * @return array
         */
        public function findAll(): array;


        /**
         * @param array $criteria
         * @param string|NULL $orderBy
         * @param bool $strict
         * @return array
         */
        public function findBy(array $criteria = [], string $orderBy = NULL, bool $strict = false): array;


        /**
         * @param array $criteria
         * @param bool $strict
         * @return array|mixed
         */
        public function findOneBy(array $criteria = [], bool $strict = false);


        /**
         * @return int
         */
        public function count(): int;


        /**
         * @param Entity $entity
         *
         * @return Entity
         *
         * @throws RepositoryException
         * @throws \Luna\Component\Exception\DBException
         */
        public function insert(Entity $entity): Entity;


        /**
         * @param string $entity
         * @param array $entities
         *
         * @return Entity
         *
         * @throws RepositoryException
         * @throws \Luna\Component\Exception\DBException
         * @throws \Luna\Component\Exception\QueryComponentException
         */
        public function inserts(string $entity, array $entities): Entity;


        /**
         * @param Entity $entity
         * @param string $idName
         *
         * @return Entity
         *
         * @throws RepositoryException
         * @throws \Luna\Component\Exception\DBException
         * @throws \Luna\Component\Exception\QueryComponentException
         */
        public function delete(Entity $entity, string $idName): Entity;
    }
?>