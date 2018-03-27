<?php
	
	/**
	 * --------------------------------------------------------------------------
	 *   @Copyright : License MIT 2017
	 *
	 *   @Author : Alexandre Caillot
	 *   @WebSite : https://www.shiros.fr
	 *
	 *   @File : MySQLQueryBuilder.php
	 *   @Created_at : 10/03/2018
	 *   @Update_at : 10/03/2018
	 * --------------------------------------------------------------------------
	 */
	
	namespace Luna\Database\QueryBuilder;
	
	
	use Luna\Entity\Entity;

    class MySQLQueryBuilder
	{
		/** @var string */
		protected $entityName;
		
		/** @var string */
		protected $queryString;
		
		/** @var string */
		protected $querySelectPart;
		
		/** @var string */
		protected $queryFromPart;
		
		/** @var string */
		protected $queryLeftJoinPart;
		
		/** @var string */
		protected $queryWherePart;
		
		/** @var string */
		protected $queryOrderByPart;
		
		/** @var string */
		protected $queryGroupByPart;
		
		/**
		 * MySQLQueryBuilder constructor.
         *
		 * @param string $entityName
		 */
		public function __construct(string $entityName)
		{
			$this->entityName = $entityName;
		}
		
		/**
		 * SELECT Part
		 *
		 * @param string $condition
		 * @return MySQLQueryBuilder
		 */
		public function select(string $condition): MySQLQueryBuilder
		{
			if (is_null($this->querySelectPart)) {
                $this->querySelectPart = "SELECT {$condition}";
            } else {
                $this->querySelectPart .= ", {$condition}";
            }
			
			return $this;
		}

        /**
         * FROM Part
         *
         * @param string $table
         * @param string|null $alias
         * @return MySQLQueryBuilder
         */
		public function from(string $table, string $alias = NULL): MySQLQueryBuilder
		{
            if (class_exists($table) && is_a($table, Entity::class)) {
                /** @var Entity $entity */
                $entity = new $table();
                $table = $entity->getTable();
            }

			if (is_null($this->queryFromPart)) {
				$this->queryFromPart = "FROM {$table}";
			} else {
				$this->queryFromPart .= ", {$table}";
			}

			if(!is_null($alias)) {
                $this->queryFromPart .= " {$alias}";
            }
			
			return $this;
		}
		
		/**
		 * LEFT JOIN Part
		 *
		 * @param string $table
		 * @param string $keyword
		 * @param string $condition
		 *
		 * @return MySQLQueryBuilder
		 */
		public function leftJoin(string $table, string $keyword, string $condition): MySQLQueryBuilder
		{
			if (is_null($this->queryLeftJoinPart)) {
				$this->queryLeftJoinPart = "LEFT JOIN {$table} {$keyword} {$condition}";
			} else {
				$this->queryLeftJoinPart .= " LEFT JOIN {$table} {$keyword} {$condition}";
			}
			
			return $this;
		}
		
		
		/**
		 * WHERE Part
		 *
		 * @param string $condition
		 * @return MySQLQueryBuilder
		 */
		public function where(string $condition): MySQLQueryBuilder
		{
			$this->queryWherePart = "WHERE {$condition}";
			return $this;
		}
		
		
		/**
		 * AND WHERE Part
		 * @param string $condition
		 * @return MySQLQueryBuilder
		 */
		public function andWhere(string $condition): MySQLQueryBuilder
		{
			if (is_null($this->queryWherePart)) {
				$this->where($condition);
			} else {
				$this->queryWherePart .= "AND {$condition}";
			}
			
			return $this;
		}
		
		
		/**
		 * OF WHERE Part
		 * @param string $condition
		 * @return MySQLQueryBuilder
		 */
		public function orWhere(string $condition): MySQLQueryBuilder
		{
			if (is_null($this->queryWherePart)) {
				$this->where($condition);
			} else {
				$this->queryWherePart .= "OR {$condition}";
			}
			
			return $this;
		}
		
		
		/**
		 * ORDER BY Part
		 *
		 * @param string $condition
		 * @return MySQLQueryBuilder
		 */
		public function orderBy(string $condition): MySQLQueryBuilder
		{
			$this->queryOrderByPart = "ORDER BY {$condition}";
			
			return $this;
		}
		
		
		/**
		 * GROUP BY Part
		 *
		 * @param string $condition
		 * @return MySQLQueryBuilder
		 */
		public function groupBy(string $condition): MySQLQueryBuilder
		{
			$this->queryGroupByPart = "GROUP BY {$condition}";
			
			return $this;
		}
		
		
		/**
		 * Luna Query Language
		 *
		 * @param string $queryString
		 * @return MySQLQueryBuilder
		 */
		public function lql(string $queryString) : MySQLQueryBuilder
		{
			$this->queryString = $queryString;
			return $this;
		}
		
		
		/**
		 * @return MySQLQuery
		 */
		public function getQuery(): MySQLQuery
		{
			if (is_null($this->queryString)) {
				$this->queryString = $this->querySelectPart
					. $this->queryFromPart
					. $this->queryLeftJoinPart
					. $this->queryWherePart
					. $this->queryOrderByPart
					. $this->queryGroupByPart;
			}
			
			$this->queryString = trim($this->queryString);
			
			return new MySQLQuery($this->entityName, $this->queryString);
		}
	}
?>